<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Category;
use App\Models\Event;
use App\Models\Apparel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BudgetController extends Controller
{
    // index page
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
        // Get the 5 latest transactions
        $latestTransactions = Budget::where('user_id', auth()->id())
            ->with('category')
            ->orderBy('date', 'desc') 
            ->take(5) // Limit to 5 transactions
            ->get();


        // chart data logic for pie chart
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


        // chart logic for spending by month
        $spendingByMonth = Budget::select(
            DB::raw('SUM(amount) as total_spent'),
            DB::raw('MONTH(date) as month'),
            DB::raw('YEAR(date) as year')
        )
        ->where('user_id', auth()->id())
        ->whereYear('date', 2024) // Filter for the year 2024
        ->groupBy(DB::raw('YEAR(date)'), DB::raw('MONTH(date)'))
        ->orderBy(DB::raw('YEAR(date)'))
        ->orderBy(DB::raw('MONTH(date)')) // Order by month
        ->get();

        // Prepare data for the monthly chart
        $months = $spendingByMonth->map(function ($item) {
            // Format month as "Month 1", "Month 2", etc.
            return "Month " . $item->month;
        })->toArray();
        
        $totalSpentByMonth = $spendingByMonth->pluck('total_spent')->toArray();

        $chartDataMonth = [
            'months' => $months,
            'totalSpent' => $totalSpentByMonth,
        ];

        
        // Calculate total spending on apparel, event and budget for the user
        $totalApparelCount = Apparel::where('user_id', auth()->id())->count();
        $totalEventCount = Event::where('user_id', auth()->id())->count();
        $totalSpendingCount = Budget::where('user_id', auth()->id())
        ->sum('amount');

        // Pass the data to the dashboard view
        return view('main.dashboard', [
            'latestTransactions' => $latestTransactions,
            'chartDataCategory' => $chartDataCategory,
            'chartDataMonth' => $chartDataMonth,
            'totalApparelCount' => $totalApparelCount, // Pass total apparel spent to the view
            'totalEventCount' => $totalEventCount,
            'totalSpendingCount' => $totalSpendingCount
        ]);
    }

    


    // to create the budget
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'title' => 'required',
            'amount' => 'required',
            'date' => 'required',
            'remarks' => 'nullable',
            'event_id' => 'nullable',
            'apparel_id' => 'nullable',
        ]);

        Budget::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'title' => $request->title,
            'amount' => $request->amount,
            'date' => $request->date,
            'remarks' => $request->remarks,
            'event_id' => $request->event_id,
            'apparel_id' => $request->apparel_id,
        ]);

        return redirect()->route('budget.index')->with('success', 'Budget added successfully.');
    }

    // view the budget for edit
    public function edit($id)
    {
        $budget = Budget::findOrFail($id);
        $categories = Category::all();
        $events = Event::all();
        $apparels = Apparel::all();

        return view('main.budget_edit', compact('budget', 'categories', 'events', 'apparels'));
    }

    // updating the budget
    public function update(Request $request, Budget $budget)
    {
        $request->validate([
            'category_id' => 'required',
            'title' => 'required',
            'amount' => 'required',
            'date' => 'required',
            'remarks' => 'nullable',
            'event_id' => 'nullable',
            'apparel_id' => 'nullable',
        ]);

        if ($budget->user_id !== auth()->id()) {
            return redirect()->route('budget.index')->with('error', 'Unauthorized action.');
        }

        $budget->update([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'amount' => $request->amount,
            'date' => $request->date,
            'remarks' => $request->remarks,
            'event_id' => $request->event_id,
            'apparel_id' => $request->apparel_id,
        ]);

        return redirect()->route('budget.index')->with('success', 'Budget updated successfully!');
    }

    // delete the budget
    public function destroy(Budget $budget)
    {
        $budget->delete();

        return redirect()->route('budget.index')->with('success', 'Budget deleted successfully.');
    }
}
