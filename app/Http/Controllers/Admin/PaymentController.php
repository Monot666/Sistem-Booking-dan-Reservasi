<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

/**
 * Admin controller for viewing payment/financial data.
 */
class PaymentController extends Controller
{
    /**
     * Display the finance overview with all payments.
     */
    public function index()
    {
        $transactions = \App\Models\Transaction::orderByDesc('date')->get();

        $totalRevenue = $transactions->where('type', \App\Enums\TransactionType::Revenue)->sum('amount');
        $totalExpense = $transactions->where('type', \App\Enums\TransactionType::Expense)->sum('amount');
        $totalRefund = $transactions->where('type', \App\Enums\TransactionType::Refund)->sum('amount');
        $netProfit = $totalRevenue - $totalExpense - $totalRefund;

        return view('admin.finance', compact('transactions', 'totalRevenue', 'totalExpense', 'netProfit'));
    }
}
