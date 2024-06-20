import Chart from "chart.js/auto";

const barChartPanel = document.getElementById("barChartPanel");
let chartInit;

Livewire.on("panelCharts", (data) => {
    const labels = getLabels(data[0].dayRange);
    const datasets = getDatasets(data[0].dayRange, data[0].data);

    if (chartInit) {
        chartInit.data.labels = labels;
        chartInit.data.datasets = datasets;
        chartInit.update();
    }else {
        chartInit = createChart(labels, datasets);
    }    
});

const getDatasets = (dayRange, data) => {
    if(dayRange === "week") {
        return [
            {
                label: "Ingresos de la semana",
                data: Object.values(data.income),
                borderColor: "#82d616",
                backgroundColor: "#82d616",
                fill: false,
            },
            {
                label: "Egresos de la semana",
                data: Object.values(data.expenses),
                borderColor: "#ea0606",
                backgroundColor: "#ea0606",
                fill: false,
            },
        ];
    }else {
        return [
            {
                label: "Ingresos del mes",
                data: Object.values(data.income),
                borderColor: "#82d616",
                backgroundColor: "#82d616",
                fill: false,
            },
            {
                label: "Egresos del mes",
                data: Object.values(data.expenses),
                borderColor: "#ea0606",
                backgroundColor: "#ea0606",
                fill: false,
            },
        ];
    
    }
}

const getLabels = (dayRange) => {
    if (dayRange === "week") {
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
}

const createChart = (labels, datasets) => {
    return new Chart(barChartPanel, {
        type: "bar",
        data: {
            labels: labels,
            datasets: datasets,
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: "top",
                }
            },
        },
    });
}
