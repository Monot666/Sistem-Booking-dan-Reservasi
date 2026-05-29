document.addEventListener('DOMContentLoaded', function() {
    
    /* ==========================================
       1. KONFIGURASI GRAFIK (CHART.JS)
       ========================================== */
    
    Chart.defaults.color = '#94a3b8';
    Chart.defaults.font.family = 'inherit';

    // GRAFIK 1: Profit Trend (Line Chart)
    const ctxProfit = document.getElementById('profitLineChart');
    if (ctxProfit) {
        let gradientFill = ctxProfit.getContext('2d').createLinearGradient(0, 0, 0, 300);
        gradientFill.addColorStop(0, 'rgba(245, 158, 11, 0.4)');
        gradientFill.addColorStop(1, 'rgba(245, 158, 11, 0.0)');

        new Chart(ctxProfit, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Net Profit (Rp)',
                    // Data disesuaikan menjadi nominal Rupiah
                    data: [12000000, 19000000, 14000000, 25000000, 22000000, 32000000],
                    borderColor: '#f59e0b',
                    backgroundColor: gradientFill,
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#f59e0b',
                    pointBorderWidth: 2,
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { border: { display: false }, grid: { color: '#f1f5f9' }, beginAtZero: true },
                    x: { border: { display: false }, grid: { display: false } }
                }
            }
        });
    }

    // GRAFIK 2: Monthly Performance (Bar Chart)
    const ctxPerform = document.getElementById('performanceBarChart');
    if (ctxPerform) {
        new Chart(ctxPerform, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [
                    {
                        label: 'Revenue (Rp)',
                        // Data disesuaikan menjadi nominal Rupiah
                        data: [25000000, 32000000, 28000000, 40000000, 38000000, 45000000],
                        backgroundColor: '#10b981',
                        borderRadius: 4
                    },
                    {
                        label: 'Expenses (Rp)',
                        // Data disesuaikan menjadi nominal Rupiah
                        data: [13000000, 13000000, 14000000, 15000000, 16000000, 13000000],
                        backgroundColor: '#f43f5e',
                        borderRadius: 4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'top', align: 'end', labels: { usePointStyle: true, boxWidth: 8 } }
                },
                scales: {
                    y: { border: { display: false }, grid: { color: '#f1f5f9' }, beginAtZero: true },
                    x: { border: { display: false }, grid: { display: false } }
                }
            }
        });
    }

    /* ==========================================
       2. FITUR FILTER TABEL TRANSAKSI
       ========================================== */
    const catFilter = document.getElementById('catFilter');
    const timeFilter = document.getElementById('timeFilter');
    const tbody = document.getElementById('transactionBody');
    
    if (tbody) {
        let rows = Array.from(tbody.querySelectorAll('.transaction-row'));

        function parseDate(dateStr) {
            const parts = dateStr.split('-');
            return new Date(parts[2], parts[1] - 1, parts[0]);
        }

        function applyFilters() {
            const selectedCat = catFilter.value;
            const selectedTime = timeFilter.value;

            // Sorting
            rows.sort(function(a, b) {
                const dateA = parseDate(a.querySelector('.tx-date').innerText);
                const dateB = parseDate(b.querySelector('.tx-date').innerText);

                if (selectedTime === 'newest') return dateB - dateA;
                if (selectedTime === 'oldest') return dateA - dateB;
                return 0;
            });

            tbody.innerHTML = '';
            rows.forEach(row => tbody.appendChild(row));

            // Filtering
            rows.forEach(function(row) {
                const rowCat = row.getAttribute('data-category');
                if (selectedCat === 'all' || rowCat === selectedCat) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        if(catFilter && timeFilter) {
            catFilter.addEventListener('change', applyFilters);
            timeFilter.addEventListener('change', applyFilters);
        }
    }
});