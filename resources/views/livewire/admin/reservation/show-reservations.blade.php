<div class="min-w-full">
    @script
        <script>
            window.rooms = @json($rooms);
            window.reservations = @json($reservations);
        </script>
    @endscript

    <livewire:admin.reservation.edit-reservation />
    
    <div class="calendar-container">
        <div id="calendar"></div>
    </div>

    @script
        <script>
            window.handleEventClick = (info) => {
                console.log(info)
                $wire.dispatch('abrir-modal-evento', { data: info });
                console.log("evento clickeado")
                }
        </script>
    @endscript
</div> 
