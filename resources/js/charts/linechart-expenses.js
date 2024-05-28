import Chart from 'chart.js/auto';

const ctx = document.getElementById('lineChartExpenses');
const dayWeeks = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
const months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
let expenses = window.expenses;

if(expenses !== undefined)
{
  if(expenses.length === 7) {
    var labels = dayWeeks;
    var label = 'Egresos de la semana';
  }else{
    var labels = months;
    var label = 'Egresos del mes';
  }
  expenses = Object.values(expenses);
  console.log(expenses)
  
  const data = {
    labels: labels,
    datasets: [{
      label: label,
      data: expenses,
      fill: false,
      borderColor: 'rgb(75, 192, 192)',
      tension: 0.1
    }]
  };
  
  const stackedLine = new Chart(ctx, {
      type: 'line',
      data: data,
      options: {
          scales: {
              y: {
                  stacked: true
              }
          }
      }
  });
}
