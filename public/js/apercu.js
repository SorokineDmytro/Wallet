// Function to retrieve the formatted timestamp (the end of the day) for a given date (today is 0, yestuday is -1, etc.)
function getFormattedTimestamp(date) {
    // Get the current date
    const currentDate = new Date();
    currentDate.setHours(23, 59, 59, 999);
    // Subtract 1 day
    currentDate.setDate(currentDate.getDate() - date);
    // Format the new date as a timestamp
    const formattedTimestamp = `${currentDate.getFullYear()}-${String(currentDate.getMonth() + 1).padStart(2, '0')}-${String(currentDate.getDate()).padStart(2, '0')} ${String(currentDate.getHours()).padStart(2, '0')}:${String(currentDate.getMinutes()).padStart(2, '0')}:${String(currentDate.getSeconds()).padStart(2, '0')}`;
    return formattedTimestamp;
};

//==========================================ACCOUNT'S RENDERRING========================================//
// Retrieve the information and caculate the account's balance by account number
function calculateAccountBalanceByAccountByDate(accountNumber, timestamp) {
    // Get the initial amount of the account
    let initialAmount = accountsJSON.find(account => account.id === accountNumber).amount;
    // Get the total revenues by account
    let revenus = 0;
    const totalRevenuesByAccount = operationsTotalByClient.filter(operation => operation.compte_id === accountNumber && operation.type_id === 2 && operation.timestamp <= timestamp);
    totalRevenuesByAccount.forEach(operation => {
        revenus += parseFloat(operation.montant);
    });
    // Get the total expenses by account
    let expenses = 0;
    const totalExpensesByAccount = operationsTotalByClient.filter(operation => operation.compte_id === accountNumber && operation.type_id === 1 && operation.timestamp <= timestamp);
    totalExpensesByAccount.forEach(operation => {
        expenses += parseFloat(operation.montant);
    }); 
    // Get the total transfers in by account
    let transfertsIn = 0;
    const totalTransfertsInByAccount = operationsTotalByClient.filter(operation => operation.compte_destinataire_id === accountNumber && operation.type_id === 3 && operation.timestamp <= timestamp);
    totalTransfertsInByAccount.forEach(operation => {
        transfertsIn += parseFloat(operation.montant);
    });
    // Get the total transfers out by account
    let transfertsOut = 0;
    const totalTransfertsOutByAccount = operationsTotalByClient.filter(operation => operation.compte_id === accountNumber && operation.type_id === 3 && operation.timestamp <= timestamp);
    totalTransfertsOutByAccount.forEach(operation => {
        transfertsOut += parseFloat(operation.montant);
    });
    // Calculate the account's balance
    return parseFloat(initialAmount) + revenus - expenses + transfertsIn - transfertsOut;
};

// Function to render the accounts
function renderAccounts(accounts, selectedAccountId) {
    const accountsContainer = document.querySelector('.block.accounts');
    accountsContainer.innerHTML = ''; // Clear any existing content
    // Iterate over accounts to create their HTML
    accounts.forEach(account => {
        const accountDiv = document.createElement('div');
        accountDiv.id = account.id;
        accountDiv.className = `account ${selectedAccountId === account.id ? 'selected' : ''}`;
        // Account image block
        const accountImg = document.createElement('div');
        accountImg.className = 'account-img';
        accountImg.style.backgroundColor = account.color;
        // Add icon based on type
        switch (account.type) {
            case 1:
                accountImg.innerHTML = "<i class='fa-solid fa-wallet'></i>";
                break;
            case 2:
                accountImg.innerHTML = "<i class='fa-solid fa-piggy-bank'></i>";
                break;
            case 3:
                accountImg.innerHTML = "<i class='fa-solid fa-credit-card'></i>";
                break;
        }
        // Append account image to account div
        accountDiv.appendChild(accountImg);
        // Actions button
        const actionsButton = document.createElement('button');
        actionsButton.className = 'actions';
        actionsButton.textContent = '...';
        actionsButton.onmouseenter = showAccountMenu;
        actionsButton.onclick = showAccountMenu;
        // Append actions button to account div
        accountDiv.appendChild(actionsButton);
        // Account title
        const accountTitle = document.createElement('h5');
        accountTitle.className = 'account-title';
        accountTitle.textContent = account.name;
        // Append account title to account div
        accountDiv.appendChild(accountTitle);
        // Account amount
        const accountAmount = document.createElement('span');
        accountAmount.className = 'account-amount';
        accountAmount.textContent = `${calculateAccountBalanceByAccountByDate(account.id, getFormattedTimestamp(0)).toLocaleString('fr-FR', { minimumFractionDigits: 2 })} €`;
        // Append account amount to account div
        accountDiv.appendChild(accountAmount);
        // Account menu
        const accountMenu = document.createElement('div');
        accountMenu.className = 'account-menu hidden';
        accountMenu.onmouseleave = hideAccountMenu;
        // Account menu list
        const accountMenuList = document.createElement('ul');
        accountMenuList.className = 'account-menu_list';
        // Delete button
        const deleteItem = document.createElement('li');
        deleteItem.className = 'context-menu_list-item';
        const deleteButton = document.createElement('button');
        deleteButton.className = 'context-menu_circle';
        deleteButton.onclick = event => handleContextMenuClick(event, 'delete', account.id);
        deleteButton.innerHTML = "<i class='fa-solid fa-trash-can'></i>";
        // Append delete button to delete item
        deleteItem.appendChild(deleteButton);
        accountMenuList.appendChild(deleteItem);
        // Modify button
        const modifyItem = document.createElement('li');
        modifyItem.className = 'context-menu_list-item';
        const modifyButton = document.createElement('button');
        modifyButton.className = 'context-menu_circle';
        modifyButton.onclick = event => handleContextMenuClick(event, 'modify', account.id);
        modifyButton.innerHTML = "<i class='fa-solid fa-pencil'></i>";
        // Append modify button to modify item
        modifyItem.appendChild(modifyButton);
        accountMenuList.appendChild(modifyItem);
        // Append account menu list to account menu
        accountMenu.appendChild(accountMenuList);
        accountDiv.appendChild(accountMenu);
        // Append account div to container
        accountsContainer.appendChild(accountDiv);
    });
    // Add "Add Account" button
    const addAccountButton = document.createElement('button');
    addAccountButton.id = '0';
    addAccountButton.className = 'add-account';
    addAccountButton.onclick = () => showAccountModal('create', 0);
    // Add icon to the button
    const addIconDiv = document.createElement('div');
    addIconDiv.className = 'blue';
    addIconDiv.innerHTML = "<i class='fa-solid fa-plus'></i>";
    // Add text to the button
    const addText = document.createElement('span');
    addText.textContent = 'Ajouter un compte';
    // Append icon and text to the button
    addAccountButton.appendChild(addIconDiv);
    addAccountButton.appendChild(addText);
    // Append the button to the container
    accountsContainer.appendChild(addAccountButton);
}
// Call the render function with the data
renderAccounts(accountsJSON, selectedAccount);

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

document.addEventListener('click', (event) => {
    if (!event.target.closest('.account')) {
        document.querySelectorAll('.account-menu').forEach(menu => menu.classList.add('hidden'));
    }
});

//==========================================ACCOUNT MODAL========================================//
// Function to show the account modal
function showAccountModal(action, accountId) {
    window.scrollTo({
        top: 0,
        behavior: 'smooth' // This makes the scrolling animation smooth
    });
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
        option3.disabled = true;
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
    window.scrollTo({
        top: 0,
        behavior: 'smooth' // This makes the scrolling animation smooth
    });
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
        // Adding a hidden input field to store an account id to be redirrercted to when the operation is deleted
        const inputAccountHiddenId = document.createElement('input');
        inputAccountHiddenId.type = 'number';
        inputAccountHiddenId.id = 'accHiddenId';
        inputAccountHiddenId.name = 'accHiddenId';
        inputAccountHiddenId.className = 'form-input d-none';
        inputAccountHiddenId.value = accountId;
        // Appending the hidden input to the form
        formOperation.append(inputAccountHiddenId);
        // Adding a style to the form body
        formOpBody.style.cssText = "display:flex; font-size:22px;";
        const deleteOperationText = document.createElement('p');
        deleteOperationText.innerHTML = `Êtes-vous sûr de vouloir supprimer cette opération ?<br> Cette action sera irreversible et affectera la statistique !`;
        formOpBody.append(deleteOperationText);
    } else {
    // Creating the container for each input field  
        // ---------------------------------------------TYPE fieldset creation--------------------------------
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

        // ---------------------------------------------DATE input creation--------------------------------
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

        // ---------------------------------------------AMOUNT input creation--------------------------------
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

        // ---------------------------------------------ACCOUNT input creation--------------------------------
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
        
        // ---------------------------------------------TRANSFERT ACCOUNT input creation--------------------------------
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
        optionOutside.value = 0;
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
            // Event liseners who prohibit the selection of the same account as the target of transfert in the both sides
            compteIdSelect.addEventListener('change', () => {
                const selectedAccount = compteIdSelect.value;
                // Iterate over options in the destination select
                Array.from(compteDestinataireSelect.options).forEach(option => {
                    // Disable if the value matches the selected account
                    option.disabled = option.value === selectedAccount;
                });
            });
            compteDestinataireSelect.addEventListener('change', () => {
                const selectedAccount = compteDestinataireSelect.value;
                // Iterate over options in the destination select
                Array.from(compteIdSelect.options).forEach(option => {
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

        // ---------------------------------------------CATEGORIE fieldset creation--------------------------------
        // Creating the fieldset OperationCategorie
        const formContainerOpCategory = document.createElement('fieldset');
        formContainerOpCategory.className = 'form-container op-cat';
        
        function createCategorieBlock(typeOperation) {
            // Clear the existing content of the fieldset
            formContainerOpCategory.innerHTML = '';
        
            // Creating the legend
            const opCategoryLegend = document.createElement('legend');
            opCategoryLegend.htmlFor = 'categorie_id';
            opCategoryLegend.className = 'op-cat-legend';
            opCategoryLegend.textContent = "Categorie :";
        
            // Creating div to store radio buttons in
            const divCategorieContainer = document.createElement('div');
            divCategorieContainer.className = 'op-cat-container';
        
            // Filter and append elements for each category
            const categoriesType = categories.filter(categorie => categorie.type_id === typeOperation);
            categoriesType.forEach((categorie, index) => {
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
        
                // Append elements to the div
                div.appendChild(input);
                div.appendChild(label);
                div.appendChild(span);
        
                // Append the div to the container
                divCategorieContainer.appendChild(div);
            });
        
            // Append the legend and container to the fieldset
            formContainerOpCategory.append(opCategoryLegend);
            formContainerOpCategory.append(divCategorieContainer);
        
            setupSousCategorySelectionLogic()
            return formContainerOpCategory;
        }
        
        // Initial rendering for default type (e.g., type 1)
        if(RadioBtnType1.checked = true) {
            createCategorieBlock(1);
        } else if (RadioBtnType2.checked = true) {
            createCategorieBlock(2);
        }
        
        // Add event listeners with callback functions
        RadioBtnType1.addEventListener('change', () => createCategorieBlock(1));
        RadioBtnType2.addEventListener('change', () => createCategorieBlock(2));

        // ---------------------------------------------SOUS-CATEGORIE fieldset creation--------------------------------
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

        // ---------------------------------------------CASE MODIFY LOGIC--------------------------------
        // Testing if operation action is modify to populate the input's values 
        if (action === 'modify' && operationId) {
            const operation = operationsJSON.find((op) => op.id === parseInt(operationId));
            if (operation) {
                // population of Type-operation input
                setTimeout(() => { // operation.type_id
                    const typeRadioButtons = document.getElementsByName('type_id');        
                    for (let i = 0; i < typeRadioButtons.length; i++) {
                        let item = typeRadioButtons[i];
                        if (parseInt(item.value) === parseInt(operation.type_id)) {
                            item.checked = true;
                            createCategorieBlock(operation.type_id);
                            item.click();
                        }
                    }
                }, 1); // 1s delay to get DOM rendered

                inputTimestamp.value = operation.timestamp;
                inputAmount.value = parseFloat(operation.montant).toFixed(2);
                    // operation.compte_id don't need to populate because it is already selected
                // population of select - transfert target account
                if(selectOpAcountTransfert && operation.compte_destinataire_id) {
                    selectOpAcountTransfert.value = operation.compte_destinataire_id;
                } else {
                    selectOpAcountTransfert.required = false;
                }
                // population of Type-categorie input
                setTimeout(() => { // operation.categorie_id
                    const categoryRadioButtons = document.getElementsByName('categorie_id');
                    for (let i = 0; i < categoryRadioButtons.length; i++) {
                        let item = categoryRadioButtons[i];
                        if (parseInt(item.value) === parseInt(operation.categorie_id)) {
                            item.checked = true;
                        }
                    }
                    setupSousCategorySelectionLogic();
                }, 1); // 1s delay to get DOM rendered
                // population of Type-sous-categorie input
                setTimeout(() => { // operation.souscategorie_id
                    const sousCategoryRadioButtons = document.getElementsByName('souscategorie_id');
                    for (let i = 0; i < sousCategoryRadioButtons.length; i++) {
                        let item = sousCategoryRadioButtons[i];
                        if (parseInt(item.value) === parseInt(operation.souscategorie_id)) {
                            item.checked = true;
                        }
                    }
                }, 1); // 1s delay to get DOM rendered
            }
        }

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
    btnValider.className = 'form-btn btn-submit disabled';
    btnValider.disabled = true;
    switch(action) {
        case 'create':
            btnValider.textContent = "Créer";
            break;
        case 'modify':
            btnValider.textContent = "Valider";
            break;
        case 'delete':
            btnValider.textContent = "Supprimer";
            btnValider.classList.remove('disabled');
            btnValider.disabled = false;
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
    validateAmountInput();
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

// Function that verifies that the input amount is filed in with numbers only and deblocks the submit button
function validateAmountInput() {
    let amountInput = document.querySelector('#montant');
    validateInput(amountInput);
    amountInput.addEventListener('input',() => validateInput(amountInput) )
}

function validateInput(input) {
    if (isNaN(input.value) || input.value.trim() === '') {
        input.value = '';
    } else if (input.value < 0) {
        input.value = 0;
    }
    validationCheck();
}

function validationCheck() {
    let amountInput = document.querySelector('#montant');
    let submitBtn = document.querySelector('.btn-submit');
    if(amountInput.value > 0) {
        submitBtn.disabled = false;
        submitBtn.classList.remove('disabled');
    } else {
        submitBtn.disabled = true;
        submitBtn.classList.add('disabled');
    }
}


//==========================================OPERATION'S LIST RENDERRING========================================//
// Creating the dynamic title of the operations list
const operationsTitle = document.querySelector('.operations-title');
const opTitle = document.createElement('h2');
let selectedAccountName = '';
if (accountsJSON.length > 0) {
    selectedAccountName = accountsJSON.find(account => account.id === selectedAccount).name;
    opTitle.innerHTML = `Liste de transactions sur le compte ${selectedAccountName}`;
    // Creating the button-add of the operations list
    const opButton = document.createElement('button');
    opButton.classList.add('operation-add', 'blue');
    opButton.innerHTML = `<div class="white"><i class="fa-solid fa-plus"></i></div><span>Transaction</span>`;
    opButton.addEventListener('click', () => showOperationModal('create', 0, selectedAccount));
    // Appending all together
    operationsTitle.appendChild(opTitle);
    operationsTitle.appendChild(opButton);

    // Function to render the operations list
    function renderOperations(operations) {    
        const operationList = document.querySelector('.operation-list');
        operationList.innerHTML = ''; // Clear existing content

        if (!operations || operations.length === 0) {
            operationList.innerHTML = '<span class="operation-message">Ce compte ne connaît aucune opération! Il est possible d\'ajouter une transaction.</span>';
            return;
        }

        // Group operations by date
        const operationsByDate = operations.reduce((acc, operation) => {
            const date = new Date(operation.timestamp).toLocaleDateString('fr-FR'); // Format date
            if (!acc[date]) {
                acc[date] = [];
            }
            acc[date].push(operation);
            return acc;
        }, {});

        // Reverse the order of days from recent to oldest
        Object.entries(operationsByDate)
        .sort(([dateA], [dateB]) => {
            // Parse the date strings back into Date objects for accurate sorting
            const parsedDateA = dateA.split('/').reverse().join('-'); // Convert "DD/MM/YYYY" to "YYYY-MM-DD"
            const parsedDateB = dateB.split('/').reverse().join('-');
            return new Date(parsedDateB) - new Date(parsedDateA); // Sort in descending order
        })
        .forEach(([date, operations]) => {
            // Sort operations by time within the day
            operations.sort((a, b) => new Date(b.timestamp) - new Date(a.timestamp)); // Sort the operations by date from newest to oldest
        
            // Create date block
            const dateBlock = document.createElement('li');
            dateBlock.className = 'operation-date';
        
            const dateHeader = document.createElement('h3');
            dateHeader.textContent = date;
            dateBlock.appendChild(dateHeader);
        
            // Create operations list for this date
            const operationSubList = document.createElement('ul');
        
            operations.forEach(operation => {
                const operationItem = document.createElement('li');
                operationItem.className = 'operation-item';
            
                // Logic to determine the amount color and math sign based on the operation type
                let amountClass = 'color-green'; // Default to green
                let amountSign = '+';
                if (operation.type_id === 1 || (operation.type_id === 3 && operation.compte_id === selectedAccount)) {
                    // Expense
                    amountClass = 'color-red';
                    amountSign = '-';
                } 
            
                //Logic to determine the categorie color based on categorie_id
                let categorieColor = '#6082B6'; // Default for transferts
                if (operation.categorie_id) {
                    categorieColor = categories.find(categorie => categorie.id === operation.categorie_id).color;
                }
            
                //Logic to determine the sousCategorie icon and descriptio based on souscategorie_id
                let sousCategorieIcon = 'arrow-right-arrow-left'; // Default for transferts
                let sousCategorieName = 'Transfert'; // Default for transferts
                if (operation.souscategorie_id) {
                    sousCategorieIcon = sousCategories.find(sousCategorie => sousCategorie.id === operation.souscategorie_id).icone;
                    sousCategorieName = sousCategories.find(sousCategorie => sousCategorie.id === operation.souscategorie_id).description;
                }
            
                //Logic to determine the compte name based on compte_id
                let compteName = 'Inconnu'; // Default for unknown
                compteName = accountsJSON.find(account => account.id === operation.compte_id).name;
            
                //Logic to determine the compte name based on compte_destinataire_id
                let compteDestinataireName = ''; // Default for unknown
                if (operation.compte_destinataire_id) {
                    compteDestinataireName = accountsJSON.find(account => account.id === operation.compte_destinataire_id).name;
                } else if (operation.type_id === 3) {
                    compteDestinataireName = 'En dehors de vos comptes';
                } 
            
                // Add operation details
                operationItem.innerHTML = `
                    <div class="operation-item_circle" style="background-color:${categorieColor};">
                        <i class="fa-solid fa-${sousCategorieIcon}"></i>
                    </div>
                    <div class="operation-item_type">${getOperationType(operation.type_id)}</div>
                    <span class="operation-item_categorie">${sousCategorieName}</span>
                    <span class="operation-item_account">${compteName}</span>
                    <span class="operation-item_dest-account">${compteDestinataireName}</span>
                    <span class="operation-item_time">${new Date(operation.timestamp).toLocaleTimeString('fr-FR', {hour: '2-digit', minute: '2-digit'})}</span>
                    <span class="operation-item_amount ${amountClass}">${amountSign}${parseFloat(operation.montant).toFixed(2)} €</span>
                    <div class="operation-buttons">
                        <button class="btn-action btn-modify" onclick="showOperationModal('modify', ${operation.id}, ${operation.compte_id});">
                            <i class="fa-solid fa-pencil"></i><span>Modifier</span>
                        </button>
                        <button class="btn-action btn-delete" onclick="showOperationModal('delete', ${operation.id}, ${operation.compte_id});">
                            <i class="fa-solid fa-trash"></i><span>Supprimer</span>
                        </button>
                    </div>
                `;
            
                operationSubList.appendChild(operationItem);
            });
        
            dateBlock.appendChild(operationSubList);
            operationList.appendChild(dateBlock);
        });
    }

    function getOperationType(typeId) {
        switch (typeId) {
            case 1:
                return 'Dépense';
            case 2:
                return 'Revenu';
            case 3:
                return 'Transfert';
            default:
                return 'Inconnu';
        }
    }

    // Call the function
    try {
        renderOperations(operationsJSON);
    } catch (error) {
        console.error('Error rendering operations:', error);
    }
} else {
    opTitle.innerHTML = `Liste de transactions`;
    operationsTitle.appendChild(opTitle);
    const operationList = document.querySelector('.operation-list');
    operationList.innerHTML = ''; // Clear existing content
    operationList.innerHTML = '<span class="operation-message">Il n\'y a auccun compte pour le moment. Veuillez créer un compte pour y ajouter une transaction.</span>';
}

//==========================================WIDGET'S RENDERRING========================================//
function renderWidgets(blockIndex, actualMonthNumber, lastMonthNumber) {
    const widgetBlock = document.querySelectorAll('.widget');
    switch (blockIndex) {
        case 0:
            title = 'Gains';
            logo = 'fa-coins';
            break;
        case 1:
            title = 'Dépenses';
            logo = 'fa-shopping-bag';
            break;
        case 2:
            title = 'Épargnes';
            logo = 'fa-piggy-bank';
            break;
        case 3:
            title = 'Investissements';
            logo = 'fa-money-bill-trend-up';
            break;
    }
    let numberSign = '+';
    let numberColor = 'green';
    let numberDifference = parseFloat(actualMonthNumber-lastMonthNumber);
    
    if(numberDifference < 0 && title !== 'Dépenses') {
        numberSign = '';
        numberColor = 'red';
    } else if (numberDifference > 0 && title == 'Dépenses') {
        numberSign = '+';
        numberColor = 'red';
    } else if(numberDifference < 0 && title == 'Dépenses') {
        numberSign = '';
    }
    numberDifference = parseFloat(numberDifference).toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

    let percentageSign = '+';
    let percentageColor = 'green';
    let percentageDifference = parseFloat((actualMonthNumber/lastMonthNumber)*100);
    if(actualMonthNumber <= 0 && lastMonthNumber == 0) {
        percentageDifference = '0';
        percentageColor = 'red';
    } else if (lastMonthNumber == 0) {
        percentageDifference = '100';
    } else if(actualMonthNumber == 0) {
        percentageDifference = '100';
        percentageSign = '-';
        percentageColor = 'red';
    } else {
        if (percentageDifference < 100 && title !== 'Dépenses') {
            percentageDifference = 100 - Math.abs(percentageDifference);
            percentageSign = '-';
            percentageColor = 'red';
        } else if (percentageDifference < 100 && title == 'Dépenses') {
            percentageDifference = 100 - Math.abs(percentageDifference);
            percentageSign = '-';
            percentageColor = 'green';
        } 
        if (percentageDifference > 100 && title !== 'Dépenses') {
            percentageDifference = percentageDifference - 100;
            percentageSign = '+';
            percentageColor = 'green';
        } else if (percentageDifference > 100 && title == 'Dépenses') {
            percentageDifference = percentageDifference - 100;
            percentageSign = '+';
            percentageColor = 'red';
        }
    }
    percentageDifference = parseFloat(percentageDifference).toLocaleString('fr-FR', { minimumFractionDigits: 1, maximumFractionDigits: 1 });
    
    // console.log(widgetBlock);
    widgetBlock[blockIndex].innerHTML = `
        <h4 class="widget-title"><i class="fa-solid ${logo}"></i>${title}</h4>
        <div class="widget-middle">
            <span class="widget-main-amount">${parseFloat(actualMonthNumber).toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })} €</span>
            <div class="widget-circle ${percentageColor}">
                <span>${percentageSign}${percentageDifference}%</span>
            </div>
        </div>
        <span class="widget-secondary-amount"><span class="color-${numberColor}">${numberSign}${numberDifference} €</span> par rapport au dernier mois</span>
    `
}
// Call the function
try {
    renderWidgets(0, totalActualMonthGains, totalLastMonthGains);
    renderWidgets(1, totalActualMonthDepenses, totalLastMonthDepenses);
    renderWidgets(2, totalActualMonthSavings, totalLastMonthSavings);
    renderWidgets(3, totalActualMonthInvestments, totalLastMonthInvestments);
} catch (error) {
    console.error('Error rendering widgets:', error);
}

//==========================================STATISTIC'S RENDERRING========================================//
// Retrieve the information and caculate the total balance by date
function calculateTotalBalance(date) {
    let totalBalance = 0;
    accountsJSON.forEach(account => {
        totalBalance += calculateAccountBalanceByAccountByDate(account.id, date);
    });
    return totalBalance;
};

// Select the canvas element
const canvas = document.getElementById('curveTotalByMonth')
const ctx = canvas.getContext('2d');
// Generate data
const dates = [];
for (let i = 0; i < 31; i++) {
    let dateFr = getFormattedTimestamp(i).slice(5, 10).split('-').reverse().join('/');
    dates.push(dateFr);
}
const data = [];
for (let i = 0; i < 31; i++) {
    data.push(calculateTotalBalance(getFormattedTimestamp(i)));
}

// Ensure the parent container sets the dimensions
const parentWidth = canvas.parentElement.offsetWidth;
const parentHeight = canvas.parentElement.offsetHeight;

// Create a chart
const myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: [...dates.reverse()], // Labels for the x-axis
        datasets: [{
            data: [...data.reverse()], // Data for the chart
            backgroundColor: '#16a18c',
            borderColor: '#16a18c',
            borderWidth: 3,
            tension: 0,
            pointRadius: 0,
            backgroundColor: '#66cba187',
            fill: true,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false, // Disable legend display
            }
        },
        scales: {
            x: {
                ticks: {
                    callback: function(value, index) {
                        return index % 3 === 0 ? this.getLabelForValue(value) : ''; // Show label every 5th index
                    },
                    font: {
                        weight: 'bold', // Font weight for x-axis labels
                    },
                },
            },
            y: {
                ticks: {
                    callback: function(value) {
                        return value ? `${ value / 1000 }K` : ''; // Show label / 1000 + K
                    },
                    font: {
                        weight: 'bold', // Font weight for x-axis labels
                    },
                },
            }
        }
    }
});

// A ResizeObserver ensures the chart updates whenever its container resizes.
const resizeObserver = new ResizeObserver(() => {
    myChart.resize();
});

resizeObserver.observe(canvas.parentElement);

// Populate the total amount of all accounts
const totalAmount = document.querySelector('.total-amount');
totalSum = 0;
accountsJSON.forEach(account => {
    totalSum += account.totalAmount;
    return totalSum;
});
totalAmount.innerHTML = `${calculateTotalBalance(getFormattedTimestamp(0)).toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })} €`;