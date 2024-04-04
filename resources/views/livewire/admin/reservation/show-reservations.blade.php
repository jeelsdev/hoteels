<div class="pt-24 px-8">
    @script
        <script>
            window.rooms = @json($rooms);
            window.reservations = @json($reservations);
        </script>
    @endscript

    <livewire:admin.reservation.create-reservation />
    <livewire:admin.reservation.edit-reservation />
    
    <div id="calendar"></div>

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
