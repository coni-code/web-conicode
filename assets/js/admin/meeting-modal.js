import flatpickr from 'flatpickr';

export class MeetingModal {
    constructor(refreshCalendar) {
        this.modal = document.getElementById('meeting-modal');
        this.titleInput = document.getElementById('title');
        this.descriptionInput = document.getElementById('description');
        this.dateRangeInput = document.getElementById('date-range');
        this.initDatePicker();
        this.addEventListeners();
        this.currentMeetingId = null;
        this.debounceTimer = null;
        this.currentMeetingStatus = null;
        this.refreshCalendar = refreshCalendar;
    }

    initDatePicker() {
        this.datePicker = flatpickr(this.dateRangeInput, {
            mode: 'range',
            enableTime: true,
            // eslint-disable-next-line camelcase
            time_24hr: true,
            dateFormat: 'Y-m-d H:i',
            onChange: () => this.debounceSaveChanges(),
        });
    }

    addEventListeners() {
        document.querySelectorAll('[data-meeting-modal]').forEach(button => {
            const meetingId = button.getAttribute('data-meeting-modal');
            button.addEventListener('click', () => this.openExistingMeeting(meetingId));
        });

        document.getElementById('new-meeting-button').addEventListener('click', () => this.openNewMeeting());

        document.querySelector('.close-button').addEventListener('click', () => this.closeModal());

        window.addEventListener('click', event => {
            if (event.target === this.modal) {
                this.closeModal();
            }
        });

        const deleteButton = document.querySelector('.btn-delete');
        deleteButton.addEventListener('click', () => {
            this.deleteMeeting();
            this.closeModal();
        });

        this.titleInput.addEventListener('input', () => this.debounceSaveChanges());
        this.descriptionInput.addEventListener('input', () => this.debounceSaveChanges());

        const saveButton = document.querySelector('.btn-create');
        saveButton.addEventListener('click', () => this.saveNewMeeting());

        const joinBtn = document.querySelector('.btn-join');
        joinBtn.addEventListener('click', () => {
            this.assignUserToEvent(this.currentMeetingId);
        });
    }

    saveNewMeeting() {
        if (this.isDataValid()) {
            this.createOrUpdateMeeting();
        }
    }

    deleteMeeting() {
        if (this.currentMeetingId) {
            fetch(`/api/meetings/${this.currentMeetingId}`, {
                method: 'DELETE',
                headers: {'Content-Type': 'application/ld+json'},
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }

                    return response.json();
                })
                .then(() => {
                    this.closeModal();
                    this.refreshCalendar();
                })
                .catch(error => {
                    console.error('Error deleting meeting:', error);
                });
        }
    }

    openExistingMeeting(meetingId) {
        this.currentMeetingId = meetingId;
        this.prepareModalData(this.currentMeetingId);
        this.modal.style.display = 'block';
        this.toggleSaveDeleteButtons(false);
    }

    toggleSaveDeleteButtons(isNewMeeting) {
        const deleteButton = document.querySelector('.btn-delete');
        const saveButton = document.querySelector('.btn-create');
        if (deleteButton) {
            return;
        }

        if (isNewMeeting) {
            deleteButton.style.display = 'none';
            saveButton.style.display = 'block';
        } else {
            deleteButton.style.display = 'block';
            saveButton.style.display = 'none';
        }
    }

    closeModal() {
        this.modal.style.display = 'none';
    }

    prepareModalData(meetingId) {
        fetch(`/api/meetings/${meetingId}`)
            .then(response => response.json())
            .then(data => this.populateModalFields(data))
            .catch(error => console.error('Error fetching meeting data:', error));
    }

    populateModalFields(data) {
        console.log(data);
        this.titleInput.value = data.title ?? '';
        this.descriptionInput.innerHTML = data.description ?? '';
        this.currentMeetingStatus = data.status;

        if (data.startDate && data.endDate) {
            this.datePicker.setDate([new Date(data.startDate), new Date(data.endDate)]);
        } else {
            this.datePicker.clear();
        }
    }

    resetFormFields() {
        this.titleInput.value = '';
        this.descriptionInput.value = '';
        this.datePicker.clear();
    }

    debounceSaveChanges() {
        if (this.currentMeetingId) {
            clearTimeout(this.debounceTimer);
            this.debounceTimer = setTimeout(() => {
                if (this.isDataValid()) {
                    this.createOrUpdateMeeting();
                }
            }, 1000);
        }
    }

    isDataValid() {
        let isValid = true;

        if (this.titleInput.value.trim() === '') {
            this.titleInput.classList.add('invalid-field');
            this.addValidationMessage(this.titleInput, 'Title is required');
            isValid = false;
        } else {
            this.titleInput.classList.remove('invalid-field');
            this.removeValidationMessage(this.titleInput);
        }

        // eslint-disable-next-line no-negated-condition
        if (this.datePicker.selectedDates.length !== 2) {
            this.dateRangeInput.classList.add('invalid-field');
            this.addValidationMessage(this.dateRangeInput, 'Date range is required');
            isValid = false;
        } else {
            this.dateRangeInput.classList.remove('invalid-field');
            this.removeValidationMessage(this.dateRangeInput);
        }

        return isValid;
    }

    addValidationMessage(element, message) {
        let messageElement = element.nextElementSibling;
        if (!messageElement || !messageElement.classList.contains('validation-message')) {
            messageElement = document.createElement('div');
            messageElement.classList.add('validation-message');
            messageElement.style.color = 'red';
            messageElement.textContent = message;
            element.parentNode.insertBefore(messageElement, element.nextSibling);
        }
    }

    removeValidationMessage(element) {
        const messageElement = element.nextElementSibling;
        if (messageElement && messageElement.classList.contains('validation-message')) {
            messageElement.parentNode.removeChild(messageElement);
        }
    }

    prepareMeetingData() {
        const meetingData = {
            title: this.titleInput.value,
            description: this.descriptionInput.value,
            startDate: this.datePicker.selectedDates[0].toISOString(),
            endDate: this.datePicker.selectedDates[1].toISOString(),
        };

        if (this.currentMeetingId) {
            meetingData.status = this.currentMeetingStatus;
        }

        return meetingData;
    }

    createOrUpdateMeeting() {
        const method = this.currentMeetingId ? 'PUT' : 'POST';
        const apiPath = this.currentMeetingId ? `/api/meetings/${this.currentMeetingId}` : '/api/meetings';

        fetch(apiPath, {
            method,
            headers: {'Content-Type': 'application/ld+json'},
            body: JSON.stringify(this.prepareMeetingData()),
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }

                return response.json();
            })
            // eslint-disable-next-line no-unused-vars
            .then(data => {
                if (!this.currentMeetingId) {
                    this.closeModal();
                }

                this.refreshCalendar();
            })
            // eslint-disable-next-line no-unused-vars
            .then(data => {
                if (!this.currentMeetingId) {
                    this.closeModal();
                }
            })
            .catch(error => {
                console.error('Error saving meeting data:', error);
            });
    }

    openNewMeeting() {
        this.currentMeetingId = null;
        this.resetFormFields();
        this.toggleSaveDeleteButtons(true);
        this.modal.style.display = 'block';
    }

    assignUserToEvent(id) {
        fetch(`${id}/toggle-user`, {
            method: 'POST',
        }).then(() => {
            this.refreshCalendar();
        }).catch(error => {
            throw new Error(error);
        });
    }
}

document.addEventListener('DOMContentLoaded', () => {
    // eslint-disable-next-line no-new
    new MeetingModal();
});
