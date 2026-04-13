
    const options = {
        chart: {
            type: 'area',
            height: 350
        },
        series: [{
            name: 'Revenue',
            data: [4000, 1500, 2000, 3800, 3550, 5400, 1200, 2400, 2800, 1400, 3200, 4200]
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
            data: [100, 78, 67, 34, 50, 105, 89]
        }],
        colors:['#7F22FE'],
        xaxis: {
          categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        }
        };

        var chart2 = new ApexCharts(document.querySelector("#visitsChart"), options2);
        chart2.render();