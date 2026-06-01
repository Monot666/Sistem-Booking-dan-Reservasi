document.addEventListener("DOMContentLoaded", function () {
    
    // Konfigurasi Font Global Chart
    Chart.defaults.font.family = "'Inter', sans-serif";
    Chart.defaults.color = "#94a3b8";

    // --- LOGIKA TOMBOL SAVE DATA ---
    const btnSaveData = document.getElementById('btnSaveData');
    if (btnSaveData) {
        btnSaveData.addEventListener('click', function() {
            // Simpan teks asli
            const originalText = this.innerHTML;
            
            // Ubah menjadi loading spinner
            this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Saving...';
            this.disabled = true;

            // Simulasi proses delay 1 detik, lalu sukses
            setTimeout(() => {
                this.innerHTML = '<i class="fas fa-check me-2 text-success"></i> <span class="text-success">Saved!</span>';
                this.style.borderColor = '#10b981'; // Ubah border jadi hijau
                
                // Kembalikan ke semula setelah 2 detik
                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.style.borderColor = '#cbd5e1';
                    this.disabled = false;
                }, 2000);
            }, 1000);
        });
    }

    // 1. Line Chart (Profit Trend)
    const ctxLine = document.getElementById('profitLineChart');
    if (ctxLine) {
        new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Net Profit',
                    data: [35000, 42000, 58000, 35000, 40000, 55000],
                    borderColor: '#df9e4c',
                    backgroundColor: 'transparent',
                    borderWidth: 2,
                    pointBackgroundColor: '#1e293b',
                    pointBorderColor: '#df9e4c',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    tension: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { 
                        beginAtZero: true, 
                        grid: { color: '#f1f5f9' },
                        ticks: { stepSize: 15000 }
                    },
                    x: { grid: { display: false } }
                }
            }
        });
    }

    // 2. Bar Chart (Monthly Performance)
    const ctxBar = document.getElementById('performanceBarChart');
    if (ctxBar) {
        new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [
                    {
                        label: 'Revenue',
                        data: [75000, 85000, 115000, 70000, 80000, 110000],
                        backgroundColor: '#00d25b',
                        barPercentage: 0.6,
                    },
                    {
                        label: 'Expense',
                        data: [45000, 50000, 58000, 35000, 40000, 45000],
                        backgroundColor: '#fc424a',
                        barPercentage: 0.6,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { 
                        beginAtZero: true, 
                        grid: { color: '#f1f5f9' },
                        ticks: { stepSize: 30000 }
                    },
                    x: { grid: { display: false } }
                }
            }
        });
    }
});