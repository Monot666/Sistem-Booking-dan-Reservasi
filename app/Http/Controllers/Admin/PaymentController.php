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
        $transactions = \App\Models\Transaction::orderByDesc('created_at')->get();

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

            $mRev = $monthlyTx->where('type', \App\Enums\TransactionType::Revenue)->sum('amount');
            $mExp = $monthlyTx->where('type', \App\Enums\TransactionType::Expense)->sum('amount');
            $mRef = $monthlyTx->where('type', \App\Enums\TransactionType::Refund)->sum('amount');
            
            $mExpTotal = $mExp + $mRef;
            $mProfit = $mRev - $mExpTotal;

            $chartLabels[] = $monthName;
            $chartRevenue[] = $mRev;
            $chartExpense[] = $mExpTotal;
            $chartProfit[] = $mProfit;
        }

        return view('admin.finance', compact(
            'transactions', 'totalRevenue', 'totalExpense', 'netProfit',
            'chartLabels', 'chartRevenue', 'chartExpense', 'chartProfit'
        ));
    }

    public function export(\Illuminate\Http\Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $query = \App\Models\Transaction::query();
        
        if ($startDate) {
            $query->whereDate('date', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('date', '<=', $endDate);
        }

        $transactions = $query->orderByDesc('created_at')->get()->map(function($t) {
            return [
                'ID Transaksi' => $t->id,
                'Tanggal' => \Carbon\Carbon::parse($t->date)->format('d-m-Y'),
                'Deskripsi' => $t->description,
                'Tipe' => $t->type->value ?? $t->type,
                'Nominal (Rp)' => $t->amount,
                'Metode' => $t->method,
                'Status' => $t->status
            ];
        });

        return response()->json($transactions);
    }
}
