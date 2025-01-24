function createModal(type) {
    const formContainer = document.querySelector('.form-container');
    if (type === 'login') {
        formContainer.innerHTML = '';
        // Create login form
        const loginForm = document.createElement('form');
        loginForm.action = '/login';
        loginForm.id = 'loginForm';
        loginForm.className = 'login-form';

        // Create the title
        const formTitle = document.createElement('h2');
        formTitle.textContent = 'Se connecter';

        const emailLineInput = document.createElement('div');
        emailLineInput.classList.add('line-input');
        // Create the email input
        const emailInput = document.createElement('input');
        emailInput.type = 'email';
        emailInput.name = 'email';
        emailInput.id = 'email';
        emailInput.autocomplete = 'current-email';
        emailInput.required = true;
        // Create the email label
        const emailLabel = document.createElement('label');
        emailLabel.htmlFor = 'email';
        emailLabel.textContent = 'E-mail';
        emailLineInput.appendChild(emailLabel);
        emailLineInput.appendChild(emailInput);

        const passwordLineInput = document.createElement('div');
        passwordLineInput.classList.add('line-input');
        // Create the password input
        const passwordContainer = document.createElement('div');
        passwordContainer.classList.add('password-container');
        const passwordInput = document.createElement('input');
        passwordInput.type = 'password';
        passwordInput.name = 'password';
        passwordInput.id = 'password';
        passwordInput.autocomplete = 'current-password';
        passwordInput.required = true;
        // Create the password show/hide button
        const passwordShowHideButton = document.createElement('button');
        passwordShowHideButton.type = 'button';
        passwordShowHideButton.classList.add('password-show-hide-button');
        // Add Font Awesome icon
        const passwordIcon = document.createElement('i');
        passwordIcon.classList.add('fas', 'fa-eye-slash');
        passwordShowHideButton.appendChild(passwordIcon);
        // Toggle password visibility and update icon
        passwordShowHideButton.addEventListener('click', () => {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.className = 'fas fa-eye';
                passwordShowHideButton.innerHTML = '';
                passwordShowHideButton.appendChild(passwordIcon);
            } else {
                passwordInput.type = 'password';
                passwordIcon.className = 'fas fa-eye-slash';
                passwordShowHideButton.innerHTML = '';
                passwordShowHideButton.appendChild(passwordIcon);
            }
        });
        passwordContainer.appendChild(passwordInput);
        passwordContainer.appendChild(passwordShowHideButton);

        // Create the password label
        const passwordLabel = document.createElement('label');
        passwordLabel.htmlFor = 'password';
        passwordLabel.textContent = 'Mot de passe';
        passwordLineInput.appendChild(passwordLabel);
        passwordLineInput.appendChild(passwordContainer);

        // Create the error message container
        const errorMessage = document.createElement('div');
        errorMessage.classList.add('error-message-container');
        errorMessage.classList.add('hidden');

        // Create the forgot password button
        const forgotPasswordButton = document.createElement('a');
        forgotPasswordButton.classList.add('forgot-password');
        forgotPasswordButton.href = '#';
        forgotPasswordButton.textContent = 'Mot de passe oublié ?';

        // Create the submit button
        const submitButton = document.createElement('button');
        submitButton.type = 'submit';
        submitButton.classList.add('submit-button');
        submitButton.textContent = 'Se connecter';

        // Create the register button
        const switchModalContainer = document.createElement('div');
        switchModalContainer.classList.add('switch_modal-container');
        const switcModalText = document.createElement('span');
        switcModalText.textContent = `Pas encore de compte ? `;

        const switchModalLink = document.createElement('a');
        switchModalLink.classList.add('switch_modal-link');
        switchModalLink.textContent = `S'inscrire`;
        switchModalLink.addEventListener('click', () => {
            formContainer.innerHTML = '';
            formContainer.appendChild(createModal('register'));
        });
        switchModalContainer.appendChild(switcModalText);
        switchModalContainer.appendChild(switchModalLink);

        // Appending all together
        loginForm.appendChild(formTitle);
        loginForm.appendChild(emailLineInput);
        loginForm.appendChild(passwordLineInput);
        loginForm.appendChild(errorMessage);
        loginForm.appendChild(forgotPasswordButton);
        loginForm.appendChild(submitButton);
        loginForm.appendChild(switchModalContainer);
        return loginForm;
    } else if (type === 'register') {
        formContainer.innerHTML = '';
        // Create register form
        const registerForm = document.createElement('form');
        registerForm.id = 'registerForm';
        registerForm.className = 'register-form';

        // Create the title
        const formTitle = document.createElement('h2');
        formTitle.textContent = `S'inscrire`;

        const lastNameLineInput = document.createElement('div');
        lastNameLineInput.classList.add('line-input');
        // Create the last name input
        const lastNameInput = document.createElement('input');
        lastNameInput.type = 'text';
        lastNameInput.name = 'lastName';
        lastNameInput.id = 'lastName';
        lastNameInput.autocomplete = 'new-lastName';
        lastNameInput.required = true;
        // Create the last name label
        const lastNameLabel = document.createElement('label');
        lastNameLabel.htmlFor = 'lastName';
        lastNameLabel.textContent = 'Nom';
        lastNameLineInput.appendChild(lastNameLabel);
        lastNameLineInput.appendChild(lastNameInput);

        const firstNameLineInput = document.createElement('div');
        firstNameLineInput.classList.add('line-input');
        // Create the first name input
        const firstNameInput = document.createElement('input');
        firstNameInput.type = 'text';
        firstNameInput.name = 'firstName';
        firstNameInput.id = 'firstName';
        firstNameInput.autocomplete = 'new-firstName';
        firstNameInput.required = true;
        // Create the first name label
        const firstNameLabel = document.createElement('label');
        firstNameLabel.htmlFor = 'firstName';
        firstNameLabel.textContent = 'Prénom(s)';
        firstNameLineInput.appendChild(firstNameLabel);
        firstNameLineInput.appendChild(firstNameInput);

        const emailLineInput = document.createElement('div');
        emailLineInput.classList.add('line-input');
        // Create the email input
        const emailInput = document.createElement('input');
        emailInput.type = 'email';
        emailInput.name = 'email';
        emailInput.id = 'email';
        emailInput.autocomplete = 'new-email';
        emailInput.required = true;
        // Create the email label
        const emailLabel = document.createElement('label');
        emailLabel.htmlFor = 'email';
        emailLabel.textContent = 'E-mail';
        emailLineInput.appendChild(emailLabel);
        emailLineInput.appendChild(emailInput);

        const passwordLineInput = document.createElement('div');
        passwordLineInput.classList.add('line-input');

        const passwordContainer = document.createElement('div');
        passwordContainer.classList.add('password-container');
        // Create the password input
        const passwordInput = document.createElement('input');
        passwordInput.type = 'password';
        passwordInput.name = 'password';
        passwordInput.id = 'password';
        passwordInput.className = 'password-input';
        passwordInput.autocomplete = 'new-password';
        passwordInput.required = true;
        // Create the password show/hide button
        const passwordShowHideButton = document.createElement('button');
        passwordShowHideButton.type = 'button';
        passwordShowHideButton.classList.add('password-show-hide-button');
        // Add Font Awesome icon
        const passwordIcon = document.createElement('i');
        passwordIcon.classList.add('fas', 'fa-eye-slash');
        passwordShowHideButton.appendChild(passwordIcon);
        // Toggle password visibility and update icon
        passwordShowHideButton.addEventListener('click', () => {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.className = 'fas fa-eye';
                passwordShowHideButton.innerHTML = '';
                passwordShowHideButton.appendChild(passwordIcon);
            } else {
                passwordInput.type = 'password';
                passwordIcon.className = 'fas fa-eye-slash';
                passwordShowHideButton.innerHTML = '';
                passwordShowHideButton.appendChild(passwordIcon);
            }
        });
        passwordContainer.appendChild(passwordInput);
        passwordContainer.appendChild(passwordShowHideButton);

        //Create the password strength meter
        const passwordStrengthMeter = document.createElement('meter');
        passwordStrengthMeter.id = 'password-strength-meter';
        passwordStrengthMeter.className = 'password-strength-meter';
        passwordStrengthMeter.max = '4';
        passwordStrengthMeter.low = '1';
        passwordStrengthMeter.high = '3';
        passwordStrengthMeter.optimum = '4';
        passwordStrengthMeter.value = '0';
        passwordStrengthMeter.textContent = '0%';
        passwordInput.addEventListener('input', () => {
            const password = passwordInput.value;
            const strength = calculatePasswordStrength(password);
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

        // Create the password requirements
        const passwordRequirements = document.createElement('ul');
        passwordRequirements.style.margin = '0';
        passwordRequirements.style.padding = '0';
        passwordRequirements.style.listStyle = 'none';
        const passwordRequirementsItems = [
            'Au moins une lettre minuscule',
            'Au moins une lettre majuscule',
            'Au moins un chiffre',
            'Au moins un caractère spécial',
            'Au moins 6 caractères',
            'Plus de 8 caractères',
        ];
        passwordRequirementsItems.forEach(item => {
            const passwordRequirementsItem = document.createElement('li');
            passwordRequirementsItem.textContent = item;
            passwordRequirements.appendChild(passwordRequirementsItem);
        }
        );

        // Create the password label
        const passwordLabel = document.createElement('label');
        passwordLabel.htmlFor = 'password';
        passwordLabel.textContent = 'Mot de passe';
        passwordLineInput.appendChild(passwordLabel);
        passwordLineInput.appendChild(passwordContainer);
        passwordLineInput.appendChild(passwordStrengthMeter);
        passwordLineInput.appendChild(passwordRequirements);

        const passwordConfirmationLineInput = document.createElement('div');
        passwordConfirmationLineInput.classList.add('line-input');

        const passwordConfirmationContainer = document.createElement('div');
        passwordConfirmationContainer.classList.add('password-container');
        // Create the password confirmation input
        const passwordConfirmationInput = document.createElement('input');
        passwordConfirmationInput.type = 'password';
        passwordConfirmationInput.name = 'passwordConfirmation';
        passwordConfirmationInput.id = 'passwordConfirmation';
        passwordConfirmationInput.className = 'password-input';
        passwordConfirmationInput.autocomplete = 'new-password';
        passwordConfirmationInput.required = true;
        // Create the password confirmation show/hide button
        const passwordConfirmationShowHideButton = document.createElement('button');
        passwordConfirmationShowHideButton.type = 'button';
        passwordConfirmationShowHideButton.classList.add('password-show-hide-button');
        // Add Font Awesome icon
        const passwordConfirmationIcon = document.createElement('i');
        passwordConfirmationIcon.classList.add('fas', 'fa-eye-slash');
        passwordConfirmationShowHideButton.appendChild(passwordConfirmationIcon);
        // Toggle password visibility and update icon
        passwordConfirmationShowHideButton.addEventListener('click', () => {
            if (passwordConfirmationInput.type === 'password') {
                passwordConfirmationInput.type = 'text';
                passwordConfirmationIcon.className = 'fas fa-eye';
                passwordConfirmationShowHideButton.innerHTML = '';
                passwordConfirmationShowHideButton.appendChild(passwordConfirmationIcon);
            } else {
                passwordConfirmationInput.type = 'password';
                passwordConfirmationIcon.className = 'fas fa-eye-slash';
                passwordConfirmationShowHideButton.innerHTML = '';
                passwordConfirmationShowHideButton.appendChild(passwordConfirmationIcon);
            }
        });
        passwordConfirmationContainer.appendChild(passwordConfirmationInput);
        passwordConfirmationContainer.appendChild(passwordConfirmationShowHideButton);
        // Create the password confirmation label
        const passwordConfirmationLabel = document.createElement('label');
        passwordConfirmationLabel.htmlFor = 'passwordConfirmation';
        passwordConfirmationLabel.textContent = 'Confirmer le mot de passe';
        passwordConfirmationLineInput.appendChild(passwordConfirmationLabel);
        passwordConfirmationLineInput.appendChild(passwordConfirmationContainer);

        // Create the submit button
        const submitButton = document.createElement('button');
        submitButton.type = 'submit';
        submitButton.classList.add('submit-button');
        submitButton.textContent = `S'inscrire`;

        // Create the login button
        const switchModalContainer = document.createElement('div');
        switchModalContainer.classList.add('switch_modal-container');
        const switcModalText = document.createElement('span');
        switcModalText.textContent = `Déjà client ? `;

        const switchModalLink = document.createElement('a');
        switchModalLink.classList.add('switch_modal-link');
        switchModalLink.textContent = `Se connecter`;
        switchModalLink.addEventListener('click', () => {
            formContainer.innerHTML = '';
            formContainer.appendChild(createModal('login'));
        });
        switchModalContainer.appendChild(switcModalText);
        switchModalContainer.appendChild(switchModalLink);


        // Appending all together
        registerForm.appendChild(formTitle);
        registerForm.appendChild(lastNameLineInput);
        registerForm.appendChild(firstNameLineInput);
        registerForm.appendChild(emailLineInput);
        registerForm.appendChild(passwordLineInput);
        registerForm.appendChild(passwordConfirmationLineInput);
        registerForm.appendChild(submitButton);
        registerForm.appendChild(switchModalContainer);
        return registerForm;
    }
}

const formContainer = document.querySelector('.form-container');
formContainer.appendChild(createModal('login'));

function calculatePasswordStrength(password) {
    let strength = 0;
    if (password.match(/[a-z]+/)) {
        strength++;
    }
    if (password.match(/[A-Z]+/)) {
        strength++;
    }
    if (password.match(/[0-9]+/) && password.length > 5) {
        strength++;
    }
    if (password.match(/[!@#$%ˆ&*()_+]+/) && password.length > 7) {
        strength++;
    }
    return strength;
}

loginForm.addEventListener('submit', async (event) => {
    event.preventDefault();
    
    const emailInput = document.querySelector('#email');
    const email = emailInput.value;
    const passwordInput = document.querySelector('#password');
    const password = passwordInput.value;
    const errorMessage = document.querySelector('.error-message-container');
    
    function hideErrorMessage() {
        errorMessage.classList.add('hidden'); // Add hidden class
    }

    try {
        const response = await fetch('index.php?url=login', { // Path to LoginController
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ email, password })
        });

        const result = await response.json();

        if (result.success) {
            // alert('Login successful!');
            window.location.href = 'index.php'; // Redirect after success
        } else {
            errorMessage.classList.remove('hidden');
            errorMessage.textContent = result.message || 'Invalid credentials';
        }
        emailInput.addEventListener('input', hideErrorMessage);
        passwordInput.addEventListener('input', hideErrorMessage);
    } catch (error) {
        console.error('Error:', error);
        alert('Quelque chose a mal tourné.');
    }
});