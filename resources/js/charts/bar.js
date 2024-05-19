import BarChart from 'chart.js/auto';

document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('barChart');
    const labels = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
    const values = [
        window.reservationsForDay.Monday,
        window.reservationsForDay.Tuesday,
        window.reservationsForDay.Wednesday,
        window.reservationsForDay.Thursday,
        window.reservationsForDay.Friday,
        window.reservationsForDay.Saturday,
        window.reservationsForDay.Sunday
    ];
    const data = {
    labels: labels,
    datasets: [{
        label: 'N° de reservas',
        data: values,
        backgroundColor: [
        'rgba(255, 99, 132, 0.2)',
        'rgba(255, 159, 64, 0.2)',
        'rgba(255, 205, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(201, 203, 207, 0.2)'
        ],
        borderColor: [
        'rgb(255, 99, 132)',
        'rgb(255, 159, 64)',
        'rgb(255, 205, 86)',
        'rgb(75, 192, 192)',
        'rgb(54, 162, 235)',
        'rgb(153, 102, 255)',
        'rgb(201, 203, 207)'
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