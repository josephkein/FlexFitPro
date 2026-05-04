
if (window.isAdmin){
    function loadDashboard(){

        fetch('./api/dashboard-api.php', {
            method: 'POST',
            headers: { 'Content-Type' : 'application/json'},
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('total_revenue').textContent = `₱${Number(data.total).toLocaleString()}`;
            document.getElementById('year').textContent = data.year;
            document.getElementById('monthly_visit').textContent = data.monthly_visit;
            document.getElementById('daily_revenue').textContent = `₱${Number(data.daily).toLocaleString()}`;
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
                colors: ['#5D0EC0'], // violet-600 to match your sidebar
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
                colors:['#5D0EC0'],
                xaxis: {
                categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                }
                };

                var chart2 = new ApexCharts(document.querySelector("#visitsChart"), options2);
                chart2.render();
            
        })
    }
    loadDashboard();

}

const actData = [
        { type: 'visit',    name: 'Maria Santos',     desc: 'Walk-in payment collected',           time: '14 min ago', badge: '₱70'    },
        { type: 'membership', name: 'Carlo Reyes',      desc: 'Subscribed to Basic plan — 1 month', time: '41 min ago', badge: '₱800'   },
        { type: 'visit',    name: 'Rodel Bautista',   desc: 'Walk-in payment — student',          time: '2 hrs ago',  badge: '₱50'    },
    ];
    
    const colors = {
        visit:    { icon: 'bg-green-100 text-green-700',   badge: 'bg-green-100 text-green-700'   },
        membership: { icon: 'bg-orange-100 text-orange-600', badge: 'bg-orange-100 text-orange-600' },
    };
    
    const icons = {
        visit:    `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="17" height="17"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>`,
        membership: `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="17" height="17"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 3H8L2 7h20z"/></svg>`,
    };

    function loadTransactions(){
        fetch('./api/recent_trans.php')
        .then(res => res.json())
        .then(data => {
            renderAct(data);
        })
    }

    
    function renderAct(data) {
        const list = document.getElementById('actList');
        list.innerHTML = '';
        data.forEach((d) => {
            const date = new Date(d.time.replace(" ", "T"));
            const formatted = date.toLocaleString("en-US", {
                year: "numeric",
                month: "long",
                day: "numeric",
                hour: "numeric",
                minute: "2-digit",
                hour12: true
            });
            list.innerHTML += `
            <div class="flex items-center gap-3 px-2 py-2 rounded-xl hover:bg-violet-50 transition-colors">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0 ${colors[d.payment_type].icon}">
                    ${icons[d.payment_type]}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="text-lg font-medium text-gray-800 truncate">${d.name}</div>
                    <div class="text-md text-gray-400 mt-0.5">${d.payment_type == 'visit' ? 'Walk-in payment collected' : 'Membership subscription collected'}</div>
                </div>
                <div class="text-right flex-shrink-0">
                    <div class="text-md text-gray-400 mb-1">${formatted}</div>
                    <span class="text-md font-medium px-2 py-0.5 rounded-full ${colors[d.payment_type].badge}">${d.payment_type}</span>
                </div>
            </div>
        `;
        });

        
    }
    
    loadTransactions();

function loadCards(){

        fetch('./api/dashboard-api.php', {
            method: 'POST',
            headers: { 'Content-Type' : 'application/json'},
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('available_trainers').textContent = data.available;
            document.getElementById('today_revenue').textContent = `₱${Number(data.daily).toLocaleString()}`;
            document.getElementById('today_visit').textContent = data.today;
            
        })
    }
    loadCards();

// var map = L.map('map').setView([10.3845, 124.9828], 13);

// L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
//     maxZoom: 19,
//     attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
// }).addTo(map);

// function onMapClick(e) {
//     var marker = L.marker([e.latlng.lat,e.latlng.lng]).addTo(map);
//     marker.bindPopup("<b>Soophia Bh!</b><br>I am a popup.").openPopup();

// }

// map.on('click', onMapClick);