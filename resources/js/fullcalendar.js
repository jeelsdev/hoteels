import { Calendar } from 'fullcalendar';
import resourceTimelinePlugin from '@fullcalendar/resource-timeline';

document.addEventListener('DOMContentLoaded', function() {

  const rooms = [];
  const events = [];

  if (window.reservations.length > 0)
  {
    window.reservations.forEach(event => {
      events.push({
        title: event.origin,
        description: event.origin,
        start: event.entry_date,
        end: event.exit_date,
        color: "#007bff",
        textColor: "red",
        resourceId: event.room_id
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

  console.log(events);

  const calendarEl = document.getElementById('calendar')
  const calendar = new Calendar(calendarEl, {
    locales: 'es',
   headerToolbar: {
      left: 'today prev,next',
      center: 'title',
      right: 'resourceTimelineDay,resourceTimelineWeek,resourceTimelineMonth'
    },
    buttonText: {
        today: 'Hoy',
        month: 'Mes',
        week: 'Semana',
        day: 'Día',
        list: 'Listado'
    },
    schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
    aspectRatio: 1.6,
    initialView: 'resourceTimelineDay',
    plugins: [ resourceTimelinePlugin ],
    dateClick: window.handleDateClick,
    resourceGroupField: 'building',
    resources: rooms,
    events: events
  })
  calendar.render()
})