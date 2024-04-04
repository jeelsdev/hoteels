import { Calendar } from 'fullcalendar';
import resourceTimelinePlugin from '@fullcalendar/resource-timeline';

document.addEventListener('DOMContentLoaded', function() {

  const rooms = [];
  const events = [];
  let color = '#000000';
  let title = '';
  if (window.reservations.length > 0)
  {
    window.reservations.forEach(event => {
      switch (event.status) {
        case 'pending':
          color = '#ff3333';
          break;
        case 'confirmed':
          color = '#1acd61';
          break;
        case 'canceled':
          color = '#cac118';
          break;
        case 'waiting':
          color = '#0fb5cb';
          break;
      }
      if(event.users[0] != undefined)
      {
        title = event.users[0].name + event.total;
      }else {
        title = "Sin Usuario" + event.total;
      }
      events.push({
        title: title,
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

  if (window.rooms.length > 0)
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
    width: 1000,

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
    initialView: 'resourceTimelineMonth',
    plugins: [ resourceTimelinePlugin ],
    dateClick: handleDateClick,
    resourceGroupField: 'building',
    resourceAreaWidth: '10%',
    // resourceLabelText: 'IMPIANTI',
    resourcesInitiallyExpanded: true,
    // resourceText: 'Habitaciones',
    refetchResourcesOnNavigate: true,
    resourceAreaColumns: [
      {
        headerContent: 'Habitaciones'
      }
    ],
    resources: rooms,

    events: events,
    eventResourceEditable: true,
    eventMinWidth: 30,
    eventMaxStack:2,
    eventClick: handleEventClick,
  })
  calendar.render()
})

const handleDateClick = (info) => {
  Livewire.dispatch('openModalCreate', { data: info });
}

const handleEventClick = (info) => {
  Livewire.dispatch('open-modal-edit', { data: info });
}