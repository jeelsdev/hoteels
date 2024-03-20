<div class="pt-24 px-8">

    <livewire:admin.reservation.create-reservation />
    
    <div id="calendar"></div>

    @script

        <script>
            window.handleDateClick = (info) => {
            console.log(info);

            $wire.dispatch('openModal', { data: info });
            console.log('dispatched');
            // alert('Clicked on: ' + info.dateStr);
            // alert('Coordinates: ' + info.jsEvent.pageX + ',' + info.jsEvent.pageY);
            // alert('Current view: ' + info.view.type);
            // change the day's background color just for fun
            // info.dayEl.style.backgroundColor = 'red';
            }
        </script>

    @endscript
</div> 
