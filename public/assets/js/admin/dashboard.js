// Konfigurasi Global Chart.js untuk menghilangkan grid
Chart.defaults.scale.grid.display = false;
Chart.defaults.plugins.legend.display = false; // Sembunyikan legenda atas

// Grafik Pendapatan (Line Chart)
new Chart(document.getElementById('revenueChart'), {
    type: 'line',
    data: { 
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'], 
        datasets: [{ 
            data: [40, 55, 45, 60, 60, 75], 
            borderColor: '#d48c34', 
            backgroundColor: '#d48c34',
            borderWidth: 2,
            pointRadius: 4, 
            tension: 0.1 
        }] 
    },
    options: { 
        responsive: true,
        maintainAspectRatio: false 
    }
});

// Grafik Tren Pemesanan (Bar Chart)
new Chart(document.getElementById('bookingTrend'), {
    type: 'bar',
    data: { 
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'], 
        datasets: [{ 
            data: [100, 140, 110, 150, 150, 180], 
            backgroundColor: '#e2a856',
            barThickness: 30
        }] 
    },
    options: { 
        responsive: true,
        maintainAspectRatio: false 
    }
});

// Grafik Hunian (Doughnut Chart)
new Chart(document.getElementById('occupancyChart'), {
    type: 'doughnut',
    data: { 
        labels: ['Terisi', 'Tersedia'], 
        datasets: [{ 
            data: [150, 50], 
            backgroundColor: ['#d48c34', '#eaedf1'], 
            borderWidth: 0
        }] 
    },
    options: { 
        responsive: true,
        maintainAspectRatio: false,
        cutout: '65%' 
    }
});