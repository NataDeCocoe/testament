const ctx = document.getElementById('salesDonutChart').getContext('2d');
const centerTextPlugin = {
    id: 'centerText',
    beforeDraw(chart) {
        const { ctx, chartArea: { width, height }, data } = chart;


        const today = new Date().getDay();

        const todayIndex = today === 0 ? 6 : today - 1;


        const todaySales = data.datasets[0].data[todayIndex] || 0;


        ctx.save();


        ctx.font = 'bold 20px Poppins, sans-serif';
        ctx.fillStyle = '#374151';
        ctx.textAlign = 'center';
        ctx.textBaseline = 'middle';


        ctx.fillText('₱' + todaySales.toFixed(2), width / 2, height / 2 - 10);


        ctx.font = '12px Poppins, sans-serif';
        ctx.fillText("Today's Sales", width / 2, height / 2 + 15);


        ctx.restore();
    }
};

const donutChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        datasets: [{
            data: [],
            backgroundColor: [
                '#10b981', '#3b82f6', '#f59e0b', '#ef4444',
                '#8b5cf6', '#54213a', '#a4cb18'
            ],
            hoverOffset: 15
        }]
    },
    options: {
        responsive: true,
        cutout: '65%',
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    color: '#374151',
                    font: {
                        size: 14,
                        family: 'Poppins, sans-serif'
                    }
                }
            },
            tooltip: {
                callbacks: {
                    label: context => `${context.label}: ₱ ${context.raw.toFixed(2)}`
                },
                bodyFont: {
                    family: 'Poppins, sans-serif'
                }
            }
        }
    },
    plugins: [centerTextPlugin]
});

async function fetchSalesData() {
    try {
        const response = await fetch('/sales/daily');
        const contentType = response.headers.get('content-type');

        if (!contentType || !contentType.includes('application/json')) {
            const text = await response.text();
            throw new Error(`Invalid response: ${text.substring(0, 100)}`);
        }

        const data = await response.json();

        if (!data.success) {
            throw new Error(data.message || 'Request failed');
        }

        donutChart.data.labels = data.data.labels;
        donutChart.data.datasets[0].data = data.data.sales;
        donutChart.update();

    } catch (error) {
        console.error("Failed to load sales data:", error);
        const errorElement = document.getElementById('chart-error');
        if (errorElement) {
            errorElement.textContent = `Error: ${error.message}`;
            errorElement.style.display = 'block';
        }
    }
}


fetchSalesData();
setInterval(fetchSalesData, 10000);