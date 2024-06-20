import Chart from "chart.js/auto";

const lineChartPanel = document.getElementById("lineChartPanel");
let chartSet;

Livewire.on('panelCharts', (data) => {
    if(data[0].dayRange === "week") {
        var labels = [
            "Domingo",
            "Lunes",
            "Martes",
            "Miércoles",
            "Jueves",
            "Viernes",
            "Sábado",
        ];

        var datasets = [
            {
                label: "Ingresos de la semana",
                data: Object.values(data[0].data.income),
                borderColor: "#82d616",
                fill: false,
            },
            {
                label: "Egresos de la semana",
                data: Object.values(data[0].data.expenses),
                borderColor: "#ea0606",
                fill: false,
            },
        ];

    }else {
        var labels = [
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

        var datasets = [
            {
                label: "Ingresos del mes",
                data: Object.values(data[0].data.income),
                borderColor: "#82d616",
                fill: false,
            },
            {
                label: "Egresos del mes",
                data: Object.values(data[0].data.expenses),
                borderColor: "#ea0606",
                fill: false,
            },
        ];
    }

    if(chartSet) {
        chartSet.data.labels = labels;
        chartSet.data.datasets = datasets;
        chartSet.update();
    }else{
        chartSet = createChart(labels, datasets);
    }
});

function createChart(labels, datasets) {
    return new Chart(lineChartPanel, {
        type: "line",
        data: {
            labels: labels,
            datasets: datasets,
        },
        options: {
            legend: { display: false },
        },
    });
}

