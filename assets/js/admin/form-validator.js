document.addEventListener('DOMContentLoaded', () => {
    const passwordInputs = document.querySelectorAll('.password-input');

    const emailInputs = document.querySelectorAll('.email-input');
    const submitButton = document.getElementById('submit-form-button');

    let validation = true;
    submitButton.addEventListener('click', event => {
        validation = true;
        passwordInputs.forEach(input => {
            if (input.value.length >= 1) {
                validatePassword(input);
            }

            input.addEventListener('input', () => {
                if (input.value.length >= 1) {
                    validatePassword(input);
                }
            });
        });
        emailInputs.forEach(input => {
            validateEmail(input);
            input.addEventListener('input', () => {
                validateEmail(input);
            });
        });
        if (!validation) {
            event.preventDefault();
        }
    });
    function inputFailed(input) {
        input.classList.add('validation-failed');
        input.classList.remove('validation-succeed');
        document.getElementById('submit-form-button').classList.add('btn-secondary');
        document.getElementById('submit-form-button').classList.remove('btn-success');
    }

    function inputSucceed(input) {
        input.classList.remove('validation-failed');
        input.classList.add('validation-succeed');
        document.getElementById('submit-form-button').classList.add('btn-success');
        document.getElementById('submit-form-button').classList.remove('btn-secondary');
    }

    function validatePassword(input) {
        const password = input.value;
        if (!password || password.length < 6 || !/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[-_!@#$%^&*()+]).*$/.test(password)) {
            validation = false;
            inputFailed(input);
        } else {
            inputSucceed(input);
        }
    }

    function validateEmail(input) {
        const email = input.value;
        const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;

        if (emailRegex.test(email)) {
            inputSucceed(input);
        } else {
            validation = false;
            inputFailed(input);
        }
    }
});
