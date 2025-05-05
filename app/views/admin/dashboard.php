<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TESTAMENT</title>
    <link rel="stylesheet" href="assets/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0">
    <link rel="icon" href="assets/images/Testament_Logo.png" sizes="any">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="text/javascript" src="assets/js/sidebar.js" defer></script>
    <script>
        try {
            if (localStorage.getItem("sidebar-collapsed") === "true") {
                document.write('<body class="sb-collapse">');
            } else {
                document.write('<body>');
            }
        } catch (e) {
            document.write('<body>');
        }
    </script>
</head>
<body>

<?php include __DIR__ . '/../layouts/adminsideNav.php'; ?>

<main class="dashboard">
    <div class="card totalItems">
        <p>Total Product</p>
        <p id="productCounts">30</p>
    </div>
    <div class="card registerdUser">
        <p>Registered Users</p>
        <p id="rUsersCounts">21,450</p>
    </div>
    <div class="card orders">
        <p><a href="#">Total Orders</a></p>
        <p id="orderCounts">5,050</p>
    </div>

    <!--WEEKLY SALES-->
    <div class="weeklyCard weeklyStats">
        <h2 class="weekly-line-title">Weekly Sales</h2>
        <canvas id="salesLineChart" height="100"></canvas>
    </div>
    <script>
        const wChart = document.getElementById('salesLineChart').getContext('2d');

        const lineChart = new Chart(wChart, {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    "label": 'Sales ($)',
                    "data": [1150, 1001, 845, 1500, 510, 1320, 2210],
                    "backgroundColor": 'rgba(16, 185, 129, 0.2)',
                    "borderColor": '#10b981',
                    "borderWidth": 2,
                    "tension": 0.4,
                    "pointRadius": 5,
                    "pointBackgroundColor": '#10b981',
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: value => `₱ ${value}`
                        }
                    }
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: context => `Sales: $${context.parsed.y}`
                        }
                    }
                }
            }
        });
        async function fetchSalesData() {
            try {
                const response = await fetch('sales-data.php');
                const data = await response.json();

                lineChart.data.labels = data.labels;
                lineChart.data.datasets[0].data = data.sales;
                lineChart.update();
            } catch (error) {
                console.error("Failed to load sales data", error);
            }
        }

        fetchSalesData();
        setInterval(fetchSalesData, 10000);
    </script>







    <!--DAILY SALES-->
    <div class="daily-chart-card ">
        <div class="chart-titles">Daily Sales</div>
        <canvas id="salesDonutChart" height="100"></canvas>
    </div>
    <script>
        const ctx = document.getElementById('salesDonutChart').getContext('2d');

        const donutChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    data: [100, 200, 100, 25, 650, 299, 120],
                    backgroundColor: [
                        '#10b981', '#3b82f6', '#f59e0b', '#ef4444',
                        '#8b5cf6', '#54213a', '#a4cb18'
                    ],
                    hoverOffset: 15
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#374151',
                            font: {
                                size: 14
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: context => `${context.label}: ₱ ${context.raw}`
                        }
                    }
                }
            }
        });


        async function fetchSalesData() {
            try {
                const response = await fetch('sales-data.php');
                const data = await response.json();

                donutChart.data.labels = data.labels;
                donutChart.data.datasets[0].data = data.sales;
                donutChart.update();
            } catch (error) {
                console.error("Failed to fetch data:", error);
            }
        }


        fetchSalesData();
        setInterval(fetchSalesData, 10000);
    </script>

    </div>

</main>
</body>
</html>