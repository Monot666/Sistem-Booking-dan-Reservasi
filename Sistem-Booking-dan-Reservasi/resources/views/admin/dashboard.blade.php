@extends('layouts.sidebar_admin')

@section('content')
<div class="max-w-7xl mx-auto">
    <header class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
        <p class="text-gray-500">Welcome back! Here's an overview of your hotel.</p>
    </header>

    <div class="grid grid-cols-4 gap-6 mb-10">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <p class="text-gray-400 text-sm font-semibold">Total Revenue</p>
            <h3 class="text-2xl font-bold text-gray-800">$67,000</h3>
            <p class="text-green-500 text-xs mt-2 font-medium">↑ 12.5% from last month</p>
        </div>
        </div>

    <div class="grid grid-cols-2 gap-8 mb-10">
        <div class="bg-white p-6 rounded-2xl shadow-sm">
            <h4 class="font-bold mb-4">Revenue Overview</h4>
            <canvas id="revenueChart" height="200"></canvas>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm">
            <h4 class="font-bold mb-4">Bookings Trend</h4>
            <canvas id="bookingsChart" height="200"></canvas>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Contoh sederhana Chart.js untuk Revenue Overview
    const ctx = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Revenue',
                data: [40000, 55000, 45000, 60000, 60000, 75000],
                borderColor: '#e6a04d',
                tension: 0.4,
                fill: false
            }]
        }
    });
</script>
@endpush