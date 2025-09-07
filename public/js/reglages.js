function showModal(action) {
    // Getting overlay
    const overlay = document.getElementById('overlay'); 
    overlay.classList.remove('hidden');
    // Creating modal window into DOM
    const modal = document.createElement('div');
    modal.id=`modal_${action}`;
    modal.className = `modal modal-${action}`;
    // Creating modal form
    const form = document.createElement('form');
    form.id = `form_${action}`;
    form.className = `form form-${action}`;
    form.action = `client&page=${action}`;
    form.method = 'POST';
    form.enctype = 'multipart/form-data';
    // Creating dynamic modal form title
    const formTitle = document.createElement('h2');
    formTitle.className = 'form-title';
    switch (action) {
        case 'password':
            formTitle.textContent = 'Modification de mot de passe';
            break;
        case 'information':
            formTitle.textContent = 'Modification de l\'information';
            break;
        case 'photo':
            formTitle.textContent = 'Modification de photo du profil';
            break;
        case 'delete':
            formTitle.textContent = 'Suppression de compte personnel';
            break;
    }
    
    // Creating modal form close button
    const btnCloseModal = document.createElement('button');
    btnCloseModal.className = 'modal-close';
    btnCloseModal.onclick = (event) => hideModal(event);
    // Adding an icon to the close button
    const btnCloseModalIcone = document.createElement('i');
    btnCloseModalIcone.className = 'fas fa-xmark';
    btnCloseModal.append(btnCloseModalIcone);
    // Creating the form content block
    const formBody = document.createElement('div');
    formBody.className = 'form-body';

    switch (action) {
        case 'password':
            // Creating the hidden container Username for autocomplete
            const hiddenUsername = document.createElement('div');
            hiddenUsername.className = 'form-container hidden';
            hiddenUsername.style.height = '0';
            // Creating the input
            const hiddenUsernameInput = document.createElement('input');
            hiddenUsernameInput.id = 'hiddenUssername';
            hiddenUsernameInput.Name = 'hiddenUssername';
            hiddenUsernameInput.value = clientInfoJSON['email'];
            hiddenUsernameInput.autocomplete = 'username';
            // Appending all together to the parent container
            hiddenUsername.appendChild(hiddenUsernameInput);

            // Creating the container NewPassword
            const formContainerNewPassword = document.createElement('div');
            formContainerNewPassword.className = 'password new-password';
            // Creating the label
            const newPasswordLabel = document.createElement('label');
            newPasswordLabel.htmlFor = 'new-password';
            newPasswordLabel.className = 'form-label required';
            newPasswordLabel.textContent = 'Nouveau mot de passe:';
            // Creating the container that contains input and show-button
            const newPasswordContainer = document.createElement('div');
            newPasswordContainer.classList.add('password-container');
            // Creating the input
            const newPasswordInput = document.createElement('input');
            newPasswordInput.type = 'password';
            newPasswordInput.id = 'new-password';
            newPasswordInput.className = 'form-input';
            newPasswordInput.name = 'new-password';
            newPasswordInput.autocomplete = 'new-password';
            newPasswordInput.value = '';
            newPasswordInput.required = true;
            // Create the password show/hide button
            const newPasswordShowHideButton = document.createElement('button');
            newPasswordShowHideButton.type = 'button';
            newPasswordShowHideButton.classList.add('password-show-hide-button');
            // Add Font Awesome icon
            const newPasswordIcon = document.createElement('i');
            newPasswordIcon.classList.add('fas', 'fa-eye-slash');
            newPasswordShowHideButton.appendChild(newPasswordIcon);
            // Toggle password visibility and update icon
            newPasswordShowHideButton.addEventListener('click', () => {
                if (newPasswordInput.type === 'password') {
                    newPasswordInput.type = 'text';
                    newPasswordIcon.className = 'fas fa-eye';
                    newPasswordShowHideButton.innerHTML = '';
                    newPasswordShowHideButton.appendChild(newPasswordIcon);
                } else {
                    newPasswordInput.type = 'password';
                    newPasswordIcon.className = 'fas fa-eye-slash';
                    newPasswordShowHideButton.innerHTML = '';
                    newPasswordShowHideButton.appendChild(newPasswordIcon);
                }
            });
            newPasswordContainer.append(newPasswordInput);
            newPasswordContainer.append(newPasswordShowHideButton);
            // Appending all together to the parent container
            formContainerNewPassword.append(newPasswordLabel);
            formContainerNewPassword.append(newPasswordContainer);

            //Create the password strength meter
            const formContainerPasswordStrengthMeter = document.createElement('div');

            const passwordStrengthMeter = document.createElement('meter');
            passwordStrengthMeter.id = 'password-strength-meter';
            passwordStrengthMeter.className = 'password-strength-meter';
            passwordStrengthMeter.max = '4';
            passwordStrengthMeter.low = '1';
            passwordStrengthMeter.high = '3';
            passwordStrengthMeter.optimum = '4';
            passwordStrengthMeter.value = '0';
            passwordStrengthMeter.textContent = '0%';
            newPasswordInput.addEventListener('input', () => {
                const password = newPasswordInput.value;
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
            formContainerPasswordStrengthMeter.append(passwordStrengthMeter);
            formContainerPasswordStrengthMeter.append(passwordRequirements);

            // Creating the container ConfirmationPassword
            const formContainerConfirmationPassword = document.createElement('div');
            formContainerConfirmationPassword.className = 'password confirmation-password';
            // Creating the label
            const confirmationPasswordLabel = document.createElement('label');
            confirmationPasswordLabel.htmlFor = 'confirmation-password';
            confirmationPasswordLabel.className = 'form-label required';
            confirmationPasswordLabel.textContent = 'Confirmation de mot de passe:';
            // Creating the container that contains input and show-button
            const confirmationPasswordContainer = document.createElement('div');
            confirmationPasswordContainer.classList.add('password-container');
            // Creating the input
            const confirmationPasswordInput = document.createElement('input');
            confirmationPasswordInput.type = 'password';
            confirmationPasswordInput.id = 'confirmation-password';
            confirmationPasswordInput.className = 'form-input';
            confirmationPasswordInput.name = 'confirmation-password';
            confirmationPasswordInput.autocomplete = 'new-password';
            confirmationPasswordInput.value = '';
            confirmationPasswordInput.required = true;
            // Create the password show/hide button
            const confirmationPasswordShowHideButton = document.createElement('button');
            confirmationPasswordShowHideButton.type = 'button';
            confirmationPasswordShowHideButton.classList.add('password-show-hide-button');
            // Add Font Awesome icon
            const confirmationPasswordIcon = document.createElement('i');
            confirmationPasswordIcon.classList.add('fas', 'fa-eye-slash');
            confirmationPasswordShowHideButton.appendChild(confirmationPasswordIcon);
            // Toggle password visibility and update icon
            confirmationPasswordShowHideButton.addEventListener('click', () => {
                if (confirmationPasswordInput.type === 'password') {
                    confirmationPasswordInput.type = 'text';
                    confirmationPasswordIcon.className = 'fas fa-eye';
                    confirmationPasswordShowHideButton.innerHTML = '';
                    confirmationPasswordShowHideButton.appendChild(confirmationPasswordIcon);
                } else {
                    confirmationPasswordInput.type = 'password';
                    confirmationPasswordIcon.className = 'fas fa-eye-slash';
                    confirmationPasswordShowHideButton.innerHTML = '';
                    confirmationPasswordShowHideButton.appendChild(confirmationPasswordIcon);
                }
            });
            confirmationPasswordContainer.append(confirmationPasswordInput);
            confirmationPasswordContainer.append(confirmationPasswordShowHideButton);

            // Appending all together to the parent container
            formContainerConfirmationPassword.append(confirmationPasswordLabel);
            formContainerConfirmationPassword.append(confirmationPasswordContainer);

            // Appending all together
            formBody.appendChild(hiddenUsername);
            formBody.appendChild(formContainerNewPassword);
            formBody.appendChild(formContainerPasswordStrengthMeter);
            formBody.appendChild(formContainerConfirmationPassword);
            break;
        case 'information':
            // Creating the container LastName
            const formContainerLastName = document.createElement('div');
            formContainerLastName.className = 'form-container information-last-name';
            // Creating the label
            const informationLastNameLabel = document.createElement('label');
            informationLastNameLabel.htmlFor = 'lastName';
            informationLastNameLabel.className = 'form-label required';
            informationLastNameLabel.textContent = 'Nom:';
            // Creating the input
            const informationLastNameInput = document.createElement('input');
            informationLastNameInput.type = 'text';
            informationLastNameInput.id = 'lastName';
            informationLastNameInput.className = 'form-input valid';
            informationLastNameInput.name = 'lastName';
            informationLastNameInput.value = clientInfoJSON['lastName'];
            informationLastNameInput.required = true;
            // Create the error message container
            const informationLastNameErrorContainer = document.createElement('div');
            informationLastNameErrorContainer.id = 'lastNameErrorContainer';
            informationLastNameErrorContainer.classList.add('error-message-container');
            informationLastNameErrorContainer.classList.add('hidden');
            // Appending all together to the parent container
            formContainerLastName.append(informationLastNameLabel);
            formContainerLastName.append(informationLastNameInput);
            formContainerLastName.append(informationLastNameErrorContainer);

            // Creating the container FirstName
            const formContainerFirstName = document.createElement('div');
            formContainerFirstName.className = 'form-container information-first-name';
            // Creating the label
            const informationFirstNameLabel = document.createElement('label');
            informationFirstNameLabel.htmlFor = 'firstName';
            informationFirstNameLabel.className = 'form-label required';
            informationFirstNameLabel.textContent = 'Prénom:';
            // Creating the input
            const informationFirstNameInput = document.createElement('input');
            informationFirstNameInput.type = 'text';
            informationFirstNameInput.id = 'firstName';
            informationFirstNameInput.className = 'form-input valid';
            informationFirstNameInput.name = 'firstName';
            informationFirstNameInput.value = clientInfoJSON['firstName'];
            informationFirstNameInput.required = true;
            // Create the error message container
            const informationFirstNameErrorContainer = document.createElement('div');
            informationFirstNameErrorContainer.id = 'firstNameErrorContainer';
            informationFirstNameErrorContainer.classList.add('error-message-container');
            informationFirstNameErrorContainer.classList.add('hidden');
            // Appending all together to the parent container
            formContainerFirstName.append(informationFirstNameLabel);
            formContainerFirstName.append(informationFirstNameInput);
            formContainerFirstName.append(informationFirstNameErrorContainer);

            // Creating the container Email
            const formContainerEmail = document.createElement('div');
            formContainerEmail.className = 'form-container information-email';
            // Creating the label
            const informationEmailLabel = document.createElement('label');
            informationEmailLabel.htmlFor = 'email';
            informationEmailLabel.className = 'form-label required';
            informationEmailLabel.textContent = 'E-mail:';
            // Creating the input
            const informationEmailInput = document.createElement('input');
            informationEmailInput.type = 'email';
            informationEmailInput.id = 'email';
            informationEmailInput.className = 'form-input valid';
            informationEmailInput.name = 'email';
            informationEmailInput.value = clientInfoJSON['email'];
            informationEmailInput.required = true;
            // Create the error message container
            const informationEmailErrorContainer = document.createElement('div');
            informationEmailErrorContainer.id = 'emailErrorContainer';
            informationEmailErrorContainer.classList.add('error-message-container');
            informationEmailErrorContainer.classList.add('hidden');
            // Appending all together to the parent container
            formContainerEmail.append(informationEmailLabel);
            formContainerEmail.append(informationEmailInput);
            formContainerEmail.append(informationEmailErrorContainer);

            // Appending all together
            formBody.appendChild(formContainerLastName);
            formBody.appendChild(formContainerFirstName);
            formBody.appendChild(formContainerEmail);
            break;
        case 'photo':
            // Creating the container PhotoMain containing all content
            const photoMainContainer = document.createElement('div');
            photoMainContainer.className = 'photo-main-container';
            
            // Creating the input File
            const inputPhoto = document.createElement('input');
            inputPhoto.type = 'file';
            inputPhoto.accept = "image/*";
            inputPhoto.className = 'input-photo'
            inputPhoto.id = 'inputPhoto';
            inputPhoto.name = 'inputPhoto';

            // Creating the container Photo
            const photoContainer = document.createElement('div');
            photoContainer.className = 'photo-container';
            // Set default background image
            photoContainer.style.backgroundImage = `url('${clientInfoJSON['photo']}')`;
            // Listen for file selection
            inputPhoto.addEventListener('change', function () {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        // Set the selected image as the background
                        photoContainer.style.backgroundImage = `url('${e.target.result}')`;
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Creating the button 
            const btnChoicePhoto = document.createElement('button');
            btnChoicePhoto.className = 'btn-choice-photo';
            btnChoicePhoto.textContent = 'Nouvelle photo'
            btnChoicePhoto.onclick = choicePhoto;

            // Appending all together
            photoMainContainer.appendChild(inputPhoto);
            photoMainContainer.appendChild(photoContainer);
            photoMainContainer.appendChild(btnChoicePhoto);
            formBody.appendChild(photoMainContainer);
            break;
        case 'delete':
            formBody.style.cssText = "display:flex; font-size:22px; text-align:center;";
            const deleteAccountText = document.createElement('p');
            deleteAccountText.style.cssText = "display:block; width:100%; text-align:center;";
            deleteAccountText.innerHTML = `Êtes-vous sûr de vouloir supprimer votre compte personnel ?<br> Toutes les comptes et opérations seront également supprimées !<br> Cette action sera irreversible !`;
            formBody.append(deleteAccountText);
            break;
    }

    // Creating the form buttons block
    const formButtons = document.createElement('div');
    formButtons.className = 'form-buttons';
    // Creating the button Annuler
    const btnAnnuler = document.createElement('button');
    btnAnnuler.className = 'form-btn btn-annul';
    btnAnnuler.textContent = 'Annuler';
    btnAnnuler.onclick = (event) => hideModal(event);
    // Creating the button Valider
    const btnValider = document.createElement('button');
    btnValider.type = 'submit';
    btnValider.className = 'form-btn btn-submit';
    switch(action) {
        case 'information':
            btnValider.textContent = "Valider";
            btnValider.setAttribute('disabled', 'true');
            btnValider.classList.add('disabled');
            break;
        case 'password':
            btnValider.textContent = "Valider";
            btnValider.setAttribute('disabled', 'true');
            btnValider.classList.add('disabled');
            break;
        case 'photo':
            btnValider.textContent = "Valider";
            btnValider.setAttribute('disabled', 'true');
            btnValider.classList.add('disabled');
            break;
        case 'delete':
            btnValider.textContent = "Supprimer";
            btnValider.style.setProperty('background-color', '#ee3939');
            break;
    }
    // Appending all the buttons to the form buttons block
    formButtons.append(btnAnnuler);
    formButtons.append(btnValider);
    
    // Creating an empty block to store menu for the smallest screens
    const empty = document.createElement('div');
    empty.className = 'empty';

    form.appendChild(formTitle);
    form.appendChild(btnCloseModal);
    form.appendChild(formBody);
    form.appendChild(formButtons);
    form.appendChild(empty);
    modal.appendChild(form);
    overlay.appendChild(modal);

    checkEventListeners();
}

// Function to remove modal windows from DOM
function hideModal(event) {
    event.preventDefault();
    let modal;
    if(document.getElementById('modal_information')) {
        modal = document.getElementById('modal_information');
    } else if(document.getElementById('modal_password')) {
        modal = document.getElementById('modal_password');
    } else if(document.getElementById('modal_photo')) {
        modal = document.getElementById('modal_photo');
    } else if(document.getElementById('modal_delete')) {
        modal = document.getElementById('modal_delete');
    }
    modal.remove();
    const overlay = document.getElementById('overlay');
    overlay.classList.add('hidden');
}

function choicePhoto(event) {
    event.preventDefault();
    const inputFile = document.querySelector('.input-photo');
    inputFile.click();
}

// ==================================================== INFORMATION MODAL VALIDATION ==================================================

// Verify that the last name is at least 2 characters long (trim spaces) and contains at least 2 letters
function validateLastName() {
    const lastNameInput = document.querySelector('#lastName');
    let lastNameErrorContainer = document.querySelector('#lastNameErrorContainer');
    let lastName = lastNameInput.value;
    // Transform only the first letter to uppercase and keep the rest the same
    lastName = lastName.charAt(0).toUpperCase() + lastName.slice(1);
    const trimmedLastName = lastName.trim();
    // Regex to allow only letters and single spaces between words, and ensure at least 2 characters
    const isValid = trimmedLastName.length >= 2 && /^[a-zA-ZÀ-ÿ]+([ '.-]?[a-zA-ZÀ-ÿ]+)*$/.test(trimmedLastName);
    
    if (isValid) {
        lastNameInput.classList.remove('invalid');
        lastNameInput.classList.add('valid');
        lastNameErrorContainer.classList.add('hidden');
        lastNameErrorContainer.textContent = '';
    } else {
        lastNameInput.classList.remove('valid');
        lastNameInput.classList.add('invalid');
        lastNameErrorContainer.classList.remove('hidden');
        lastNameErrorContainer.textContent = 'Le nom doit contenir au moins 2 lettres, sans caractères spéciaux, chiffres ou plusieurs espaces';
    }
    // Update the input field with the modified name
    lastNameInput.value = lastName;

    enableSubmitButton();
}

// Verify that the last name is at least 2 characters long (trim spaces) and contains at least 2 letters
function validateFirstName() {
    const firstNameInput = document.querySelector('#firstName');
    let firstNameErrorContainer = document.querySelector('#firstNameErrorContainer');
    let firstName = firstNameInput.value;
    // Transform only the first letter to uppercase and keep the rest the same
    firstName = firstName.charAt(0).toUpperCase() + firstName.slice(1);
    const trimmedFirstName = firstName.trim();
    // Regex to allow only letters and single spaces between words, and ensure at least 2 characters
    const isValid = trimmedFirstName.length >= 2 && /^[a-zA-ZÀ-ÿ]+([ '.-]?[a-zA-ZÀ-ÿ]+)*$/.test(trimmedFirstName);
    
    if (isValid) {
        firstNameInput.classList.remove('invalid');
        firstNameInput.classList.add('valid');
        firstNameErrorContainer.classList.add('hidden');
        firstNameErrorContainer.textContent = '';
    } else {
        firstNameInput.classList.remove('valid');
        firstNameInput.classList.add('invalid');
        firstNameErrorContainer.classList.remove('hidden');
        firstNameErrorContainer.textContent = 'Le prénom doit contenir au moins 2 lettres, sans caractères spéciaux, chiffres ou plusieurs espaces';
    }
    // Update the input field with the modified name
    firstNameInput.value = firstName;

    enableSubmitButton();
}

// Validate email format and uniqueness
function validateEmail() {
    const emailInput = document.querySelector('#email');
    let emailErrorContainer = document.querySelector('#emailErrorContainer');
    const email = emailInput.value.trim();
    const emailRegex = /^[a-zA-Z0-9._%+-éèàçùâêîôûëïöüñ]+@[a-zA-Z0-9.-éèàçùâêîôûëïöüñ]+\.[a-zA-Z]{2,}$/;

    // Check if email is filled
    if (!email) {
        emailInput.classList.remove('valid');
        emailInput.classList.add('invalid');
        emailErrorContainer.classList.remove('hidden');
        emailErrorContainer.textContent = 'Le champ e-mail est requis.';
        enableSubmitButton();
        return;
    }

    // Validate email format
    const isValidFormat = emailRegex.test(email);
    if (!isValidFormat) {
        emailInput.classList.remove('valid');
        emailInput.classList.add('invalid');
        emailErrorContainer.classList.remove('hidden');
        emailErrorContainer.textContent = 'Format d\'adresse e-mail invalide.';
        enableSubmitButton();
        return;
    }

    // Check if email already exists in the clients array
    const emailExists = clientsEmailListJSON.includes(email);
    if (emailExists) {
        emailInput.classList.remove('valid');
        emailInput.classList.add('invalid');
        emailErrorContainer.classList.remove('hidden');
        emailErrorContainer.textContent = 'Cette adresse e-mail est déjà utilisée.';
        enableSubmitButton();
        return;
    }

    // If all checks pass
    emailInput.classList.remove('invalid');
    emailInput.classList.add('valid');
    emailErrorContainer.classList.add('hidden');
    emailErrorContainer.textContent = '';
    enableSubmitButton();
}

// ==================================================== PASSWORD MODAL VALIDATION ==================================================

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

function validateNewPassword() {
    const newPasswordInput = document.querySelector('#new-password');
    const password = newPasswordInput.value.trim();

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
        newPasswordInput.classList.remove('invalid');
        newPasswordInput.classList.add('valid');
    } else {
        newPasswordInput.classList.add('invalid');
        newPasswordInput.classList.remove('valid');
    }

    enableSubmitButton();
}

function validateConfirmationPassword() {
    const confirmationPasswordInput = document.querySelector('#confirmation-password');
    const confirmationPasswordValue = confirmationPasswordInput.value.trim();

    const newPasswordInput = document.querySelector('#new-password');
    const newPasswordValue = newPasswordInput.value.trim();
    
    let isValid = false;
    if (confirmationPasswordValue === newPasswordValue) {
        isValid = true;
    }
    if (isValid) {
        confirmationPasswordInput.classList.remove('invalid');
        confirmationPasswordInput.classList.add('valid');
    } else {
        confirmationPasswordInput.classList.add('invalid');
        confirmationPasswordInput.classList.remove('valid');
    }

    enableSubmitButton();
} 

// ==================================================== COMMON FUNCTIONS ==================================================
function enableSubmitButton() {
    const submitBtn = document.querySelector('.btn-submit');
    if(document.getElementById('modal_information')) {
        const lastNameInput = document.querySelector('#lastName');
        const firstNameInput = document.querySelector('#firstName');
        const emailInput = document.querySelector('#email');
        let isEqual = true;
        if (lastNameInput.value !== clientInfoJSON['lastName'] || firstNameInput.value !== clientInfoJSON['firstName'] || emailInput.value !== clientInfoJSON['email']) {
            isEqual = false;
        }
        let isEmpty = true;
        if (lastNameInput.value && firstNameInput.value  && emailInput.value) {
            isEmpty = false;
        }
        let isValid = false;
        if (lastNameInput.classList.contains('valid') && firstNameInput.classList.contains('valid') && emailInput.classList.contains('valid')){
            isValid = true;
        }
        if (!isEqual && !isEmpty && isValid) {
            submitBtn.removeAttribute('disabled');
            submitBtn.classList.remove('disabled');
        } else {
            submitBtn.setAttribute('disabled', 'true');
            submitBtn.classList.add('disabled');
        }
    } else if(document.getElementById('modal_password')) {
        const newPassword =  document.querySelector('#new-password');
        const confirmationPasword = document.querySelector('#confirmation-password');
        let isEmpty = true;
        if (newPassword.value  && confirmationPasword.value) {
            isEmpty = false;
        }
        let isValid = false;
        if (newPassword.classList.contains('valid') && confirmationPasword.classList.contains('valid')){
            isValid = true;
        }
        let isEqual = false;
        if (newPassword.value === confirmationPasword.value) {
            isEqual = true;
        }
        if (!isEmpty && isValid && isEqual) {
            submitBtn.removeAttribute('disabled');
            submitBtn.classList.remove('disabled');
        } else {
            submitBtn.setAttribute('disabled', 'true');
            submitBtn.classList.add('disabled');
        }
    } else if(document.getElementById('modal_photo')) {
        const photoInput = document.querySelector('#inputPhoto');
        if(photoInput.files[0]) {
            submitBtn.removeAttribute('disabled');
            submitBtn.classList.remove('disabled');
        }
    }
}

// Function that add event listenmers to the form inputs
function checkEventListeners() {
    const formInformation = document.querySelector('#form_information');
    const formPassword = document.querySelector('#form_password');
    const formPhoto = document.querySelector('#form_photo');
    if (formInformation) {
        document.querySelector('#lastName').addEventListener('input', validateLastName);
        document.querySelector('#firstName').addEventListener('input', validateFirstName);
        document.querySelector('#email').addEventListener('input', validateEmail);
    } else if (formPassword) {
        document.querySelector('#new-password').addEventListener('input', validateNewPassword);
        document.querySelector('#confirmation-password').addEventListener('input', validateConfirmationPassword);
    } else if (formPhoto) {
        document.querySelector('#inputPhoto').addEventListener('input', enableSubmitButton); // direct validation while file was uploaded
    }
}
