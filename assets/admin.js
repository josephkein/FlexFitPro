

function loadDashboard(){

    fetch('./api/dashboard-api.php', {
        method: 'POST',
        headers: { 'Content-Type' : 'application/json'},
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('total_revenue').textContent = `$${data.total}`;
        document.getElementById('year').textContent = data.year;
        document.getElementById('monthly_visit').textContent = data.monthly_visit;
        document.getElementById('daily_revenue').textContent = `$${data.daily}`;
        document.getElementById('total_visit').textContent = data.total_visit;

        const options = {
            chart: {
                type: 'area',
                height: 350
            },
            series: [{
                name: 'Revenue',
                data: data.monthly_revenue
            }],
            colors:['#7F22FE'],
            xaxis: {
                categories: [
                'Jan','Feb','Mar','Apr','May','Jun',
                'Jul','Aug','Sep','Oct','Nov','Dec'
                ]
            },
            colors: ['#7C3AED'], // violet-600 to match your sidebar
            stroke: {
                curve: 'smooth',
                width: 3
            },
            fill: {
                type: 'gradient',
                gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.6,
                opacityTo: 0.1,
                stops: [0, 90, 100]
                }
            },
            dataLabels: {
                enabled: false
            },
            grid: {
                borderColor: '#E5E7EB'
            }
        };

        const chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();

        var options2 = {
            chart: {
                type: 'bar',
                height: 350
            },
            series: [{
                name: 'Revenue',
                data: data.daily_visit
            }],
            colors:['#7F22FE'],
            xaxis: {
            categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            }
            };

            var chart2 = new ApexCharts(document.querySelector("#visitsChart"), options2);
            chart2.render();
        
    })
}
loadDashboard();

