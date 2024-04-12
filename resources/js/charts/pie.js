import PieChart from 'chart.js/auto';

document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('pieChart');
    
    const data = {
        labels: [
          'Booking',
          'WhatsApp',
          'Llamada',
          'Facebook',
          'Calle',
        ],
        datasets: [{
          label: 'Origen',
          data: [300, 50, 100, 30, 123],
          backgroundColor: [
            'rgb(255, 99, 132)',
            'rgb(54, 162, 235)',
            'rgb(255, 205, 86)',
            'rgb(75, 192, 192)',
            'rgb(153, 102, 255)',
          ],
          hoverOffset: 4
        }]
    };
    
    new PieChart(ctx, {
        type: 'doughnut',
        data: data,
    });

});