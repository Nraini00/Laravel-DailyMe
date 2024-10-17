<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    // Index page
    public function index()
    {
        $wallets = Wallet::where('user_id', Auth::id())
                        ->orderBy('date', 'desc')  // Ensure the wallets are ordered by date in descending order
                        ->get();
        
        return view('main.wallet', ['wallets' => $wallets]);  // Pass data to the view

    }
    

    // Store a new wallet entry
    public function store(Request $request)
    {
        $request->validate([
            'details' => 'required',
            'amount' => 'required|numeric',
            'date' => 'required|date'
        ]);

        // Get the last wallet entry
        $lastWallet = Wallet::where('user_id', auth()->id())->latest('date')->first();
        $newBalance = $lastWallet ? $lastWallet->balance + $request->amount : $request->amount;

        // Add a new wallet entry
        $wallet = new Wallet();
        $wallet->user_id = auth()->id();
        $wallet->details = $request->details;
        $wallet->amount = $request->amount;
        $wallet->date = $request->date;
        $wallet->balance = $newBalance;

        $wallet->save();

        return redirect()->route('wallet.index')->with('success', 'Wallet amount added successfully!');
    }

    // View the wallet entry for edit
    public function edit($id)
    {
        $wallet = Wallet::findOrFail($id);
        return view('main.wallet_edit', compact('wallet'));
    }

    // Update the wallet entry
    public function update(Request $request, $id)
    {
        $request->validate([
            'details' => 'required',
            'amount' => 'required|numeric',
            'date' => 'required|date'
        ]);

        $wallet = Wallet::findOrFail($id);
        $oldAmount = $wallet->amount; // Store the old amount
        $wallet->details = $request->details;
        $wallet->amount = $request->amount;
        $wallet->date = $request->date;

        // Update the balance
        $wallet->save();

        // Calculate the balance adjustment
        $balanceAdjustment = $request->amount - $oldAmount;
        $this->updateSubsequentBalances($wallet->user_id, $wallet->date, $balanceAdjustment);

        return redirect()->route('wallet.index')->with('success', 'Wallet updated successfully!');
    }

    // Helper function to update balances after this entry
    private function updateSubsequentBalances($userId, $date, $balanceAdjustment)
    {
        $subsequentWallets = Wallet::where('user_id', $userId)
            ->where('date', '>', $date)
            ->orderBy('date')
            ->get();

        foreach ($subsequentWallets as $subWallet) {
            $subWallet->balance += $balanceAdjustment;
            $subWallet->save();
        }
    }

    // Delete wallet entry
    public function destroy(Wallet $wallet)
    {
        $balanceAdjustment = -$wallet->amount;

        // Delete the wallet entry
        $wallet->delete();

        // Update subsequent wallet entries' balances after deletion
        $this->updateSubsequentBalances($wallet->user_id, $wallet->date, $balanceAdjustment);

        return redirect()->route('wallet.index')->with('success', 'Wallet deleted successfully!');
    }
}
