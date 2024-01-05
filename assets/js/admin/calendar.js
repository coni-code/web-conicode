import {Calendar} from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';

document.addEventListener('DOMContentLoaded', () => {
    const calendarElement = document.getElementById('full-calendar');
    const calendar = new Calendar(calendarElement, {
        plugins: [dayGridPlugin, interactionPlugin],
    });
    calendar.render();
});
