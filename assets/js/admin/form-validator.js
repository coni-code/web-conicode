document.addEventListener('DOMContentLoaded', () => {
    const passwordInputs = document.querySelectorAll('.password-input');
    const emailInputs = document.querySelectorAll('.email-input');

    passwordInputs.forEach(input => {
        input.addEventListener('input', function () {
            validatePassword(this);
        });
        input.addEventListener('blur', function () {
            resetInputStyle(this);
        });
    });

    emailInputs.forEach(input => {
        input.addEventListener('input', function () {
            validateEmail(this);
        });
        input.addEventListener('blur', function () {
            resetInputStyle(this);
        });
    });
});

function inputFailed(input) {
    input.classList.add('validation-failed');
    input.classList.remove('validation-succeed');
}

function inputSucceed(input) {
    input.classList.remove('validation-failed');
    input.classList.add('validation-succeed');
}

function resetInputStyle(input) {
    if (!input.classList.contains('validation-failed')) {
        input.classList.remove('validation-succeed');
    }
}

function validatePassword(input) {
    const password = input.value;
    if (!password || password.length < 6 || !/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[-_!@#$%^&*()+]).*$/.test(password)) {
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
        inputFailed(input);
    }
}
