 // Wait for the page to fully load
document.addEventListener('DOMContentLoaded', function() {

    /*
       FEATURE 1: LOGIN FORM VALIDATION
     */

    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            // Stop the form from refreshing the page
            e.preventDefault();

            // Get the values from the form
            const email = document.getElementById('loginEmail').value.trim();
            const password = document.getElementById('loginPassword').value.trim();
            const alertDiv = document.getElementById('loginAlert');

            // Check if fields are empty
            if (!email || !password) {
                alertDiv.classList.remove('d-none');
                alertDiv.innerHTML = '<i class="bi bi-exclamation-circle"></i> Please fill in all fields.';
                return;
            }

            // Check if email is valid (contains @)
            if (!email.includes('@')) {
                alertDiv.classList.remove('d-none');
                alertDiv.innerHTML = '<i class="bi bi-exclamation-circle"></i> Enter a valid email address.';
                return;
            }

            // If all checks pass
            alertDiv.classList.add('d-none');
            alert('✅ Login successful!');
            window.location.href = 'dashboard.html';
        });
    }

    /* 
       FEATURE 2: REGISTER FORM VALIDATION
        */

    const registerForm = document.getElementById('registerForm');
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            // Stop the form from refreshing the page
            e.preventDefault();

            // Get the values from the form
            const name = document.getElementById('registerName').value.trim();
            const email = document.getElementById('registerEmail').value.trim();
            const password = document.getElementById('registerPassword').value;
            const confirm = document.getElementById('registerConfirm').value;
            const alertDiv = document.getElementById('registerAlert');

            // Check all fields are filled
            if (!name || !email || !password || !confirm) {
                alertDiv.classList.remove('d-none');
                alertDiv.innerHTML = '<i class="bi bi-exclamation-circle"></i> Please fill in all fields.';
                return;
            }

            // Check if email is valid
            if (!email.includes('@')) {
                alertDiv.classList.remove('d-none');
                alertDiv.innerHTML = '<i class="bi bi-exclamation-circle"></i> Enter a valid email address.';
                return;
            }

            // Check password length
            if (password.length < 6) {
                alertDiv.classList.remove('d-none');
                alertDiv.innerHTML = '<i class="bi bi-exclamation-circle"></i> Password must be at least 6 characters.';
                return;
            }

            // Check if passwords match
            if (password !== confirm) {
                alertDiv.classList.remove('d-none');
                alertDiv.innerHTML = '<i class="bi bi-exclamation-circle"></i> Passwords do not match.';
                return;
            }

            // If all checks pass
            alertDiv.classList.add('d-none');
            alert('✅ Registration successful!');
            window.location.href = 'login.html';
        });
    }

});
/* 
   SHOW/HIDE PASSWORD TOGGLE
   Used in: login.php, register.php
*/

function togglePassword(fieldId, iconId) {
    const field = document.getElementById(fieldId);
    const icon = document.getElementById(iconId);
    
    if (!field || !icon) return;
    
    if (field.type === "password") {
        field.type = "text";
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    } else {
        field.type = "password";
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    }
}