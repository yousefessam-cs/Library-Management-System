var password = document.getElementById('pw1');
var confirmPassword = document.getElementById('pw2');

if (password && confirmPassword) {
    password.addEventListener('keyup', Validate);
    confirmPassword.addEventListener('keyup', Validate);
}

function Validate() {

    if (password.value != confirmPassword.value) {
        confirmPassword.setCustomValidity("Passwords mismatch");
    } else {
        confirmPassword.setCustomValidity("");
    }
}