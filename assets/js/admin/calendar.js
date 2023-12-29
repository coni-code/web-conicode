import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';

document.addEventListener('DOMContentLoaded', function() {
    let calendarElement = document.getElementById('full-calendar');
    let calendar = new Calendar(calendarElement, {
        plugins: [dayGridPlugin, interactionPlugin]
    });
    calendar.render();
});
