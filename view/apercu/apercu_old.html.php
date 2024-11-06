<div class="main-conatainer">
    <div class="main-widgets">
        <div class="block widget">
            <h4 class="widget-title"><i class="fas fa-coins"></i>Gains</h4>
            <div class="widget-middle">
                <span class="widget-main-amount">2 500.00 €</span>
                <div class="widget-circle red">
                    <span>-5.1%</span>
                </div>
            </div>
            <span class="widget-secondary-amount"><span class="color-green">-100.00 €</span> par rapport au dernier mois</span>
        </div>
        <div class="block widget">
            <h4 class="widget-title"><i class="fas fa-cart-shopping"></i>Dépenses</h4>
            <div class="widget-middle">
                <span class="widget-main-amount">2 500.00 €</span>
                <div class="widget-circle red">
                    <span>-5.1%</span>
                </div>
            </div>
            <span class="widget-secondary-amount"><span class="color-green">-100.00 €</span> par rapport au dernier mois</span>
        </div>
        <div class="block widget">
            <h4 class="widget-title"><i class="fas fa-piggy-bank"></i>Épargnes</h4>
            <div class="widget-middle">
                <span class="widget-main-amount">2 500.00 €</span>
                <div class="widget-circle green">
                    <span>+5.1%</span>
                </div>
            </div>
            <span class="widget-secondary-amount"><span class="color-red">-100.00 €</span> par rapport au dernier mois</span>
        </div>
        <div class="block widget">
            <h4 class="widget-title"><i class="fas fa-money-bill-trend-up"></i>Investisements</h4>
            <div class="widget-middle">
                <span class="widget-main-amount">2 500.00 €</span>
                <div class="widget-circle green">
                    <span>+5.1%</span>
                </div>
            </div>
            <span class="widget-secondary-amount"><span class="color-red">-100.00 €</span> par rapport au dernier mois</span>
        </div>
    </div>
    <div class="main-statistic">
        <div class="block statistics">
        </div>
        <div class="block accounts">
            <?php foreach($accounts as $account) :?>
                <div id="<?=$account['id']?>" class="account <?= ($selectedAccount == $account['id']?'selected':'')?>">
                    <div class="account-img" style="background-color:<?=$account['color']?>">
                        <?php 
                            switch($account['type']) {
                                case 1 :
                                    echo "<i class='fas fa-wallet'></i>";
                                    break;
                                case 2 :
                                    echo "<i class='fas fa-piggy-bank'></i>";
                                    break;
                                case 3 :
                                    echo "<i class='fas fa-credit-card'></i>";
                                    break;
                            }
                        ?>
                    </div>
                    <button class="actions" onmouseenter="showAccountMenu(event)">...</button>
                    <h5 class="account-title"><?=$account['name']?></h5>
                    <span class="account-amount"><?=$account['amount']?></span>
                    <div class="account-menu hidden" onmouseleave="hideAccountMenu(event)">
                        <ul class="account-menu_list">
                        <li class="context-menu_list-item">
                                <button class="context-menu_circle" onclick="handleContextMenuClick(event, 'delete', <?=$account['id']?>)">
                                    <i class="fas fa-trash-can"></i>
                                </button>
                            </li>    
                        <li class="context-menu_list-item">
                                <button class="context-menu_circle" onclick="handleContextMenuClick(event, 'modify', <?=$account['id']?>)">
                                    <i class="fas fa-pencil"></i>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            <?php endforeach;?>
            <button id="0" class="add-account" onclick="showModal('create', 0)">
                <div class="blue"><i class="fas fa-plus"></i></div>
                <span>Ajouter un compte</span>
            </button>
        </div>
    </div>
    <div class="main-operations">
        <div class="block operations">
            <div class="operations-title">
                <h2>Liste de transactions</h2>
                <button class="operation-add blue"><div class="white"><i class="fas fa-plus"></i></div><span>Transaction</span></button>
            </div>
            <ul class="operation-list">
                <?php if($operationsByDate) :?>
                    <?php foreach($operationsByDate as $date => $operations):?>
                        <li class="operation-date">
                            <h3><?=date('d F Y', strtotime($date))?></h3>
                            <ul>
                                <?php foreach ($operations as $operation) :?>
                                <li class="operation-item">
                                    <input type="checkbox" name="choix" id="choix">
                                    <div class="operation-item_circle"><i class="fas fa-circle-question color-green"></i></div>
                                    <div class="operation-item_type">
                                        <?php 
                                            switch($operation['op_type']) {
                                                case 1:
                                                    echo 'Dépense';
                                                    break;
                                                case 2:
                                                    echo 'Revenu';
                                                    break;
                                                case 3:
                                                    echo 'Transfert';
                                                    break;
                                            } 
                                        ?>
                                    </div>
                                    <span class="operation-item_categorie">
                                        <?= htmlspecialchars($operation['op_souscategorie']) ?>
                                    </span>
                                    <span class="operation-item_account">
                                        <?= $operation['op_account'] ?>
                                    </span>
                                    <span class="operation-item_time">
                                        <?= $operation['op_time'] ?>
                                    </span>
                                    <?php if($operation['op_type'] == 1) :?>
                                        <span class="operation-item_amount color-red">-<?=$operation['op_amount']?></span>
                                    <?php elseif($operation['op_type'] == 2) :?>
                                        <span class="operation-item_amount color-green">+<?=$operation['op_amount']?></span>
                                    <?php else :?>
                                        <span class="operation-item_amount"><?=$operation['op_amount']?></span>
                                    <?php endif ;?>
                                    <div class="operation-buttons">
                                        <button class="btn-action btn-modify"><i class="fas fa-pencil"></i>Modifier</button>
                                        <button class="btn-action btn-delete"><i class="fas fa-trash"></i>Supprimer</button>
                                    </div>
                                </li>
                                <?php endforeach;?>
                            </ul>
                        </li>
                    <?php endforeach;?>
                <?php else :?>
                    <span class="opperaton-message">Ce compte ne connaît aucune opération! Il est possible d'ajouter une transaction.</span>
                <?php endif ;?>
            </ul>
        </div>
    </div>
</div>
<div id="modal_account" class="modal-account hidden">
    <form id="form_account" class="form-account" action="#" method="post">
        <h2 class="form-title"></h2>
        <button class="modal-close" onclick="hideModal()"><i class="fas fa-xmark"></i></button>
            <div class="form-body">
                <div class="form-container acc-type">
                    <label for="typecompte_id" class="form-label required">Type de compte:</label>
                    <select id="typecompte_id" class="form-select" name="typecompte_id" required >
                        <option value="1" selected>General</option>
                        <option value="2">Epargne</option>
                        <option value="3">Credit</option>
                    </select>
                </div>
                <div class="form-container acc-name">
                    <label for="numcompte" class="form-label required">Nom de compte:</label>
                    <input type="text" id="numcompte" class="form-input" name="numcompte" value="" placeholder="Compte principal" required >
                </div>
                <div class="form-container acc-color">
                    <label for="color" class="form-label">Couleur de compte:</label>
                    <input type="color" id="color" class="form-input" name="color" value="#16a18c" placeholder="Selectionez un couleur" required >
                </div>
                <div class="form-container acc-amount">
                    <label for="montant_initial" class="form-label required">Montant initial:</label>
                    <input type="number" min="0" step="0.01" value="0.00" id="montant_initial" class="form-input" name="montant_initial" value="" required >
                </div>
            </div>
            <div class="form-buttons">
                <button type="reset" class="form-btn btn-reset">Réinitialiser</button>
                <button type="submit" class="form-btn btn-submit"></button>
            </div>
    </form>
</div>
<script>
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

    // Funvtion to handle click on account menu (update & delete  buttons)
    function handleContextMenuClick(event, action, accountId) {
        event.preventDefault(); // Prevent default behavior
        event.stopPropagation(); // Stop the event from bubbling up
        showModal(action, accountId); // Call showModal with the passed action ('delete' or 'modify')
    }

    // Function to show the modal and disable scroll
    function showModal(action, accountId) {
    let modalTitle, modalValidationButton, modalAction;

    if (action === 'create') {
        // For create action
        modalTitle = "Création de compte";
        modalValidationButton = "Créer un compte";
        modalAction = "index.php?page=createAccount";
    } else if (action === 'modify') {
        // For modify action
        modalTitle = "Modification de compte";
        modalValidationButton = "Modifier le compte";
        modalAction = "index.php?page=modifyAccount";  // Update the URL for modify
    } else if (action === 'delete') {
        // For delete action
        modalTitle = "Suppression de compte";
        modalValidationButton = "Supprimer le compte";
        modalAction = "index.php?page=deleteAccount";  // Update the URL for delete
        const formBody = document.querySelector('.form-body');
        while (formBody.firstChild) {
            formBody.removeChild(formBody.firstChild);
        }
        formBody.style.display = "flex";
        let deleteMessage = document.createElement("p");
        deleteMessage.textContent = "Êtes-vous sûr de vouloir supprimer ce compte ? Cette action est irreversible. Toutes les opérations sur ce compte seront supprimées également.";
        formBody.append(deleteMessage);
    }
        console.log(accountId);
        // Change the modal title text
        document.querySelector('.form-title').textContent = modalTitle;
        // Change the modal validation button text
        document.querySelector('.btn-submit').textContent = modalValidationButton;
        // Change the form's action dynamically
        document.querySelector('#form_account').action = modalAction;
        // Show the modal
        const modal = document.querySelector('.modal-account');
        modal.style.visibility = 'visible'; 
        // Disable scrolling and add blur as bcg
        document.body.classList.add('no-scroll'); 
        const mainContainer = document.querySelector('.main-conatainer');
        mainContainer.classList.add('blurred');
    }
    
    // Function to hide the modal and re-enable scroll
    function hideModal() {
        const modal = document.querySelector('.modal-account');
        // Hide the modal and re-enable scrolling
        modal.style.visibility = 'hidden';
        document.body.classList.remove('no-scroll');
        const mainContainer = document.querySelector('.main-conatainer');
        mainContainer.classList.remove('blurred');
        // Reset the form to avoid hidden input validation errors
        document.getElementById('form_account').reset();
    }
 
</script>