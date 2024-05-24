import PieChart from 'chart.js/auto';

document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('pieChart');
    const values = [
        window.origins.booking,
        window.origins.whatsapp,
        window.origins.llamada,
        window.origins.facebook,
        window.origins.calle,
        window.origins.hostalworld
    ];
    const data = {
        labels: [
          'Booking',
          'WhatsApp',
          'Llamada',
          'Facebook',
          'Calle',
          'HostalWorld'
        ],
        datasets: [{
          label: 'Total',
          data: values,
          backgroundColor: [
            'rgb(255, 99, 132)',
            'rgb(54, 162, 235)',
            'rgb(255, 205, 86)',
            'rgb(75, 192, 192)',
            'rgb(153, 102, 255)',
            'rgb(255, 159, 64)',
          ],
          hoverOffset: 4
        }]
    };
    
    new PieChart(ctx, {
        type: 'doughnut',
        data: data,
    });

});