<div class="min-w-full">
    @script
        <script>
            window.rooms = @json($rooms);
            window.reservations = @json($reservations);
        </script>
    @endscript

    <div class="calendar-container">
        <div id="calendar"></div>
    </div>

</div>
