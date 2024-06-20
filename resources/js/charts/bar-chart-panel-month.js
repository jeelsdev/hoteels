import BarChart from 'chart.js/auto';

const ctx = document.getElementById('barChartForMonth');
const labels = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

Livewire.on('barChartPanelMonth', (reservations) => {
    let reservations_ = reservations[0].reservations;
    const values = [
        reservations_.January,
        reservations_.February,
        reservations_.March,
        reservations_.April,
        reservations_.May,
        reservations_.June,
        reservations_.July,
        reservations_.August,
        reservations_.September,
        reservations_.October,
        reservations_.November,
        reservations_.December
    ];
    const data = {
    labels: labels,
    datasets: [{
        label: 'N° de reservas por mes',
        data: values,
        backgroundColor: [
        'rgb(255, 99, 132)',
        'rgb(255, 159, 64)',
        'rgb(255, 205, 86)',
        'rgb(75, 192, 192)',
        'rgb(54, 162, 235)',
        'rgb(153, 102, 255)',
        'rgb(201, 203, 207)',
        'rgb(255, 99, 132)',
        'rgb(255, 159, 64)',
        'rgb(255, 205, 86)',
        'rgb(75, 192, 192)',
        ],
        borderColor: [
        'rgb(255, 99, 132)',
        'rgb(255, 159, 64)',
        'rgb(255, 205, 86)',
        'rgb(75, 192, 192)',
        'rgb(54, 162, 235)',
        'rgb(153, 102, 255)',
        'rgb(201, 203, 207)',
        'rgb(255, 99, 132)',
        'rgb(255, 159, 64)',
        'rgb(255, 205, 86)',
        'rgb(75, 192, 192)',
        'rgb(54, 162, 235)'
        ],
        borderWidth: 1
    }]
    };

    new BarChart(ctx, {
        type: 'bar',
        labels: labels,
        data: data,
        options: {
        scales: {
            y: {
            beginAtZero: true
            }
        }
        },
    });
});