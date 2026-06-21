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

        $refundRequests = \App\Models\Booking::where('refund_status', 'requested')->with('user')->get();
        
        return view('finance.dashboard', compact(
            'transactions', 'totalRevenue', 'totalExpense', 'netProfit',
            'chartLabels', 'chartRevenue', 'chartExpense', 'chartProfit', 'refundRequests'
        ));
    }

    public function confirmRefund($id)
    {
        \Illuminate\Support\Facades\Log::info("Confirm Refund Hit for ID: " . $id);
        $booking = \App\Models\Booking::findOrFail($id);
        
        abort_if($booking->refund_status !== 'requested', 400, 'Invalid refund request.');

        // Update via Eloquent
        $booking->refund_status = 'completed';
        $booking->save();

        // Update via DB Query to be absolutely sure
        \Illuminate\Support\Facades\DB::table('bookings')->where('id', $id)->update(['refund_status' => 'completed']);
        
        \Illuminate\Support\Facades\Log::info("Refund status set to completed in DB for ID: " . $id);

        \App\Models\Transaction::create([
            'booking_id'  => $booking->id,
            'date'        => now(),
            'description' => 'Refund Confirmed - BK' . str_pad($booking->id, 3, '0', STR_PAD_LEFT),
            'type'        => \App\Enums\TransactionType::Refund,
            'amount'      => $booking->total_price,
            'method'      => $booking->refund_payment_method ?? 'Bank Transfer',
            'status'      => 'Completed',
        ]);

        try {
            $recipientEmail = $booking->email ?? ($booking->user ? $booking->user->email : null);
            if ($recipientEmail) {
                \Illuminate\Support\Facades\Mail::to($recipientEmail)->send(new \App\Mail\RefundConfirmed($booking));
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Mail Error (Refund): ' . $e->getMessage());
        }

        return back()->with('success', 'Refund telah dikonfirmasi dan dicatat ke dalam transaksi pengeluaran.');
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

    public function update(\Illuminate\Http\Request $request, $id)
    {
        $transaction = \App\Models\Transaction::findOrFail($id);
        abort_if($transaction->booking_id !== null, 403, 'Automated booking transactions cannot be edited manually.');
        
        $data = $request->validate([
            'date' => 'required|date',
            'description' => 'required|string',
            'type' => 'required|string|in:Revenue,Expense,Refund',
            'amount' => 'required|numeric',
            'method' => 'required|string',
        ]);
        $transaction->update($data);
        return back()->with('success', 'Transaction updated successfully.');
    }

    public function destroy($id)
    {
        $transaction = \App\Models\Transaction::findOrFail($id);
        abort_if($transaction->booking_id !== null, 403, 'Automated booking transactions cannot be deleted manually.');
        
        $transaction->delete();
        return back()->with('success', 'Transaction deleted successfully.');
}
}