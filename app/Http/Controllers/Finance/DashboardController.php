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
        $chartLabels = [];
        $chartRevenue = [];
        $chartExpense = [];
        $chartProfit = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthName = $date->format('M');
            
            // Filter transactions for this specific month
            $monthlyTx = $transactions->filter(function($t) use ($date) {
                return \Carbon\Carbon::parse($t->date)->format('Y-m') === $date->format('Y-m');
            });

            $mRev = $monthlyTx->whereIn('type', [\App\Enums\TransactionType::Revenue, 'Revenue'])->sum('amount');
            $mExp = $monthlyTx->whereIn('type', [\App\Enums\TransactionType::Expense, 'Expense'])->sum('amount');
            $mRef = $monthlyTx->whereIn('type', [\App\Enums\TransactionType::Refund, 'Refund'])->sum('amount');
            
            $mExpTotal = $mExp + $mRef;
            $mProfit = $mRev - $mExpTotal;

            $chartLabels[] = $monthName;
            $chartRevenue[] = $mRev;
            $chartExpense[] = $mExpTotal;
            $chartProfit[] = $mProfit;
        }
        
        return view('finance.dashboard', compact(
            'transactions', 'totalRevenue', 'totalExpense', 'netProfit',
            'chartLabels', 'chartRevenue', 'chartExpense', 'chartProfit'
        ));
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
