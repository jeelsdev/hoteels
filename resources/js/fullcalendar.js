import { Calendar } from 'fullcalendar';
import resourceTimelinePlugin from '@fullcalendar/resource-timeline';

document.addEventListener('DOMContentLoaded', function() {

  const rooms = [];
  const events = [];
  let color = '#000000';
  let title = '';
  let total = 0;
  let originE = '';
  if(window.reservations === undefined) return;
  const dayNames = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
  if (window.reservations !== undefined)
  {
    window.reservations.forEach(event => {
      switch (event.status) {
        case 'pending':
          color = '#f98b07';
          break;
        case 'confirmed':
          color = '#61a146';
          break;
        case 'canceled':
          color = '#fde012';
          break;
        case 'booking':
          color = '#0195b9';
          break;
      }
      event.users.some(user => {
        if(user.pivot.reserver == 1)
        {
          title = user.name;
          return true;
        }else {
          title = "Sin Reservador";
        }
      });
      total = event.payment.total_reservation;
      originE = event.origin; 
      events.push({
        title: '<h2 class="font-bold"> '+title+' </h2><p class="font-bold text-white"> s/ '+total+' </p><p class="text-white">'+originE+'</p>',
        start: event.entry_date,
        end: event.exit_date,
        color: color,
        textColor: "white",
        resourceId: event.room_id,
        custom_data: {
          reservation_id: event.id,
          room_id: event.room_id,
        }
      });
    });
  }

  if (window.rooms !== undefined)
  {
    window.rooms.forEach(room => {
      rooms.push({
        id: room.id,
        building: room.floor,
        title: `${room.code}-${room.room_type.description}`,
      });
    });
  }

  const calendarEl = document.getElementById('calendar')
  const calendar = new Calendar(calendarEl, {
    locales: 'es',

   headerToolbar: {
      left: 'today prev,next',
      center: 'title',
      right: 'resourceTimelineMonth'
    },
    buttonText: {
        today: 'Hoy',
        month: 'Mes',
        week: 'Semana',
        day: 'Día',
        list: 'Listado'
    },
    schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
    aspectRatio: 2,
    height: 'auto',
    initialView: 'resourceTimelineMonth',
    plugins: [ resourceTimelinePlugin ],
    dateClick: handleDateClick,
    resourceGroupField: 'building',
    resourceAreaWidth: '10%',
    resourcesInitiallyExpanded: true,
    refetchResourcesOnNavigate: true,
    resourceAreaColumns: [
      {
        headerContent: 'Habitaciones'
      }
    ],
    resources: rooms,

    events: events,
    eventResourceEditable: true,
    eventMinWidth: 60,
    eventClick: handleEventClick,
    eventContent: function(arg) {
      return {
        html: '<div class="p-2 w-max">' + arg.event.title + '</div>',
      };
    },
    dayHeaderContent: function(arg) {
      
      return dayNames[arg.date.getDay()] + ' ' + arg.date.getDate();
    },
    dayMinWidth: 100,
    views: {
      resourceTimelineMonth: {
        slotLabelContent: function(arg) {
          return dayNames[arg.date.getDay()] + ' ' + arg.date.getDate();
        }
      }
    },
    datesSet: function(info) {
      const today = new Date();
      // if(today.getDate > 15){
        calendar.scrollToTime({
          day: today.getDate(),
          month: today.getMonth(),
          year: today.getFullYear()
        });
      // }
    }
  })
  calendar.render()
})

const handleDateClick = (info) => {
  Livewire.dispatch('create-reservation', { data: info });
}

const handleEventClick = (info) => {
  Livewire.dispatch('edit-reservation', { data: info });
}