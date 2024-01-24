document.addEventListener('DOMContentLoaded', () => {
    function updateCountdown(meetingStartTime) {
        const countdownElement = document.getElementById('meeting-start-countdown');
        if (!countdownElement) {
            return;
        }

        const now = new Date();
        const meetingDate = new Date(meetingStartTime);
        const timeLeft = meetingDate - now;

        if (timeLeft > 0) {
            let years = meetingDate.getFullYear() - now.getFullYear();
            let months = meetingDate.getMonth() - now.getMonth();
            let days = meetingDate.getDate() - now.getDate();
            let hours = meetingDate.getHours() - now.getHours();
            let minutes = meetingDate.getMinutes() - now.getMinutes();
            let seconds = meetingDate.getSeconds() - now.getSeconds();

            if (months < 0 || (months === 0 && days < 0)) {
                years--;
                months += 12;
            }

            if (days < 0) {
                months--;
                days += new Date(meetingDate.getFullYear(), meetingDate.getMonth(), 0).getDate();
            }

            if (hours < 0) {
                days--;
                hours += 24;
            }

            if (minutes < 0) {
                hours--;
                minutes += 60;
            }

            if (seconds < 0) {
                minutes--;
                seconds += 60;
            }

            let countdownString = '';
            if (years > 0) {
                countdownString += `${years}y `;
            }

            if (months > 0) {
                countdownString += `${months}m `;
            }

            if (days > 0) {
                countdownString += `${days}d `;
            }

            if (hours > 0) {
                countdownString += `${hours}h `;
            }

            if (minutes > 0) {
                countdownString += `${minutes}m `;
            }

            if (seconds > 0) {
                countdownString += `${seconds}s`;
            }

            countdownElement.innerHTML = countdownString;
        }
    }

    const startDateElement = document.getElementById('meeting-start-countdown');
    if (startDateElement) {
        const meetingStartTime = startDateElement.getAttribute('data-start-date');
        setInterval(() => updateCountdown(meetingStartTime), 1000);
    }
});
