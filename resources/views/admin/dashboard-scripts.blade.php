@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Revenue Chart
            const revenueCtx = document.getElementById('revenueChart');
            if (revenueCtx) {
                new Chart(revenueCtx, {
                    type: 'line',
                    data: {
                        labels: {!! json_encode($revenueByMonth->pluck('month')) !!},
                        datasets: [{
                            label: 'Revenue',
                            data: {!! json_encode($revenueByMonth->pluck('revenue')) !!},
                            borderColor: '#667eea',
                            backgroundColor: 'rgba(102, 126, 234, 0.1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4,
                            pointRadius: 5,
                            pointBackgroundColor: '#667eea',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: '#1e293b',
                                padding: 12,
                                titleColor: '#fff',
                                bodyColor: '#fff',
                                borderColor: '#667eea',
                                borderWidth: 1,
                                displayColors: false,
                                callbacks: {
                                    label: function (context) {
                                        return '$' + context.parsed.y.toLocaleString();
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.05)'
                                },
                                ticks: {
                                    callback: function (value) {
                                        return '$' + value.toLocaleString();
                                    }
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            }

            // Order Status Chart
            const statusCtx = document.getElementById('orderStatusChart');
            if (statusCtx) {
                const statusData = {!! json_encode($ordersByStatus) !!};
                new Chart(statusCtx, {
                    type: 'doughnut',
                    data: {
                        labels: statusData.map(s => s.status.charAt(0).toUpperCase() + s.status.slice(1)),
                        datasets: [{
                            data: statusData.map(s => s.count),
                            backgroundColor: [
                                '#f59e0b',
                                '#10b981',
                                '#ef4444',
                                '#3b82f6'
                            ],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: '#1e293b',
                                padding: 12,
                                titleColor: '#fff',
                                bodyColor: '#fff',
                                borderColor: '#667eea',
                                borderWidth: 1
                            }
                        },
                        cutout: '70%'
                    }
                });
            }
        });
    </script>
@endpush