<div class="block container">
    <h2><?=$title?></h2>
    <form id="reset-password-form">
        <input type="hidden" id="token" value="">
        <div class="line-input">
            <label for="new-password" class="required">Nouveau mot de passe</label>
            <div class="password-container">
                <input type="password" autocomplete="new-password" id="new-password" name="new-password" required>
                <button type="button" class="password-show-hide-button"><i class="fa fa-eye-slash"></i></button>
            </div>
            <meter id="password-strength-meter" class="password-strength-meter" max="4" low="1" high="3" optimum="4" value="0">0%</meter>
            <ul style="margin: 0px; padding: 0px; list-style: none;">
                <li>Au moins une lettre minuscule</li>
                <li>Au moins une lettre majuscule</li>
                <li>Au moins un chiffre</li>
                <li>Au moins un caractère spécial</li>
                <li>Au moins 8 caractères</li>
            </ul>
        </div>
        <p id="reset-message"></p>
        <div class="line-input">
            <label for="confirmation-password" class="required">Confirmer le mot de passe</label>
            <div class="password-container">
                <input type="password" autocomplete="confirmation-password" id="confirmation-password" name="confirmation-password" required>
                <button type="button" class="password-show-hide-button"><i class="fa fa-eye-slash"></i></button>
            </div>
        </div>
        <button type="submit" class="action-btn reset disabled" disabled="true">Réinitialiser</button>
    </form>
    
</div>
        
<script>
    // Toggle password visibility and update icon
    document.querySelectorAll('.password-show-hide-button').forEach(button => {
        button.addEventListener('click', () => {
            let passwordInput = button.previousElementSibling; // Get the closest input field
            let passwordIcon = button.querySelector('svg'); // Find the SVG inside the button
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.classList.replace('fa-eye-slash', 'fa-eye'); // Update icon
            } else {
                passwordInput.type = 'password';
                passwordIcon.classList.replace('fa-eye', 'fa-eye-slash'); // Update icon
            }
        });
    });

    let passwordInput = document.getElementById('new-password');
    passwordInput.addEventListener('input', () => {
        const password = passwordInput.value;
        const strength = calculatePasswordStrength(password);
        const passwordStrengthMeter = document.getElementById('password-strength-meter');
        const passwordRequirements = passwordStrengthMeter.nextElementSibling;
        passwordStrengthMeter.value = strength;
        passwordStrengthMeter.textContent = `${strength * 25}%`;
        if (strength < 2) {
            passwordStrengthMeter.style.setProperty('--strength-color', 'red'); // Red
        } else if (strength < 3) {
            passwordStrengthMeter.style.setProperty('--strength-color', 'orange'); // Orange
        } else if (strength < 4) {
            passwordStrengthMeter.style.setProperty('--strength-color', 'yellow'); // Yellow
        } else {
            passwordStrengthMeter.style.setProperty('--strength-color', 'green'); // Green
        }
        // Check which requirements are met
        const requirements = [
            { regex: /[a-z]/, message: 'Au moins une lettre minuscule' },
            { regex: /[A-Z]/, message: 'Au moins une lettre majuscule' },
            { regex: /[0-9]/, message: 'Au moins un chiffre' },
            { regex: /[!@#$%ˆ&*()_+]/, message: 'Au moins un caractère spécial' },
            { regex: /.{6,}/, message: 'Au moins 6 caractères' },
            { regex: /.{8,}/, message: 'plus de 8 caractères' },
        ];
    
        // Update the requirements list
        const listItems = passwordRequirements.querySelectorAll('li');
        requirements.forEach((requirement, index) => {
            if (requirement.regex.test(password)) {
                listItems[index].style.color = 'green'; // Requirement met
            } else {
                listItems[index].style.color = 'grey'; // Requirement not met
            }
        });
    });

    // Helper function to calculate password strength
    function calculatePasswordStrength(password) {
        let strength = 0;
        if (password.match(/[a-z]+/)) {
            strength++;
        }
        if (password.match(/[A-Z]+/)) {
            strength++;
        }
        if (password.match(/[0-9]+/)) {
            strength++;
        }
        if (password.match(/[!@#$%ˆ&*()_+]+/) && password.length > 7) {
            strength++;
        }
        return strength;
    }

        // Validate password with specific rules
    function validatePassword() {
        const passwordInput = document.querySelector('#new-password');
        const password = passwordInput.value.trim();

        // Regular expressions for each rule
        const hasLowercase = /[a-z]/.test(password); // at least one lowercase letter
        const hasUppercase = /[A-Z]/.test(password); // at least one uppercase letter
        const hasDigit = /\d/.test(password); // at least one digit
        const hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/.test(password); // at least one special character
        const isLongEnough = password.length >= 8; // at least 8 characters

        // Combine all rules
        const isValid = hasLowercase && hasUppercase && hasDigit && hasSpecialChar && isLongEnough;

        // Feedback to user (you can customize this based on your design)
        if (isValid) {
            passwordInput.classList.remove('invalid');
            passwordInput.classList.add('valid');
        } else {
            passwordInput.classList.add('invalid');
            passwordInput.classList.remove('valid');
        }
        enableResetButton();
    }

    // Validate password confirmation
    function validatePasswordConfirmation() {
        const passwordInput = document.querySelector('#new-password');
        const password = passwordInput.value;
        const passwordConfirmationInput = document.querySelector('#confirmation-password');
        const passwordConfirmation = passwordConfirmationInput.value;

        const isValid = password === passwordConfirmation;

        if (isValid) {
            passwordConfirmationInput.classList.remove('invalid');
        } else {
            passwordConfirmationInput.classList.add('invalid');
        }
        enableResetButton();
    }

    // Function that enables the submit button only if all the inputs are filled in and the passwords match
    function enableResetButton() {
        const submitButton = document.querySelector('.reset');
        const password = document.querySelector('#new-password');
        const passwordValue = password.value;
        const passwordConfirmationValue = document.querySelector('#confirmation-password').value;
        let isFilled = false;
        if (password.classList.contains('valid')) {
            isFilled = true;
        }
        const passwordsMatch = passwordValue === passwordConfirmationValue;
        if (isFilled && passwordsMatch) {
            submitButton.classList.remove('disabled');
            submitButton.removeAttribute('disabled');
        } else {
            submitButton.classList.add('disabled');
            submitButton.setAttribute('disabled', 'true');
        }
    }

    // Function that add event listenmers to the form inputs
    function checkEventListeners() {
        document.querySelector('#new-password').addEventListener('input', validatePassword);
        document.querySelector('#confirmation-password').addEventListener('input', validatePasswordConfirmation);
    }

    // Attach event listeners after the modal is updated
    checkEventListeners();

    // Fetch information frominputs to the controller
    document.addEventListener("DOMContentLoaded", function() {
        const urlParams = new URLSearchParams(window.location.search);
        const token = urlParams.get("token");
        document.getElementById("token").value = token;
    })
    document.getElementById("reset-password-form").addEventListener("submit", function(event) {
        event.preventDefault();
        let token = document.getElementById("token").value;
        let password = document.getElementById("new-password").value;
    
        fetch('index.php?url=resetPasswordLogic', {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "token=" + encodeURIComponent(token) + "&password=" + encodeURIComponent(password),
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById("reset-message").textContent = data.message;
            // Redirection after 3 seconds
            if (data.success) {
                setTimeout(() => {
                    window.location.href = data.redirect;
                }, 3000);
            }
        })
        .catch(error => console.error("Error:", error));
    });
</script>

