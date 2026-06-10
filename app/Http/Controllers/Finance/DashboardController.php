<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $transactions = \App\Models\Transaction::orderByDesc('date')->get();
        $totalRevenue = $transactions->where('type', \App\Enums\TransactionType::Revenue)->sum('amount');
        $totalExpense = $transactions->where('type', \App\Enums\TransactionType::Expense)->sum('amount');
        $totalRefund = $transactions->where('type', \App\Enums\TransactionType::Refund)->sum('amount');
        $netProfit = $totalRevenue - $totalExpense - $totalRefund;
        
        return view('finance.dashboard', compact('transactions', 'totalRevenue', 'totalExpense', 'netProfit'));
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $data = $request->validate([
            'date' => 'required|date',
            'description' => 'required|string',
            'type' => 'required|string|in:Revenue,Expense,Refund',
            'amount' => 'required|numeric',
            'method' => 'required|string',
        ]);
        $data['status'] = 'Completed';
        \App\Models\Transaction::create($data);
        return back()->with('success', 'Transaction added successfully.');
    }
}
