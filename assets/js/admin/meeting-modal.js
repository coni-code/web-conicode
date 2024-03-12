import flatpickr from 'flatpickr';
import {getLocale} from './locale';

export class MeetingModal {
    constructor(refreshCalendar) {
        this.dateRangeInput = document.getElementById('date-range');
        this.initDatePicker();
        this.modal = document.getElementById('meeting-modal');
        this.titleInput = document.getElementById('title');
        this.descriptionInput = document.getElementById('description');
        this.select2Input = document.querySelector('.meeting-users-select');
        this.addEventListeners();
        this.currentMeetingId = null;
        this.debounceTimer = null;
        this.currentMeetingStatus = null;
        this.refreshCalendar = refreshCalendar;
        this.refreshModal = this.refreshModal.bind(this);
        this.assignedUserIds = [];
        this.initCKEditor();
    }

    initCKEditor() {
        // eslint-disable-next-line
        this.editor = ClassicEditor
            .create(document.querySelector('#editor'))
            .then(editor => {
                this.ckeditor = editor;
                this.ckeditor.model.document.on('change:data', () => {
                    this.descriptionInput.value = this.ckeditor.getData();
                    this.debounceSaveChanges();
                });

                this.descriptionInput.addEventListener('input', () => {
                    this.ckeditor.setData(this.descriptionInput.value);
                    this.debounceSaveChanges();
                });
            })
            .catch(error => {
                console.error(error);
            });
    }

    initDatePicker() {
        this.datePicker = flatpickr(this.dateRangeInput, {
            mode: 'range',
            altInput: true,
            altFormat: 'M j, Y H:i',
            enableTime: true,
            dateFormat: 'Y-m-d\\TH:i',
            // eslint-disable-next-line camelcase
            time_24hr: true,
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
            // eslint-disable-next-line no-alert
            const isConfirmed = confirm('Do you really wish to permanently delete this meeting? This action cannot be undone.');
            if (isConfirmed) {
                this.deleteMeeting();
                this.closeModal();
            }
        });

        this.titleInput.addEventListener('input', () => this.debounceSaveChanges());
        this.descriptionInput.addEventListener('input', () => this.debounceSaveChanges());

        $(this.select2Input).on('change', () => {
            if (this.currentMeetingId) {
                const selectedUserIds = $(this.select2Input).val();
                this.updateUsers(this.currentMeetingId, selectedUserIds);
                this.refreshCalendar();
            }
        });
        const saveButton = document.querySelector('.btn-create');
        saveButton.addEventListener('click', () => this.saveNewMeeting());
    }

    saveNewMeeting() {
        if (this.isDataValid()) {
            this.createOrUpdateMeeting();
            this.closeModal();
        }
    }

    showLoader() {
        const loader = this.modal.querySelector('.meeting-modal-loader');
        const content = this.modal.querySelector('.meeting-modal-content');
        content.style.display = 'none';
        loader.style.display = 'block';
    }

    hideLoader() {
        const loader = this.modal.querySelector('.meeting-modal-loader');
        const content = this.modal.querySelector('.meeting-modal-content');
        loader.style.display = 'none';
        content.style.display = 'flex';
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
        this.refreshUserSelect();
    }

    toggleSaveDeleteButtons(isNewMeeting) {
        const deleteButton = document.querySelector('.btn-delete');
        const saveButton = document.querySelector('.btn-create');

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
        this.showLoader();
        fetch(`/api/meetings/${meetingId}`)
            .then(response => response.json())
            .then(data => {
                this.populateModalFields(data);
            })
            .then(() => {
                this.hideLoader();
            })
            .catch(error => {
                console.error('Error fetching meeting data:', error);
                this.hideLoader();
            });
    }

    async populateModalFields(data) {
        this.titleInput.value = data.title ?? '';
        this.descriptionInput.value = data.description ?? '';
        this.currentMeetingStatus = data.status;
        this.assignedUserIds = data.userIds;
        this.ckeditor.setData(this.descriptionInput.value);

        if (data.startDate && data.endDate) {
            this.datePicker.setDate([new Date(data.startDate), new Date(data.endDate)]);
        } else {
            this.datePicker.clear();
        }

        this.isDataValid();
    }

    refreshUserSelect() {
        fetch('/api/users')
            .then(response => response.json())
            .then(data => {
                const users = data['hydra:member'].map(user => ({
                    id: user.id,
                    text: `${user.displayName}`,
                    selected: Array.isArray(this.assignedUserIds) && this.assignedUserIds.includes(user.id),
                }));

                $(this.select2Input).empty().select2({data: users});
            })
            .catch(error => console.error('Error fetching users:', error));
    }

    resetFormFields() {
        this.titleInput.value = '';
        this.descriptionInput.value = '';
        this.datePicker.config.dateTime = true;
        this.datePicker.clear();

        $(this.select2Input).val(null).trigger('change');
        this.assignedUserIds = [];
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

    saveChanges() {
        if (this.currentMeetingId) {
            if (this.isDataValid()) {
                this.createOrUpdateMeeting();
            }
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

    updateUsers(meetingId, selectedUserIds) {
        const locale = getLocale();
        fetch(`/${locale}/admin/meeting/${meetingId}/update-users`, {
            method: 'POST',
            headers: {'Content-Type': 'application/ld+json'},
            body: JSON.stringify({userIds: selectedUserIds}),
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }

                return response.json();
            })
            .catch(error => {
                console.error('Error updating users:', error);
            });
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
        const selectedUserIds = $(this.select2Input).val();

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
            .then(data => {
                this.currentMeetingId = data.id;
                this.updateUsers(this.currentMeetingId, selectedUserIds);
            })
            // eslint-disable-next-line no-unused-vars
            .then(data => {
                this.refreshCalendar();
            })
            .catch(error => {
                console.error('Error saving meeting data:', error);
            });
    }

    openNewMeeting() {
        this.hideLoader();
        this.currentMeetingId = null;
        this.resetFormFields();
        this.toggleSaveDeleteButtons(true);
        this.modal.style.display = 'block';
        this.refreshUserSelect();
        this.ckeditor.setData('');
    }

    refreshModal() {
        if (this.currentMeetingId) {
            this.prepareModalData(this.currentMeetingId);
        }
    }
}
