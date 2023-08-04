function validateForm() {
    var username = document.forms[0].username.value;
    var password = document.forms[0].password.value;
    var recaptchaResponse = grecaptcha.getResponse();

    if (username === '' || password === '') {
        alert('Please fill in all fields.');
        return false;
    }

    if (recaptchaResponse.length === 0) {
        alert('Please complete the reCAPTCHA.');
        return false;
    }

    return true;
}
