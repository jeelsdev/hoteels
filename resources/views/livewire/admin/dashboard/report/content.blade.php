<div class="grid grid-cols-1 gap-6 mb-6 w-full md:grid-cols-2 lg:grid-cols-2">
    @script
       <script>
            window.reservationsForDay = @json($reservationsForDay);
            window.origins = @json($origins);
        </script>
    @endscript
    <div class="bg-white rounded-sm p-4 ">
        <div class="flex items-center">
            <div class="flex-shrink-0 ml-3">
                <h3 class="text-base font-normal text-gray-500">Origen</h3>
            </div>
        </div>
        <div class="w-10/12 lg:w-7/12 m-auto my-5" >
            <canvas id="pieChart"></canvas>
        </div>
    </div>
    <div class="bg-white rounded-sm p-4 ">
        <div class="flex items-center">
            <div class="flex-shrink-0 ml-3">
                <h3 class="text-base font-normal text-gray-500">Reservas de la semana</h3>
            </div>
        </div>
        <div class="w-full m-auto my-5" >
            <canvas id="barChart"></canvas>
        </div>
    </div>
    <div class="bg-white rounded-sm p-4 ">
        <div class="flex items-center">
            <div class="flex-shrink-0 ml-3">
                <h3 class="text-base font-normal text-gray-500">Reservas por mes</h3>
            </div>
        </div>
        <div class="w-full m-auto my-5" >
            <canvas id="barChartForMonth"></canvas>
        </div>
    </div>
    <div class="bg-white rounded-sm p-4 ">
        <div class="flex items-center">
            <div class="flex-shrink-0 ml-3">
                <h3 class="text-base font-normal text-gray-500">Productos mas vendidos</h3>
            </div>
        </div>
        <div class="w-10/12 lg:w-7/12 m-auto my-5" >
            <canvas id="pieChartProducts"></canvas>
        </div>
    </div>
</div>