<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Category;
use App\Models\Event;
use App\Models\Wallet;
use App\Models\Apparel;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BudgetController extends Controller
{
    // Index page
    public function index()
    {
        $budgets = Budget::with('category', 'event', 'apparel')->where('user_id', auth()->id())->get();
        $categories = Category::all();
        $events = Event::all();
        $apparels = Apparel::all();

        return view('main.budget', compact('budgets', 'categories', 'events', 'apparels'));
    }

    // Dashboard for latest transactions, pie chart
    public function dashboard1()
    {
        $latestTransactions = Budget::where('user_id', auth()->id())
            ->with('category')
            ->orderBy('date', 'desc')
            ->take(5)
            ->get();

        $spendingByCategory = Budget::select(
            DB::raw('SUM(amount) as total_spent'),
            'category_id'
        )
        ->where('user_id', auth()->id())
        ->groupBy('category_id')
        ->with('category')
        ->get();

        $chartDataCategory = $spendingByCategory->map(function ($budget) {
            return [
                'category' => $budget->category->name,
                'total_spent' => $budget->total_spent
            ];
        })->toArray();

        $spendingByMonth = Budget::select(
            DB::raw('SUM(amount) as total_spent'),
            DB::raw('MONTH(date) as month'),
            DB::raw('YEAR(date) as year')
        )
        ->where('user_id', auth()->id())
        ->whereYear('date', 2024)
        ->groupBy(DB::raw('YEAR(date)'), DB::raw('MONTH(date)'))
        ->orderBy(DB::raw('YEAR(date)'))
        ->orderBy(DB::raw('MONTH(date)'))
        ->get();

        $months = $spendingByMonth->map(function ($item) {
            return "Month " . $item->month;
        })->toArray();
        
        $totalSpentByMonth = $spendingByMonth->pluck('total_spent')->toArray();

        $chartDataMonth = [
            'months' => $months,
            'totalSpent' => $totalSpentByMonth,
        ];

        $totalApparelCount = Apparel::where('user_id', auth()->id())->count();
        $totalEventCount = Event::where('user_id', auth()->id())->count();
        $totalSpendingCount = Budget::where('user_id', auth()->id())
            ->sum('amount');

        // wallet
        // Get the last wallet entry
        $lastWallet = Wallet::where('user_id', auth()->id())->latest('date')->first();
        $newBalance = $lastWallet ? $lastWallet->balance : 0;
        return view('main.dashboard', [
            'balance' => $newBalance,
            'latestTransactions' => $latestTransactions,
            'chartDataCategory' => $chartDataCategory,
            'chartDataMonth' => $chartDataMonth,
            'totalApparelCount' => $totalApparelCount,
            'totalEventCount' => $totalEventCount,
            'totalSpendingCount' => $totalSpendingCount
        ]);
    }

    // Storing a new budget and deducting from wallet balance
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'title' => 'required',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'remarks' => 'nullable',
            'event_id' => 'nullable',
            'apparel_id' => 'nullable',
            'attachment' => 'nullable|file'
        ]);

        // Create the budget record
        $budget = Budget::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'title' => $request->title,
            'amount' => $request->amount,
            'date' => $request->date,
            'remarks' => $request->remarks,
            'event_id' => $request->event_id,
            'apparel_id' => $request->apparel_id,
        ]);

        // Deduct the amount from the wallet
        $this->updateWalletBalance(-$request->amount);

        // Handle file attachment
        if ($request->hasFile('attachment')) {
            $filePath = $request->file('attachment')->store('attachments', 'public');
            $budget->attachment = $filePath;
            $budget->save();
        }

        return redirect()->route('budget.index')->with('success', 'Budget added successfully.');
    }

    // View the budget for edit
    public function edit($id)
    {
        $budget = Budget::findOrFail($id);
        $categories = Category::all();
        $events = Event::all();
        $apparels = Apparel::all();

        return view('main.budget_edit', compact('budget', 'categories', 'events', 'apparels'));
    }

    // Updating the budget and adjusting the wallet balance
    public function update(Request $request, Budget $budget)
    {
        $request->validate([
            'category_id' => 'required',
            'title' => 'required',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'remarks' => 'nullable',
            'event_id' => 'nullable',
            'apparel_id' => 'nullable',
            'attachment' => 'nullable|file'
        ]);

        if ($budget->user_id !== auth()->id()) {
            return redirect()->route('budget.index')->with('error', 'Unauthorized action.');
        }

        // Calculate wallet adjustment
        $amountDifference = $request->amount - $budget->amount;
        $this->updateWalletBalance(-$amountDifference);

        // Update the budget record
        $budget->update([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'amount' => $request->amount,
            'date' => $request->date,
            'remarks' => $request->remarks,
            'event_id' => $request->event_id,
            'apparel_id' => $request->apparel_id,
        ]);

        // Handle file upload if a new file is present
        if ($request->hasFile('attachment')) {
            if ($budget->attachment) {
                Storage::disk('public')->delete($budget->attachment); // Delete old file
            }
            $filePath = $request->file('attachment')->store('attachments', 'public');
            $budget->attachment = $filePath;
            $budget->save();
        }

        return redirect()->route('budget.index')->with('success', 'Budget updated successfully!');
    }

    // Delete the budget
    public function destroy(Budget $budget)
    {
        if ($budget->user_id !== auth()->id()) {
            return redirect()->route('budget.index')->with('error', 'Unauthorized action.');
        }

        // Restore the budget amount to the user's wallet
        $this->updateWalletBalance($budget->amount);

        // Delete the budget record and attachment if it exists
        if ($budget->attachment) {
            Storage::disk('public')->delete($budget->attachment);
        }
        $budget->delete();

        return redirect()->route('budget.index')->with('success', 'Budget deleted successfully.');
    }

    // Helper function to update wallet balance
    private function updateWalletBalance($amount)
    {
        $user = Auth::user();
        $wallet = $user->wallet()->latest('date')->first(); // Ensure you're getting the latest wallet record

        if ($wallet) {
            $wallet->balance += $amount;
            $wallet->save();
        }
    }
}
