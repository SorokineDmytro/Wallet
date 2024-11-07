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
                    <span class="account-amount"><?=number_format($account['totalAmount'], 2, '.', ' ')?> €</span>
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
                            <h3><?=date('d/m/Y', strtotime($date))?></h3>
                            <ul>
                                <?php foreach ($operations as $operation) :?>
                                <li class="operation-item">
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
                                        <span class="operation-item_amount color-red">-<?=number_format((float)$operation['op_amount'], 2, '.', ' ') ?> €</span>
                                    <?php elseif($operation['op_type'] == 2) :?>
                                        <span class="operation-item_amount color-green">+<?=number_format((float)$operation['op_amount'], 2, '.', ' ') ?> €</span>
                                    <?php else :?>
                                        <span class="operation-item_amount"><?= number_format((float)$operation['op_amount'], 2, '.', ' ') ?> €</span>
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

<?php if ($showModal): ?>
    <div class="overlay"></div>
    <div id="modal_account" class="modal-account">
        <form id="form_account" class="form-account" action="index.php?id=&page=<?=$modalAction?>Account" method="post">
                <h2 class="form-title">
                    <?php
                        if ($modalAction == 'create') echo "Création de compte";
                        elseif ($modalAction == 'modify') echo "Modification de compte";
                        elseif ($modalAction == 'delete') echo "Suppression de compte";
                    ?>
                </h2>
                <button class="modal-close" onclick="hideModal(event)"><i class="fas fa-xmark"></i></button>
                    <?php if ($modalAction == 'delete'): ?>
                        <div class="acc-id d-none">
                                    <label for="id" class="form-label required">ID de compte:</label>
                                    <input type="text" id="id" class="form-input" name="id" value="<?=$accountToModify['id']?>" >
                                </div>
                        <div class="form-body" style="display:flex; font-size:22px;">
                            <p>Êtes-vous sûr de vouloir supprimer ce compte ?<br> Cette action sera irreversible et affectera la statistique !<br> Toutes les opérations sur ce compte seront également supprimées !</p>
                        </div>
                    <?php endif; ?>
                    <?php if ($modalAction == 'create'): ?>
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
                    <?php endif; ?>
                    <?php if ($modalAction == 'modify'): ?>
                        <div class="form-body">
                                <div class="acc-id d-none">
                                    <label for="id" class="form-label required">ID de compte:</label>
                                    <input type="text" id="id" class="form-input" name="id" value="<?=$accountToModify['id']?>" >
                                </div>
                                <div class="form-container acc-type">
                                    <label for="typecompte_id" class="form-label required">Type de compte:</label>
                                    <select id="typecompte_id" class="form-select" name="typecompte_id" required >
                                        <option value="1" <?= ($accountToModify['type'] === 1) ? 'selected' : '' ?>>General</option>
                                        <option value="2" <?= ($accountToModify['type'] === 2) ? 'selected' : '' ?>>Epargne</option>
                                        <option value="3" <?= ($accountToModify['type'] === 3) ? 'selected' : '' ?>>Credit</option>
                                    </select>
                                </div>
                                <div class="form-container acc-name">
                                    <label for="numcompte" class="form-label required">Nom de compte:</label>
                                    <input type="text" id="numcompte" class="form-input" name="numcompte" value="<?=$accountToModify['name']?>" placeholder="Compte principal" required >
                                </div>
                                <div class="form-container acc-amount">
                                    <label for="montant_initial" class="form-label required">Montant initial:</label>
                                    <input type="number" min="0" step="0.01" value="<?= str_replace(' ', '', number_format($accountToModify['amount'], 2, '.', ''))?>" id="montant_initial" class="form-input" name="montant_initial" required >
                                </div>
                                <div class="form-container acc-color">
                                    <label for="color" class="form-label">Couleur de compte:</label>
                                    <input type="color" id="color" class="form-input" name="color" value="<?=$accountToModify['color']?>" placeholder="Selectionez un couleur" required >
                                </div>
                        </div>
                    <?php endif; ?>
                    <div class="form-buttons">
                        <button  class="form-btn btn-annul" onclick="hideModal(event)">Annuler</button>
                        <button type="submit" class="form-btn btn-submit">
                        <?php
                            if ($modalAction == 'create') echo "Créer un compte";
                            elseif ($modalAction == 'modify') echo "Valider";
                            elseif ($modalAction == 'delete') echo "Supprimer";
                        ?>
                        </button>
                    </div>
            </form>
    </div>
<?php endif; ?>
<form id="hiddenModalForm" action="index.php?page=apercu" method="POST" style="display: none;">
    <input type="hidden" name="acc_Id" id="hiddenAccId">
    <input type="hidden" name="action" id="hiddenAction">
</form>
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

    // Function to handle click on account menu (update & delete  buttons)
    function handleContextMenuClick(event, action, accountId) {
        event.preventDefault(); // Prevent default behavior
        event.stopPropagation(); // Stop the event from bubbling up
        showModal(action, accountId); // Call showModal with the passed action ('delete' or 'modify')
    }

    // Function to show the modal
    function showModal(action, accountId) {
    // Set values of the hidden form inputs
    document.getElementById('hiddenAccId').value = accountId;
    document.getElementById('hiddenAction').value = action;

    // Submit the form
    document.getElementById('hiddenModalForm').submit();
}
    
    // Function to hide the modal and re-enable scroll
    function hideModal(event) {
        event.preventDefault();
        document.location = "index.php?page=apercu";
    }
 
</script>