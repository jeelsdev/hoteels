import Chart from "chart.js/auto";

const ctx = document.getElementById("lineChartExpenses");
let chartInit;

Livewire.on("barChartExpenses", (data) => {
    const dayRange = data[0].dayRange;
    const labels = getLabels(dayRange);

    if(chartInit){
        chartInit.data.labels = labels;
        chartInit.data.datasets = [{
            label: 'Egresos del mes',
            data: Object.values(data[0].expenses)
        }];
        chartInit.update();
    }else{
      chartInit = createChart({
          labels: labels,
          datasets: [{
            label: 'Egresos del mes',
            data: Object.values(data[0].expenses)
          }],
      });
    }
});

const getLabels = (dayRange) => {
    if (dayRange === "week" || dayRange === "day") {
        return [
            "Domingo",
            "Lunes",
            "Martes",
            "Miércoles",
            "Jueves",
            "Viernes",
            "Sábado",
        ];
    } else {
        return [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre",
        ];
    }
};

const createChart = (data) => {
    return new Chart(ctx, {
        type: "bar",
        data: data,
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                },
            },
        },
    });
};
