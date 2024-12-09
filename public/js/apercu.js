// Select all elements with the class 'account'
let accounts = document.querySelectorAll('.account');

// Add event listeners to each account element
accounts.forEach(account => {
    account.addEventListener('click', () => {
        document.location.href=`index.php?page=apercu&acc_Id=${account.id}`;
    });
});

// Function to show the account menu (update & delete  buttons)
function showAccountMenu(event) {
    event.preventDefault();
    event.stopPropagation();
    const account = event.target.closest('.account');
    const accountMenu = account.querySelector('.account-menu');
    accountMenu.classList.remove('hidden');
}

// Function to hide the account menu (update & delete  buttons)
function hideAccountMenu(event) {
    event.preventDefault();
    event.stopPropagation();
    const account = event.target.closest('.account');
    const accountMenu = account.querySelector('.account-menu');
    accountMenu.classList.add('hidden');
}

// Function to handle click on account menu (update & delete  buttons)
function handleContextMenuClick(event, action, accountId) {
    event.preventDefault(); // Prevent default behavior
    event.stopPropagation(); // Stop the event from bubbling up
    showAccountModal(action, accountId); // Call showAccountModal with the passed action ('delete' or 'modify')
}

// Function that calculates timestamp for now() and returns it into format YYYY-MM-DD HH:MM
function populateTimestampInput() {
        const now = new Date(); // Get the current local date and time
        // Format the date to YYYY-MM-DD
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0'); // Months are 0-based
        const day = String(now.getDate()).padStart(2, '0');
        // Format the time to HH:MM
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        // Combine into the format required for datetime-local
        const formattedDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;
        return formattedDateTime;
}

// Function to remove modal windows from DOM
function hideModal(event) {
    event.preventDefault();
    let modal;
    if(document.getElementById('modal_account')) {
        modal = document.getElementById('modal_account');
    } else if(document.getElementById('modal_operation')) {
        modal = document.getElementById('modal_operation');
    }
    modal.remove();
    const overlay = document.getElementById('overlay');
    overlay.classList.add('hidden');
}

//==========================================ACCOUNT MODAL========================================//
// Function to show the account modal
function showAccountModal(action, accountId) {
    // Getting overlay
    const overlay = document.getElementById('overlay'); 
    overlay.classList.remove('hidden');
    // Creating modal window into DOM
    const modalAccount = document.createElement('div');
    modalAccount.id='modal_account';
    modalAccount.className = 'modal-account';
    // Creating modal form
    const formAccount = document.createElement('form');
    formAccount.id = 'form_account';
    formAccount.className = 'form-account';
    formAccount.action = `account&page=${action}Account`;
    formAccount.method = 'POST';
    // Creating dynamic modal form title
    const formTitle = document.createElement('h2');
    formTitle.className = 'form-title';
    switch(action){
        case 'create':
            formTitle.textContent = 'Création de compte';
            break;
        case 'modify':
            formTitle.textContent = 'Modification de compte';
            break;
        case 'delete':
            formTitle.textContent = 'Suppression de compte';
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
    // Adding a hidden input field to store an account id
    const inputAccountHiddenId = document.createElement('input');
    inputAccountHiddenId.type = 'number';
    inputAccountHiddenId.id = 'id';
    inputAccountHiddenId.name = 'id';
    inputAccountHiddenId.className = 'form-input d-none';
    inputAccountHiddenId.value = accountId;
    // Creating the form content block
    const formBody = document.createElement('div');
    formBody.className = 'form-body';
    if(action == 'delete') {
        formBody.style.cssText = "display:flex; font-size:22px;";
        const deleteAccountText = document.createElement('p');
        deleteAccountText.innerHTML = `Êtes-vous sûr de vouloir supprimer ce compte ?<br> Cette action sera irreversible et affectera la statistique !<br> Toutes les opérations sur ce compte seront également supprimées !`;
        formBody.append(deleteAccountText);
    } else {
                                                    // Creating the container for each input field
            // Creating the container AccType
        const formContainerAccType = document.createElement('div');
        formContainerAccType.className = 'form-container acc-type';
        // Creating the label
        const accTypeLabel = document.createElement('label');
        accTypeLabel.htmlFor = 'typecompte_id';
        accTypeLabel.className = 'form-label required';
        accTypeLabel.textContent = 'Type de compte:';
        // Creating the select
        const accTypeSelect = document.createElement('select');
        accTypeSelect.id = 'typecompte_id';
        accTypeSelect.className = 'form-select';
        accTypeSelect.name = 'typecompte_id';
        accTypeSelect.required = true;
        // Inserting the select's options
        const option1 = document.createElement('option');
        option1.value = '1';
        option1.textContent = 'General';
        option1.selected = true;
        const option2 = document.createElement('option');
        option2.value = '2';
        option2.textContent = 'Epargne';
        const option3 = document.createElement('option');
        option3.value = '3';
        option3.textContent = 'Credit';
        // Appending the select's options into parent select
        accTypeSelect.append(option1);
        accTypeSelect.append(option2);
        accTypeSelect.append(option3);
        // Appending all together to the parent container
        formContainerAccType.append(accTypeLabel);
        formContainerAccType.append(accTypeSelect);

            // Creating the container AccName
        const formContainerAccName = document.createElement('div');
        formContainerAccName.className = 'form-container acc-name';
        // Creating the label
        const accNameLabel = document.createElement('label');
        accNameLabel.htmlFor = 'numcompte';
        accNameLabel.className = 'form-label required';
        accNameLabel.textContent = 'Nom de compte:';
        // Creating the input
        const accNameInput = document.createElement('input');
        accNameInput.type = 'text';
        accNameInput.id = 'numcompte';
        accNameInput.className = 'form-input';
        accNameInput.name = 'numcompte';
        accNameInput.value = '';
        accNameInput.placeholder = 'Compte principal';
        accNameInput.required = true;
        // Appending all together to the parent container
        formContainerAccName.append(accNameLabel);
        formContainerAccName.append(accNameInput);

            // Creating the container AccColor
        const formContainerAccColor = document.createElement('div');
        formContainerAccColor.className = 'form-container acc-color';
        // Creating the label
        const accColorLabel = document.createElement('label');
        accColorLabel.htmlFor = 'color';
        accColorLabel.className = 'form-label required';
        accColorLabel.textContent = 'Couleur de compte:';
        // Creating the input
        const accColorInput = document.createElement('input');
        accColorInput.type = 'color';
        accColorInput.id = 'color';
        accColorInput.className = 'form-input';
        accColorInput.name = 'color';
        accColorInput.value = '#16a18c';
        accColorInput.required = true;
        // Appending all together to the parent container
        formContainerAccColor.append(accColorLabel);
        formContainerAccColor.append(accColorInput);

            // Creating the container AccAmount
        const formContainerAccAmount = document.createElement('div');
        formContainerAccAmount.className = 'form-container acc-amount';
        // Creating the label
        const accAmountLabel = document.createElement('label');
        accAmountLabel.htmlFor = 'montant_initial';
        accAmountLabel.className = 'form-label required';
        accAmountLabel.textContent = 'Montant initial:';
        // Creating the input
        const accAmountInput = document.createElement('input');
        accAmountInput.type = 'number';
        accAmountInput.id = 'montant_initial';
        accAmountInput.className = 'form-input';
        accAmountInput.name = 'montant_initial';
        accAmountInput.value = '0.00';
        accAmountInput.min = '0';
        accAmountInput.step = '0.01';
        accAmountInput.required = true;
        // Appending all together to the parent container
        formContainerAccAmount.append(accAmountLabel);
        formContainerAccAmount.append(accAmountInput);

        // Testing if account action is modify to populate the input's values 
        if (action === 'modify' && accountId) {
            const account = accountsJSON.find((acc) => acc.id === parseInt(accountId));
            if (account) {
                accTypeSelect.value = account.type;
                accNameInput.value = account.name;
                accColorInput.value = account.color || '#16a18c';
                accAmountInput.value = parseFloat(account.amount).toFixed(2);
            }
        }
        // Appending all the field-sets to the formBody
        formBody.append(formContainerAccType);
        formBody.append(formContainerAccName);
        formBody.append(formContainerAccColor);
        formBody.append(formContainerAccAmount);
    }
    
    // Creating the form buttons block
    const formButtons = document.createElement('div');
    formButtons.className = 'form-buttons';
    // Creating the button Annuler
    const btnAnnuler =document.createElement('button');
    btnAnnuler.className = 'form-btn btn-annul';
    btnAnnuler.textContent = 'Annuler';
    btnAnnuler.onclick = (event) => hideModal(event);
    // Creating the button Valider
    const btnValider =document.createElement('button');
    btnValider.type = 'submit';
    btnValider.className = 'form-btn btn-submit';
    switch(action) {
        case 'create':
            btnValider.textContent = "Créer";
            break;
        case 'modify':
            btnValider.textContent = "Valider";
            break;
        case 'delete':
            btnValider.textContent = "Supprimer";
            break;
    }
    // Appending all the buttons to the form buttons block
    formButtons.append(btnAnnuler);
    formButtons.append(btnValider);

    // Appending all together
    formAccount.append(formTitle);
    formAccount.append(btnCloseModal);
    formAccount.append(inputAccountHiddenId);
    formAccount.append(formBody);
    formAccount.append(formButtons);
    modalAccount.append(formAccount);
    overlay.append(modalAccount);
}

//==========================================OPERATION MODAL========================================//
// Function to show the operation modal
function showOperationModal(action, operationId, accountId) {
    // Getting overlay
    const overlay = document.getElementById('overlay'); 
    overlay.classList.remove('hidden');
    // Creating modal window into DOM
    const modalOperation = document.createElement('div');
    modalOperation.id='modal_operation';
    modalOperation.className = 'modal-operation';
    // Creating modal form
    const formOperation = document.createElement('form');
    formOperation.id = 'form_operation';
    formOperation.className = 'form-operation';
    formOperation.action = `operation&page=${action}Operation`;
    formOperation.method = 'POST';
    // Creating dynamic modal form title
    const formTitle = document.createElement('h2');
    formTitle.className = 'form-title';
    switch(action){
        case 'create':
            formTitle.textContent = "Creation d'une opération";
            break;
        case 'modify':
            formTitle.textContent = "Modifiation de l'opération";
            break;
        case 'delete':
            formTitle.textContent = "Suppression de l'opération";
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
    // Adding a hidden input field to store an operation id
    const inputOperationHiddenId = document.createElement('input');
    inputOperationHiddenId.type = 'number';
    inputOperationHiddenId.id = 'id';
    inputOperationHiddenId.name = 'id';
    inputOperationHiddenId.className = 'form-input d-none';
    inputOperationHiddenId.value = operationId;
    // Creating the form content block
    const formOpBody = document.createElement('div');
    formOpBody.className = 'form-op-body';
    if(action == 'delete') {
        formOpBody.style.cssText = "display:flex; font-size:22px;";
        const deleteOperationText = document.createElement('p');
        deleteOperationText.innerHTML = `Êtes-vous sûr de vouloir supprimer cette opération ?<br> Cette action sera irreversible et affectera la statistique !`;
        formOpBody.append(deleteOperationText);
    } else {
    // Creating the container for each input field
        // Creating the fieldset OperationType
        const formContainerOpType = document.createElement('fieldset');
        formContainerOpType.className = 'form-container op-type';
        // Creating the legend
        const opTypeLegend = document.createElement('legend');
        opTypeLegend.htmlFor = 'type_id';
        opTypeLegend.className = 'op-type-legend';
        opTypeLegend.textContent = "Type de compte:";
        // Creating div to store radio buttons in
        const divContainer = document.createElement('div');
            // Creating the containers for each op-type radio button
        // Creating the first input radio container
        const divOpRadioContainer1 = document.createElement('div');
        divOpRadioContainer1.className = 'op-type-radio';
        // Creating input-1 in container
        const RadioBtnType1 = document.createElement('input');
        RadioBtnType1.type = 'radio';
        RadioBtnType1.id = 'type1';
        RadioBtnType1.name = 'type_id';
        RadioBtnType1.value = '1';
        RadioBtnType1.checked = true;
        // Creating label for this input
        const RadioLabelType1 = document.createElement('label');
        RadioLabelType1.htmlFor = 'type1';
        RadioLabelType1.textContent = 'Dépense';
        // Appending input and label to their parent container
        divOpRadioContainer1.append(RadioBtnType1);
        divOpRadioContainer1.append(RadioLabelType1);
        
        // Creating the second input radio container
        const divOpRadioContainer2 = document.createElement('div');
        divOpRadioContainer2.className = 'op-type-radio';
        // Creating input-2 in container
        const RadioBtnType2 = document.createElement('input');
        RadioBtnType2.type = 'radio';
        RadioBtnType2.id = 'type2';
        RadioBtnType2.name = 'type_id';
        RadioBtnType2.value = '2';
        // Creating label for this input
        const RadioLabelType2 = document.createElement('label');
        RadioLabelType2.htmlFor = 'type2';
        RadioLabelType2.textContent = 'Revenu';
        // Appending input and label to their parent container
        divOpRadioContainer2.append(RadioBtnType2);
        divOpRadioContainer2.append(RadioLabelType2);

        // Creating the third input radio container
        const divOpRadioContainer3 = document.createElement('div');
        divOpRadioContainer3.className = 'op-type-radio';
        // Creating input-3 in container
        const RadioBtnType3 = document.createElement('input');
        RadioBtnType3.type = 'radio';
        RadioBtnType3.id = 'type3';
        RadioBtnType3.name = 'type_id';
        RadioBtnType3.value = '3';
        // Creating label for this input
        const RadioLabelType3 = document.createElement('label');
        RadioLabelType3.htmlFor = 'type3';
        RadioLabelType3.textContent = 'Transfért';
        // Appending input and label to their parent container
        divOpRadioContainer3.append(RadioBtnType3);
        divOpRadioContainer3.append(RadioLabelType3);

        // Appending all together to the parent container
        formContainerOpType.append(opTypeLegend);
        divContainer.append(divOpRadioContainer1);
        divContainer.append(divOpRadioContainer2);
        divContainer.append(divOpRadioContainer3);
        formContainerOpType.append(divContainer);

        // Creating the container OperationDate
        const formContainerOpDate = document.createElement('div');
        formContainerOpDate.className = 'form-container op-date';
        // Creating label for timestamp 
        const labelTimestamp = document.createElement('label');
        labelTimestamp.htmlFor = 'timestamp';
        labelTimestamp.classList = 'form-label required';
        labelTimestamp.textContent = 'Date :';
        // Creating input type timestamp
        const inputTimestamp = document.createElement('input');
        inputTimestamp.type = 'datetime-local';
        const formattedDateTime = populateTimestampInput(); // Get current date and time and format it to 'YYYY-MM-DDTHH:MM'
        inputTimestamp.value = formattedDateTime;
        inputTimestamp.id = 'timestamp';
        inputTimestamp.name = 'timestamp';
        inputTimestamp.className = 'form-input';
        inputTimestamp.required = true;
        // Appending all together to the parent container
        formContainerOpDate.append(labelTimestamp);
        formContainerOpDate.append(inputTimestamp);

        // Creating the container OperationAmount
        const formContainerOpAmount = document.createElement('div');
        formContainerOpAmount.className = 'form-container op-amount';
        // Creating label for amount 
        const labelAmount = document.createElement('label');
        labelAmount.htmlFor = 'montant';
        labelAmount.classList = 'form-label required';
        labelAmount.textContent = 'Montant :';
        // Creating input type amount
        const inputAmount = document.createElement('input');
        inputAmount.type = 'number';
        inputAmount.id = 'montant';
        inputAmount.className = 'form-input';
        inputAmount.name = 'montant';
        inputAmount.value = '0.00';
        inputAmount.min = '0';
        inputAmount.step = '0.01';
        inputAmount.required = true;
        // Appending all together to the parent container
        formContainerOpAmount.append(labelAmount);
        formContainerOpAmount.append(inputAmount);

        // Creating the container OperationAccount
        const formContainerOpAccount = document.createElement('div');
        formContainerOpAccount.className = 'form-container op-acc';
        // Creating label for account 
        const labelOpAccount = document.createElement('label');
        labelOpAccount.htmlFor = 'compte_id';
        labelOpAccount.classList = 'form-label required';
        labelOpAccount.textContent = 'Depuis le compte :';
        // Creating the select for account
        const selectOpAcount = document.createElement('select');
        selectOpAcount.id = 'compte_id';
        selectOpAcount.className = 'form-select';
        selectOpAcount.name = 'compte_id';
        selectOpAcount.required = true;
        // Populate the select with its options gathered from the ApercuController using the customn function
        makeOptionsFromAccounts(accountsJSON, selectOpAcount, accountId);

        // Appending all together to the parent container
        formContainerOpAccount.append(labelOpAccount);
        formContainerOpAccount.append(selectOpAcount);
        
        // Creating the container OperationAccountTransfert
        const formContainerOpAccountTransfert = document.createElement('div');
        formContainerOpAccountTransfert.className = 'form-container op-accTr d-none';
        // Creating label for account 
        const labelOpAccountTransfert = document.createElement('label');
        labelOpAccountTransfert.htmlFor = 'compte_destinataire_id';
        labelOpAccountTransfert.classList = 'form-label required';
        labelOpAccountTransfert.textContent = 'Vers le compte :';
        // Creating the select for account
        const selectOpAcountTransfert = document.createElement('select');
        selectOpAcountTransfert.id = 'compte_destinataire_id';
        selectOpAcountTransfert.className = 'form-select';
        selectOpAcountTransfert.name = 'compte_destinataire_id';
        selectOpAcountTransfert.required = true;
        // Populate the select with its options gathered from the ApercuController using the customn function
        makeOptionsFromAccounts(accountsJSON, selectOpAcountTransfert, accountId);
        const optionOutside = document.createElement('option');
        optionOutside.value = '';
        optionOutside.textContent = 'En dehors de vos comptes';
        optionOutside.selected = true;
        selectOpAcountTransfert.append(optionOutside);
        // Appending all together to the parent container
        formContainerOpAccountTransfert.append(labelOpAccountTransfert);
        formContainerOpAccountTransfert.append(selectOpAcountTransfert);


        // Operations type Transfert selected logic
        function attachTypeTransfertEventListeners() {
            // Select the radio inputs and op-accTr container
            const typeTransfertRadio = document.getElementById('type3');
            const formContainerOpAccTr = document.querySelector('.op-accTr');
            const typeRadios = document.getElementsByName('type_id');
            const categoriesContainer = document.querySelector('.op-cat');
            const sousCategoriesContainer = document.querySelector('.op-s-cat');
            // Check if the radio button is available before proceeding
            if (!typeTransfertRadio) {
                return;
            }
            // Function to show or hide the op-accTr container
            function toggleOpAccTr() {
                if (typeTransfertRadio.checked) {
                    formContainerOpAccTr.classList.add('form-container');
                    formContainerOpAccTr.classList.remove('d-none');
                    categoriesContainer.classList.add('d-none');
                    sousCategoriesContainer.classList.add('d-none');
                } else {
                    formContainerOpAccTr.classList.remove('form-container');
                    formContainerOpAccTr.classList.add('d-none');
                    categoriesContainer.classList.remove('d-none');
                    sousCategoriesContainer.classList.remove('d-none');
                }
            }
            // Add event listeners to all radio buttons to check on change
            typeRadios.forEach(radio => {
                radio.addEventListener('change', toggleOpAccTr);
            });
            // Initial check on page load
            toggleOpAccTr();
        }
        // If the modal is being removed and added dynamically, re-trigger this function when the modal appears
        formOperation.addEventListener('click', () => {
            attachTypeTransfertEventListeners();
        });


        // Logic to prohibit the selection of the same account as the transfert target 
        function attachAccountTransferListeners() {
            const compteIdSelect = document.getElementById('compte_id');
            const compteDestinataireSelect = document.getElementById('compte_destinataire_id');
            if (!compteIdSelect || !compteDestinataireSelect) {
                return; // Exit if elements are not in the DOM
            }
            compteIdSelect.addEventListener('change', () => {
                const selectedAccount = compteIdSelect.value;
                // Iterate over options in the destination select
                Array.from(compteDestinataireSelect.options).forEach(option => {
                    // Disable if the value matches the selected account
                    option.disabled = option.value === selectedAccount;
                });
            });
            // Trigger change event on initialization to set the initial state
            compteIdSelect.dispatchEvent(new Event('change'));
        }
        // Attach the listener whenever the modal is created or shown
        formOperation.addEventListener('click', () => {
            attachAccountTransferListeners();
        });

        // Logic to prohibit the selection of the same account as the transfert target 
        function setupAccountSelectionLogic() {
            const compteIdSelect = document.getElementById('compte_id');
            const compteDestinataireSelect = document.getElementById('compte_destinataire_id');
            if (compteIdSelect && compteDestinataireSelect) {
                compteIdSelect.addEventListener('change', () => {
                    const selectedAccount = compteIdSelect.value;
                    // Iterate over options in the destination select
                    Array.from(compteDestinataireSelect.options).forEach(option => {
                        // Disable if the value matches the selected account
                        option.disabled = option.value === selectedAccount;
                    });
                });
                // Trigger change event to set the initial state
                compteIdSelect.dispatchEvent(new Event('change'));
            }
        }
        // Attach the logic whenever the modal is shown
        formOperation.addEventListener('click', () => {
            setupAccountSelectionLogic();
        });

        // ----------------Categories and sous-categoris selection-----------------
        function checkOperationType() {
            // Identifying type radio-buttons to provide logic for category selection
            const typeDepenseRadio = document.getElementById('type1');
            const typeRevenuRadio = document.getElementById('type2');
        }
console.log(categories);
        

        // Creating the fieldset OperationCategorie
        const formContainerOpCategory = document.createElement('fieldset');
        formContainerOpCategory.className = 'form-container op-cat';
        // Creating the legend
        const opCategoryLegend = document.createElement('legend');
        opCategoryLegend.htmlFor = 'categorie_id';
        opCategoryLegend.className = 'op-cat-legend';
        opCategoryLegend.textContent = "Categorie :";
        // Creating div to store radio buttons in
        const divCategorieContainer = document.createElement('div');
        divCategorieContainer.className = 'op-cat-container';


        // Create and append elements for each categorie
        categories.forEach((categorie, index) => {
            // Create a container div for the radio button and label
            const div = document.createElement('div');
            div.className = 'op-cat-radio';
            // Create the input (radio) element
            const input = document.createElement('input');
            input.type = 'radio';
            input.id = `cat${categorie.id}`;
            input.name = 'categorie_id';
            input.value = categorie.id;
            if (index === 0) {
                input.checked = true;
            }
            // Create the label element
            const label = document.createElement('label');
            label.htmlFor = `cat${categorie.id}`;
            label.style.backgroundColor = categorie.color; 
            // Create the icon (optional) within the label
            const icon = document.createElement('i');
            icon.className = `fa-solid fa-${categorie.icone}`;
            label.appendChild(icon);
            // Create the span element for the description
            const span = document.createElement('span');
            span.textContent = categorie.description;
            // Append the elements
            div.appendChild(input);
            div.appendChild(label);
            div.appendChild(span);
            // Append the div to the container
            divCategorieContainer.appendChild(div);
        });
        // Appending all together to the parent container
        formContainerOpCategory.append(opCategoryLegend);
        formContainerOpCategory.append(divCategorieContainer);

        //-------------------------------------------------SOUS-CATEGORIE
        // Creating the fieldset OperationCategorie
        const formContainerOpSousCategory = document.createElement('fieldset');
        formContainerOpSousCategory.className = 'form-container op-s-cat';
        // Creating the legend
        const opSousCategoryLegend = document.createElement('legend');
        opSousCategoryLegend.htmlFor = 'sous-categorie_id';
        opSousCategoryLegend.className = 'op-s-cat-legend';
        opSousCategoryLegend.textContent = "Sous-categorie :";
        // Creating div to store radio buttons in
        const divSousCategorieContainer = document.createElement('div');
        divSousCategorieContainer.className = 'op-s-cat-container';
        divSousCategorieContainer.id = 'opScatContainer';
        // Appending all together to the parent container
        formContainerOpSousCategory.append(opSousCategoryLegend);
        formContainerOpSousCategory.append(divSousCategorieContainer);

        // Add an eventListener to get a selected category ID and fetch corresponding sous-categories
        function setupSousCategorySelectionLogic() {
            const categorieRadios = document.querySelectorAll('input[name="categorie_id"]');
            const opScatContainer = document.getElementById('opScatContainer');
            if (!opScatContainer || !categorieRadios.length) {
                return;
            }
        
            // Function to get the checked radio's ID and filter corresponding sous-categories
            function getCheckedCategorieId() {
                const checkedRadio = document.querySelector('input[name="categorie_id"]:checked');
                if (checkedRadio) {
                    const selectedCategorieId = checkedRadio.value;
                    let selectedColor;
                    // Find the color for the selected category
                    categories.forEach(category => {
                        if (category.id == selectedCategorieId) {
                            selectedColor = category.color;
                        }
                    });

                    // Clear the sous-categories container before rendering new options
                    opScatContainer.innerHTML = ""; // To avoid population of sous-categories into the same block after switching their's parent categorie 

                    // Filter the sous-categories based on the selected category ID
                    const filteredSousCategories = sousCategories.filter(
                        sousCategorie => sousCategorie.categorie_id == selectedCategorieId
                    );
                    // Dynamically generate sous-category elements
                    filteredSousCategories.forEach((sousCategorie, index) => {
                        const div = document.createElement('div');
                        div.className = 'op-s-cat-radio';
                    
                        const input = document.createElement('input');
                        input.type = 'radio';
                        input.id = `s-cat${sousCategorie.id}`;
                        input.name = 'souscategorie_id';
                        input.value = sousCategorie.id;
                        if (index === 0) {
                            input.checked = true;
                        }
                    
                        const label = document.createElement('label');
                        label.htmlFor = `s-cat${sousCategorie.id}`;
                        label.style.backgroundColor = selectedColor;
                    
                        const icon = document.createElement('i');
                        icon.className = `fa-solid fa-${sousCategorie.icone}`;
                    
                        const span = document.createElement('span');
                        span.textContent = sousCategorie.description;
                    
                        // Append icon to the label
                        label.appendChild(icon);
                        // Append input, label and span  to the div
                        div.appendChild(input);
                        div.appendChild(label);
                        div.appendChild(span);
                        // Append the div to the container
                        opScatContainer.appendChild(div);
                    });
                }
            }
        
            // Remove any pre-existing event listeners before re-adding
            categorieRadios.forEach(radio => {
                radio.removeEventListener('change', getCheckedCategorieId);
                radio.addEventListener('change', getCheckedCategorieId);
            });
        
            // Trigger on initialization to set the initial state
            getCheckedCategorieId();
        }

        // Attach the logic whenever the modal is shown
        formOperation.addEventListener('dblclick', () => {  // A workaround to populate sousCategories field
            setupSousCategorySelectionLogic();
        });

        // Appending all the field-sets to the formBody
        formOpBody.append(formContainerOpType);
        formOpBody.append(formContainerOpDate);
        formOpBody.append(formContainerOpAmount);
        formOpBody.append(formContainerOpAccount);
        formOpBody.append(formContainerOpAccountTransfert);
        formOpBody.append(formContainerOpCategory);
        formOpBody.append(formContainerOpSousCategory);

    }

    // Creating the form buttons block
    const formButtons = document.createElement('div');
    formButtons.className = 'form-buttons';
    // Creating the button Annuler
    const btnAnnuler =document.createElement('button');
    btnAnnuler.className = 'form-btn btn-annul';
    btnAnnuler.textContent = 'Annuler';
    btnAnnuler.onclick = (event) => hideModal(event);
    // Creating the button Valider
    const btnValider =document.createElement('button');
    btnValider.type = 'submit';
    btnValider.className = 'form-btn btn-submit';
    switch(action) {
        case 'create':
            btnValider.textContent = "Créer";
            break;
        case 'modify':
            btnValider.textContent = "Valider";
            break;
        case 'delete':
            btnValider.textContent = "Supprimer";
            break;
    }
    // Appending all the buttons to the form buttons block
    formButtons.append(btnAnnuler);
    formButtons.append(btnValider);

    // Appending all together
    formOperation.append(formTitle);
    formOperation.append(btnCloseModal);
    formOperation.append(inputOperationHiddenId);
    formOperation.append(formOpBody);
    formOperation.append(formButtons);
    modalOperation.append(formOperation);
    overlay.append(modalOperation);
    formOperation.dispatchEvent(new MouseEvent("dblclick")); // A workaround to populate sousCategories field
}

// Function that takes a JSON of accounts and make options for a provided select to insert into a modal Operation as acccount for operation and account transfert
function makeOptionsFromAccounts(accountsJSON, selectName, accountId) {
    accountsJSON.forEach((account, index) => {
        // Create a container div for the radio button and label
        const option = document.createElement('option');
        option.value = account.id;
        if(option.value == accountId) {
            option.selected = true;
        }
        option.textContent = account.name;
        selectName.append(option);
})}