import {Calendar} from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';
import {getLocale} from './locale';

document.addEventListener('DOMContentLoaded', () => {
    const locale = getLocale();
    const calendarElement = document.getElementById('full-calendar');
    const calendar = new Calendar(calendarElement, {
        plugins: [dayGridPlugin, interactionPlugin],
        eventTimeFormat: {
            hour: '2-digit',
            minute: '2-digit',
            meridiem: false,
        },
        displayEventTime: false,
        events(fetchInfo, successCallback, failureCallback) {
            fetchMeetings(fetchInfo, successCallback, failureCallback);
        },
        eventClassNames(event) {
            return handleEventStatus(event);
        },
        eventContent(arg) {
            const editLink = `${arg.event.id}/edit`;
            return {html: generateEventContent(arg, editLink, 'fa-edit')};
        },
    });
    calendar.render();
    calendar.setOption('locale', locale);
});

function prepareEventData(meetings) {
    return meetings.map(meeting => ({
        id: meeting.id,
        title: meeting.title,
        start: meeting.startDate,
        end: meeting.endDate,
        extraParams: {
            status: meeting.status,
        },
    }));
}

function fetchMeetings(fetchInfo, successCallback, failureCallback) {
    const startDate = fetchInfo.startStr;
    const endDate = fetchInfo.endStr;

    fetch(`/api/meetings?startDate=${startDate}&endDate=${endDate}`)
        .then(response => response.json())
        .then(data => {
            successCallback(prepareEventData(data['hydra:member']));
        })
        .catch(error => {
            failureCallback(error);
        });
}

function handleEventStatus(event) {
    const classNames = ['fc-event', 'fc-event-dot'];
    if (event.event.extendedProps.extraParams.status === 'pending') {
        classNames.push('fc-event-pending', 'fc-event-dot-pending');
    }

    return classNames;
}

function generateEventContent(arg, link, icon) {
    return `
            <div class="fc-event-main-frame">
                <div class="fc-event-title-container">
                    <div class="fc-event-title">${arg.event.title}</div>
                </div>
                <div class="fc-event-details-link">
                    <a href="${link}" class="fc-event-details-button"><i class="fas ${icon} m-1"></i></a>
                </div>
            </div>
        `;
}
