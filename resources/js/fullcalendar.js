import { Calendar } from 'fullcalendar';
import resourceTimelinePlugin from '@fullcalendar/resource-timeline';

document.addEventListener('DOMContentLoaded', function() {
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
    resourceGroupField: 'building',
    resources: [
      { id: 'a', building: '460 Bryant', title: 'Auditorium A' },
      { id: 'b', building: '460 Bryant', title: 'Auditorium B' },
      { id: 'g', building: '564 Pacific', title: 'Auditorium G' },
      { id: 'h', building: '564 Pacific', title: 'Auditorium H' },
      { id: 'i', building: '564 Pacific', title: 'Auditorium I' }
    ],
    events: [
        {
            title: 'Evento de prueba 1', // le ponemos un título.
            description: 'Esta es una descripción de prueba', // añadimos la descripción, pero esta solo se muestra al hacer click el evento. 
            start: '2024-03-10 11:00:00', // definimos cuando comienza para situarlo en el calendario
            end: '2020-03-10 12:00:00', // y si dura mas de un día podemos definir cuando acaba. Sino lo omitimos
            color: 'yellow', // color del evento, acepta también hexadecimales.
            textColor: 'red', // color del texto, acepta igualmente hexadecimales.
        }
    ]
  })
  calendar.render()
})