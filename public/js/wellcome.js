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
            switchModal('register');
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

        //=================================================== SUBMIT LOGIC ===================================================//
        // Handle the submission of the login form
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

        // Create the last name container
        const lastNameContainer = document.createElement('div');
        lastNameContainer.classList.add('lastName-container');
        // Create the last name input
        const lastNameLineInput = document.createElement('div');
        lastNameLineInput.classList.add('line-input');
        // Create the lastName icon container
        const lastNameIconContainer = document.createElement('div');
        lastNameIconContainer.classList.add('line-input_icon-container', 'lastName-icon-container');
        // Add Font Awesome icon
        const lastNameIcon = document.createElement('i');
        lastNameIcon.classList.add('fas', 'fa-circle-question',);
        lastNameIcon.title = 'Le nom doit contenir au moins 2 lettres, sans caractères spéciaux, chiffres ou plusieurs espaces';
        lastNameIconContainer.appendChild(lastNameIcon);
        lastNameContainer.appendChild(lastNameIconContainer);

        // Create the last name input
        const lastNameInput = document.createElement('input');
        lastNameInput.type = 'text';
        lastNameInput.name = 'lastName';
        lastNameInput.id = 'lastName';
        lastNameInput.autocomplete = 'new-lastName';
        lastNameInput.required = true;
        lastNameContainer.appendChild(lastNameInput);
 
        // Create the last name label
        const lastNameLabel = document.createElement('label');
        lastNameLabel.classList.add('required');
        lastNameLabel.htmlFor = 'lastName';
        lastNameLabel.textContent = 'Nom';
        lastNameLineInput.appendChild(lastNameLabel);
        lastNameLineInput.appendChild(lastNameContainer);  

        // Create the first name container
        const firstNameContainer = document.createElement('div');
        firstNameContainer.classList.add('firstName-container');
        // Create the first name input
        const firstNameLineInput = document.createElement('div');
        firstNameLineInput.classList.add('line-input');
        // Create the firstName icon container
        const firstNameIconContainer = document.createElement('div');
        firstNameIconContainer.classList.add('line-input_icon-container', 'firstName-icon-container');
        // Add Font Awesome icon
        const firstNameIcon = document.createElement('i');
        firstNameIcon.classList.add('fas', 'fa-circle-question',);
        firstNameIcon.title = 'Le prénom doit contenir au moins 2 lettres, sans caractères spéciaux, chiffres ou plusieurs espaces';
        firstNameIconContainer.appendChild(firstNameIcon);
        firstNameContainer.appendChild(firstNameIconContainer);
        // Create the first name input
        const firstNameInput = document.createElement('input');
        firstNameInput.type = 'text';
        firstNameInput.name = 'firstName';
        firstNameInput.id = 'firstName';
        firstNameInput.autocomplete = 'new-firstName';
        firstNameInput.required = true;
        firstNameContainer.appendChild(firstNameInput);
        // Create the first name label
        const firstNameLabel = document.createElement('label');
        firstNameLabel.classList.add('required');
        firstNameLabel.htmlFor = 'firstName';
        firstNameLabel.textContent = 'Prénom(s)';
        firstNameLineInput.appendChild(firstNameLabel);
        firstNameLineInput.appendChild(firstNameContainer);

        // Create the email container
        const emailContainer = document.createElement('div');
        emailContainer.classList.add('email-container');
        // Create the email input
        const emailLineInput = document.createElement('div');
        emailLineInput.classList.add('line-input');
        // Create the email icon container
        const emailIconContainer = document.createElement('div');
        emailIconContainer.classList.add('line-input_icon-container', 'email-icon-container');
        // Add Font Awesome icon
        const emailIcon = document.createElement('i');
        emailIcon.classList.add('fas', 'fa-circle-question',);
        emailIcon.title = 'Entrez une adresse e-mail valide';
        emailIconContainer.appendChild(emailIcon);
        emailContainer.appendChild(emailIconContainer);
        // Create the email input
        const emailInput = document.createElement('input');
        emailInput.type = 'email';
        emailInput.name = 'email';
        emailInput.id = 'email';
        emailInput.autocomplete = 'new-email';
        emailInput.required = true;
        emailContainer.appendChild(emailInput);
        // Create the email error message container
        const emailErrorMessage = document.createElement('div');
        emailErrorMessage.classList.add('error-message-container');
        emailErrorMessage.classList.add('hidden');
        emailContainer.appendChild(emailErrorMessage);
        // Create the email label
        const emailLabel = document.createElement('label');
        emailLabel.classList.add('required');
        emailLabel.htmlFor = 'email';
        emailLabel.textContent = 'E-mail';
        emailLineInput.appendChild(emailLabel);
        emailLineInput.appendChild(emailContainer);

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
            'Au moins 8 caractères',
        ];
        passwordRequirementsItems.forEach(item => {
            const passwordRequirementsItem = document.createElement('li');
            passwordRequirementsItem.textContent = item;
            passwordRequirements.appendChild(passwordRequirementsItem);
        }
        );

        // Create the password label
        const passwordLabel = document.createElement('label');
        passwordLabel.classList.add('required');
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
        passwordConfirmationLabel.classList.add('required');
        passwordConfirmationLabel.htmlFor = 'passwordConfirmation';
        passwordConfirmationLabel.textContent = 'Confirmer le mot de passe';
        passwordConfirmationLineInput.appendChild(passwordConfirmationLabel);
        passwordConfirmationLineInput.appendChild(passwordConfirmationContainer);

        // Create the error message container
        const errorMessage = document.createElement('div');
        errorMessage.classList.add('error-message');
        errorMessage.classList.add('hidden');

        // Create the submit button
        const submitButton = document.createElement('button');
        submitButton.type = 'submit';
        submitButton.classList.add('submit-button');
        submitButton.classList.add('disabled');
        submitButton.textContent = `S'inscrire`;
        submitButton.setAttribute('disabled', 'true');

        // Create the login button
        const switchModalContainer = document.createElement('div');
        switchModalContainer.classList.add('switch_modal-container');
        const switcModalText = document.createElement('span');
        switcModalText.textContent = `Déjà client ? `;

        const switchModalLink = document.createElement('a');
        switchModalLink.classList.add('switch_modal-link');
        switchModalLink.textContent = `Se connecter`;
        switchModalLink.addEventListener('click', () => {
            switchModal('login');
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
        registerForm.appendChild(errorMessage);
        registerForm.appendChild(submitButton);
        registerForm.appendChild(switchModalContainer);
       
       //=================================================== SUBMIT LOGIC ===================================================//
        // Handle the submission of the login form
        registerForm.addEventListener('submit', async (event) => {
            event.preventDefault();

            const lastNameInput = document.querySelector('#lastName');
            const lastName = lastNameInput.value;
            const firstNameInput = document.querySelector('#firstName');
            const firstName = firstNameInput.value;
            const emailInput = document.querySelector('#email');
            const email = emailInput.value;
            const passwordInput = document.querySelector('#password');
            const password = passwordInput.value;
            const passwordConfirmationInput = document.querySelector('#passwordConfirmation');
            const passwordConfirmation = passwordConfirmationInput.value;

            const errorMessage = document.querySelector('.error-message');

            function hideErrorMessage() {
                errorMessage.classList.add('hidden'); // Add hidden class
            }
        
            try {
                const response = await fetch('index.php?url=register', { // Path to RegisterController
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ lastName, firstName, email, password, passwordConfirmation })
                });
            
                const result = await response.json();
            
                if (result.success) {
                    // alert('Login successful!');
                    errorMessage.classList.remove('hidden');
                    errorMessage.style.color = '#26a18c';
                    errorMessage.textContent = result.message || 'Inscription réussie';
                    // Wait 2 seconds before switching to the login modal
                    setTimeout(() => switchModal('login'), 3000); 
                } else {
                    errorMessage.classList.remove('hidden');
                    errorMessage.textContent = result.message || 'Invalid credentials';
                }
                emailInput.addEventListener('input', hideErrorMessage);
                passwordInput.addEventListener('input', hideErrorMessage);
            } catch (error) {
                // console.error('Error:', error);
                alert('Quelque chose a mal tourné.');
            }
        });
        return registerForm;
    }
}

// Intial call to the function to create the login form and append it to the page
switchModal('login');

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


// Verify that the last name is at least 2 characters long (trim spaces) and contains at least 2 letters
function validateLastName() {
    const lastNameInput = document.querySelector('#lastName');
    let lastName = lastNameInput.value;
    let lastNameIconContainer = document.querySelector('.lastName-icon-container');
    let lastNameIcon = document.querySelector('.lastName-icon-container svg');
    // Transform only the first letter to uppercase and keep the rest the same
    lastName = lastName.charAt(0).toUpperCase() + lastName.slice(1);
    const trimmedLastName = lastName.trim();
    // Regex to allow only letters and single spaces between words, and ensure at least 2 characters
    const isValid = trimmedLastName.length >= 2 && /^[a-zA-ZÀ-ÿ]+([ '.-]?[a-zA-ZÀ-ÿ]+)*$/.test(trimmedLastName);
    
    if (isValid) {
        lastNameInput.classList.remove('invalid');
        lastNameInput.classList.add('valid');
        if (lastNameIcon) {
            lastNameIcon.classList.remove('fa-circle-question', 'fa-circle-xmark');
            lastNameIcon.classList.add('fa-circle-check');
            lastNameIcon.style.color = '#26a18c';
        }
    } else {
        lastNameInput.classList.remove('valid');
        lastNameInput.classList.add('invalid');
        if (lastNameIcon) {
            lastNameIcon.classList.remove('fa-circle-question', 'fa-circle-check');
            lastNameIcon.classList.add('fa-circle-xmark');
            lastNameIcon.style.color = '#ee3939';
            lastNameIconContainer.title = 'Le nom doit contenir au moins 2 lettres, sans caractères spéciaux, chiffres ou plusieurs espaces';
        }
    }
    // Update the input field with the modified name
    lastNameInput.value = lastName;

    enableSubmitButton();
}
    // document.querySelector('#lastName').addEventListener('keyup', validateLastName);

// Verify that the first name is at least 2 characters long (trim spaces) and contains at least 2 letters
function validateFirstName() {
    const firstNameInput = document.querySelector('#firstName');
    let firstNameIconContainer = document.querySelector('.firstName-icon-container');
    let firstNameIcon = document.querySelector('.firstName-icon-container svg');
    let firstName = firstNameInput.value;
    // Transform only the first letter to uppercase and keep the rest the same
    firstName = firstName.charAt(0).toUpperCase() + firstName.slice(1);
    const trimmedFirstName = firstName.trim();
    
    // Regex to allow only letters and single spaces between words, and ensure at least 2 characters
    const isValid = trimmedFirstName.length >= 2 && /^[a-zA-ZÀ-ÿ]+([ '.-]?[a-zA-ZÀ-ÿ]+)*$/.test(trimmedFirstName);
    if (isValid) {
        firstNameInput.classList.remove('invalid');
        firstNameInput.classList.add('valid');
        if (firstNameIcon) {
            firstNameIcon.classList.remove('fa-circle-question', 'fa-circle-xmark');
            firstNameIcon.classList.add('fa-circle-check');
            firstNameIcon.style.color = '#26a18c';
        }
    } else {
        firstNameInput.classList.remove('valid');
        firstNameInput.classList.add('invalid');
        if (firstNameIcon) {
            firstNameIcon.classList.remove('fa-circle-question', 'fa-circle-check');
            firstNameIcon.classList.add('fa-circle-xmark');
            firstNameIcon.style.color = '#ee3939';
            firstNameIconContainer.title = 'Le prénom doit contenir au moins 2 lettres, sans caractères spéciaux, chiffres ou plusieurs espaces';
        }
    }
    // Update the input field with the modified name
    firstNameInput.value = firstName;

    enableSubmitButton();
}
// document.querySelector('#firstName').addEventListener('keyup', validateFirstName);

// Validate email format and uniqueness
function validateEmail() {
    const emailInput = document.querySelector('#email');
    const emailIcon = document.querySelector('.email-icon-container svg');
    const emailIconContainer = document.querySelector('.email-icon-container');
    const emailErrorMessageContainer = document.querySelector('.error-message-container');
    const email = emailInput.value.trim();
    const emailRegex = /^[a-zA-Z0-9._%+-éèàçùâêîôûëïöüñ]+@[a-zA-Z0-9.-éèàçùâêîôûëïöüñ]+\.[a-zA-Z]{2,}$/;

    // Check if email is filled
    if (!email) {
        updateIconAndStyles(emailInput, emailIcon, 'fa-circle-question', '#ee9639', 'Entrez une adresse e-mail');
        emailErrorMessageContainer.classList.remove('hidden');
        emailErrorMessageContainer.textContent = 'Le champ e-mail est requis.';
        enableSubmitButton();
        return;
    }

    // Validate email format
    const isValidFormat = emailRegex.test(email);
    if (!isValidFormat) {
        updateIconAndStyles(emailInput, emailIcon, 'fa-circle-xmark', '#ee3939', 'Entrez une adresse e-mail valide');
        emailErrorMessageContainer.classList.remove('hidden');
        emailErrorMessageContainer.textContent = 'Format d\'adresse e-mail invalide.';
        enableSubmitButton();
        return;
    }

    // Check if email already exists in the clients array
    const emailExists = clients.some(client => client.email === email);
    if (emailExists) {
        updateIconAndStyles(emailInput, emailIcon, 'fa-circle-xmark', '#ee3939', 'Cet e-mail est déjà enregistré');
        emailErrorMessageContainer.classList.remove('hidden');
        emailErrorMessageContainer.textContent = 'Cet email est déjà enregistré. Veuillez vous connecter.';
        enableSubmitButton();
        return;
    }

    // If all checks pass
    updateIconAndStyles(emailInput, emailIcon, 'fa-circle-check', '#26a18c', '');
    emailErrorMessageContainer.classList.add('hidden');
    emailErrorMessageContainer.textContent = '';
    enableSubmitButton();
}

// Helper function to update the icon and styles
function updateIconAndStyles(input, icon, iconClass, color, tooltip) {
    input.classList.remove('invalid', 'valid');
    icon.className = ''; // Clear previous icon classes
    if (iconClass === 'fa-circle-check') {
        input.classList.add('valid');
    } else {
        input.classList.add('invalid');
    }
    icon.classList.add('fas', iconClass);
    icon.style.color = color;
    const iconContainer = document.querySelector('.email-icon-container');
    if (iconContainer) {
        iconContainer.title = tooltip;
    }
}
// document.querySelector('#email').addEventListener('input', validateEmail);

// Validate password with specific rules
function validatePassword() {
    const passwordInput = document.querySelector('#password');
    const password = passwordInput.value.trim();

    // Regular expressions for each rule
    const hasLowercase = /[a-z]/.test(password); // at least one lowercase letter
    const hasUppercase = /[A-Z]/.test(password); // at least one uppercase letter
    const hasDigit = /\d/.test(password); // at least one digit
    const hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/.test(password); // at least one special character
    const isLongEnough = password.length >= 8; // at least 6 characters

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

    enableSubmitButton();
}
// document.querySelector('#password').addEventListener('input', validatePassword);

// Validate password confirmation
function validatePasswordConfirmation() {
    const passwordInput = document.querySelector('#password');
    const password = passwordInput.value;
    const passwordConfirmationInput = document.querySelector('#passwordConfirmation');
    const passwordConfirmation = passwordConfirmationInput.value;

    const isValid = password === passwordConfirmation;

    if (isValid) {
        passwordConfirmationInput.classList.remove('invalid');
    } else {
        passwordConfirmationInput.classList.add('invalid');
    }

    enableSubmitButton();
}
// document.querySelector('#passwordConfirmation').addEventListener('input', validatePasswordConfirmation);

// Function that enables the submit button only if all the inputs are filled in and the passwords match
function enableSubmitButton() {
    const submitButton = document.querySelector('.submit-button');
    const lastName = document.querySelector('#lastName');
    const firstName = document.querySelector('#firstName');
    const email = document.querySelector('#email');
    const password = document.querySelector('#password');
    const passwordValue = password.value;
    const passwordConfirmationValue = document.querySelector('#passwordConfirmation').value;
    let isFilled = false;
    if (lastName.classList.contains('valid') && firstName.classList.contains('valid') && email.classList.contains('valid') && password.classList.contains('valid')) {
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
    const registerForm = document.querySelector('#registerForm');
    if(registerForm) {
        document.querySelector('#lastName').addEventListener('keyup', validateLastName);
        document.querySelector('#firstName').addEventListener('keyup', validateFirstName);
        document.querySelector('#email').addEventListener('input', validateEmail);
        document.querySelector('#password').addEventListener('input', validatePassword);
        document.querySelector('#passwordConfirmation').addEventListener('input', validatePasswordConfirmation);
    }
}

// Function that clears the modal container and renders a new one into it
function switchModal(modalType) {
    const formContainer = document.querySelector('.form-container');
    formContainer.innerHTML = '';
    // Create and append new modal
    formContainer.appendChild(createModal(modalType)); 
    // Attach event listeners after the modal is updated
    checkEventListeners(); 
}