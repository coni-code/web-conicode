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
        displayEventTime: true,
        events(fetchInfo, successCallback, failureCallback) {
            fetchMeetings(fetchInfo, successCallback, failureCallback);
        },
        eventClassNames(event) {
            return handleEventStatus(event);
        },
        eventContent(arg) {
            return {html: generateEventContent(arg, arg.event.id)};
        },
        eventDidMount(info) {
            const eventElement = info.el;

            const handleSpaceBarPress = function (event) {
                if (event.code === 'Space') {
                    assignUserToEvent(calendar, info.event.id);
                    event.preventDefault();
                    document.removeEventListener('keydown', handleSpaceBarPress);
                }
            };

            eventElement.addEventListener('mouseenter', () => {
                document.addEventListener('keydown', handleSpaceBarPress);
            });

            eventElement.addEventListener('mouseleave', () => {
                document.removeEventListener('keydown', handleSpaceBarPress);
            });
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
            avatarUrl: meeting.avatarUrl,
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

function generateEventContent(arg, id) {
    let avatarsHtml = '';

    const avatarUrls = arg.event.extendedProps.extraParams.avatarUrl;

    if (avatarUrls) {
        if (avatarUrls.length >= 6) {
            avatarsHtml = `<span class="count-sm-avatar">${avatarUrls.length}</span>`;
        } else {
            for (const url of arg.event.extendedProps.extraParams.avatarUrl) {
                avatarsHtml += `<img src="${url}" class="member-sm-avatar" alt="member-avatar">`;
            }
        }
    }

    return `
        <div class="fc-event-main-frame">
            <div class="fc-event-main-content">
                <div class="fc-event-title-container">
                    <div class="fc-event-title">${arg.event.title}</div>
                </div>
                <div class="fc-event-details-link">
                    <a href="${id}/edit" class="fc-event-details-button"><i class="fas fa-edit m-1"></i></a>
                </div>
            </div>
            <div class="member-avatar-container">${avatarsHtml}</div>
        </div>
    `;
}

function assignUserToEvent(calendar, id) {
    fetch(`${id}/toggle-user`, {
        method: 'POST',
    }).then(() => {
        calendar.refetchEvents();
    }).catch(error => {
        throw new Error(error);
    });
}
