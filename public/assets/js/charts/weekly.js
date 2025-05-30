const wChart = document.getElementById('salesLineChart').getContext('2d');

const lineChart = new Chart(wChart, {
    type: 'line',
    data: {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        datasets: [{
            "label": 'Sales (₱)',
            "data": [],
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
                    label: context => `Sales: ₱${context.parsed.y}`
                }
            }
        }
    }
});
async function fetchSalesData() {
    try {
        const response = await fetch('/sales/weekly');
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