import pieChart from 'chart.js/auto';

const ctx = document.getElementById('pieChartProducts');

Livewire.on('pieChartProducts', (products) => {
    const values = [];
    const labels = [];
    const prods = products[0].products;
    for (const key in prods) {
        if (Object.hasOwnProperty.call(prods, key)) {
            const element = prods[key];
            labels.push(element.productName);
            values.push(element.total);
        }
    }
    const data = {
        labels: labels,
        datasets: [{
          label: '',
          data: values,
          backgroundColor: [
            'rgb(255, 99, 132)',
            'rgb(54, 162, 235)',
            'rgb(255, 205, 86)',
            'rgb(75, 192, 192)',
            'rgb(255, 159, 64)',
            'rgb(153, 102, 255)',
          ],
          hoverOffset: 4
        }]
      };

    new pieChart(ctx, {
        type: 'pie',
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