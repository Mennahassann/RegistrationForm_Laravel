const form = document.getElementById('form');
form.addEventListener('submit', async function (event) {
    event.preventDefault();
    clearErrors();

    const validFullname = validateFullName();
    const validUsername = await validateUsername();
    const validPhone = validatePhone();
    const validWhatsapp = await validateWhatsapp();
    const validAddress = validateAddress();
    const validPassword = validatePassword();
    const validConfirm = validateConfirm();
    const validImage = validateImage();
    const validEmail = await validateEmail();

    const errors = document.querySelectorAll('.error');
    let hasError = false;
    errors.forEach(function (el) {
        if (el.textContent.trim() !== '') {
            hasError = true;
        }
    });

    if (validFullname && validUsername && validPhone && validWhatsapp &&
        validAddress && validPassword && validConfirm && validImage && validEmail && !hasError)
        form.submit();
});

function clearErrors() {
    const errorElements = document.querySelectorAll('.error');
    errorElements.forEach(element => { element.textContent = ''; });
}

function validateFullName() {
    const fullName = document.getElementById('fullname').value.trim();
    const fullNameError = document.getElementById('fullnameError');
    if (!fullName) {
        fullNameError.textContent = fullNameError.getAttribute('data-required');
        return false;
    }
    if (!/^[a-zA-Z\u0600-\u06FF\s]+$/.test(fullName)) {
        fullNameError.textContent = fullNameError.getAttribute('data-pattern');
        return false;
    }
    fullNameError.textContent = '';
    return true;
}

async function validateUsername() {
    const username = document.getElementById('username').value.trim();
    const usernameError = document.getElementById('usernameError');
    if (!username) {
        usernameError.textContent = usernameError.getAttribute('data-required');
        return false;
    }
    if (/[^a-zA-Z0-9_]/.test(username)) {
        usernameError.textContent = usernameError.getAttribute('data-pattern');
        return false;
    }
    try {
        const url = document.getElementById('csrf-token').getAttribute('url') + "/register";
        const response = await fetch(url, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.getElementById('csrf-token').getAttribute('token'),
                "X-Requested-With": "XMLHttpRequest",
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ username: username })
        });
        const data = await response.json();
        if (data.exists) {
            usernameError.textContent = usernameError.getAttribute('data-duplicated');
            return false;
        }
    } catch (error) {
        console.error("Error:", error);
        return false;
    }
    usernameError.textContent = '';
    return true;
}

function validatePhone() {
    const phone = document.getElementById('phone').value.trim();
    const phoneError = document.getElementById('phoneError');
    if (!phone) {
        phoneError.textContent = phoneError.getAttribute('data-required');
        return false;
    }
    if (!/^[ ()+0-9-]*$/.test(phone)) {
        phoneError.textContent = phoneError.getAttribute('data-valid');
        return false;
    }
    if (phone.length > 15 || phone.length < 7) {
        phoneError.textContent = phoneError.getAttribute('data-length');
        return false;
    }
    phoneError.textContent = '';
    return true;
}

async function validateWhatsapp() {
    const whatsappNumber = document.getElementById('whatsappNumber').value.trim();
    const numError = document.getElementById('numError');
    if (!whatsappNumber) {
        numError.textContent = numError.getAttribute('data-required');
        return false;
    }
    // try {
    //     const url = document.getElementById('csrf-token').getAttribute('url') + "/api/validate-whatsapp?whatsapp_number=" + encodeURIComponent(whatsappNumber);
    //     const response = await fetch(url);
    //     const data = await response.json();
    //     if (!data.success) {
    //         numError.textContent = numError.getAttribute('data-pattern');
    //         return false;
    //     }
    // } catch (error) {
    //     console.error("Error:", error);
    //     return false;
    // }
    numError.textContent = '';
    return true;
}

function validateAddress() {
    const address = document.getElementById('address').value.trim();
    const addressError = document.getElementById('addressError');
    if (!address) {
        addressError.textContent = addressError.getAttribute('data-required');
        return false;
    }
    addressError.textContent = '';
    return true;
}

function validatePassword() {
    const password = document.getElementById('password').value.trim();
    const passwordError = document.getElementById('passwordError');
    if (!password) {
        passwordError.textContent = passwordError.getAttribute('data-required');
        return false;
    }
    if (password.length < 8) {
        passwordError.textContent = passwordError.getAttribute('data-length');
        return false;
    }
    if (!/\d/.test(password)) {
        passwordError.textContent = passwordError.getAttribute('data-digits');
        return false;
    }
    if (!/[a-zA-Z]/.test(password)) {
        passwordError.textContent = passwordError.getAttribute('data-letters');
        return false;
    }
    if (!/\W/.test(password)) {
        passwordError.textContent = passwordError.getAttribute('data-chars');
        return false;
    }
    passwordError.textContent = '';
    return true;
}

function validateConfirm() {
    const password = document.getElementById('password').value.trim();
    const confirmPassword = document.getElementById('confirm').value.trim();
    const confirmError = document.getElementById('confirmError');
    if (!confirmPassword) {
        confirmError.textContent = confirmError.getAttribute("data-required");
        return false;
    }
    if (confirmPassword !== password) {
        confirmError.textContent = confirmError.getAttribute("data-match");
        return false;
    }
    confirmError.textContent = '';
    return true;
}

function validateImage() {
    const image = document.getElementById('image');
    const imageError = document.getElementById('imageError');
    if (image.files.length === 0) {
        imageError.textContent = imageError.getAttribute('data-required');
        return false;
    }
    imageError.textContent = '';
    return true;
}

async function validateEmail() {
    const email = document.getElementById('email').value.trim();
    const emailError = document.getElementById('emailError');
    if (!email) {
        emailError.textContent = emailError.getAttribute('data-required');
        return false;
    }
    if (!/\S+@\S+\.\S+/.test(email)) {
        emailError.textContent = emailError.getAttribute('data-pattern');
        return false;
    }
    try {
        const url = document.getElementById('csrf-token').getAttribute('url') + "/register";
        const response = await fetch(url, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.getElementById('csrf-token').getAttribute('token'),
                "X-Requested-With": "XMLHttpRequest",
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ email: email })
        });
        const data = await response.json();
        if (data.exists) {
            emailError.textContent = emailError.getAttribute('data-duplicated');
            return false;
        }
    } catch (error) {
        console.error("Error:", error);
        return false;
    }
    emailError.textContent = '';
    return true;
}

document.getElementById('fullname').addEventListener('blur', validateFullName);
document.getElementById('username').addEventListener('blur', validateUsername);
document.getElementById('phone').addEventListener('blur', validatePhone);
document.getElementById('whatsappNumber').addEventListener('blur', validateWhatsapp);
document.getElementById('address').addEventListener('blur', validateAddress);
document.getElementById('password').addEventListener('blur', validatePassword);
document.getElementById('confirm').addEventListener('blur', validateConfirm);
document.getElementById('image').addEventListener('blur', validateImage);
document.getElementById('email').addEventListener('blur', validateEmail);
