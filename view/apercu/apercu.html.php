<?php include("accountModal.html.php")?>
<?php include("operationModal.html.php")?>

<div class="main-conatainer">
    <div class="main-widgets">
        <div class="block widget">
            <h4 class="widget-title"><i class="fa-solid fa-coins"></i>Gains</h4>
            <div class="widget-middle">
                <span class="widget-main-amount">2 500.00 €</span>
                <div class="widget-circle red">
                    <span>-5.1%</span>
                </div>
            </div>
            <span class="widget-secondary-amount"><span class="color-green">-100.00 €</span> par rapport au dernier mois</span>
        </div>
        <div class="block widget">
            <h4 class="widget-title"><i class="fa-solid fa-cart-shopping"></i>Dépenses</h4>
            <div class="widget-middle">
                <span class="widget-main-amount">2 500.00 €</span>
                <div class="widget-circle red">
                    <span>-5.1%</span>
                </div>
            </div>
            <span class="widget-secondary-amount"><span class="color-green">-100.00 €</span> par rapport au dernier mois</span>
        </div>
        <div class="block widget">
            <h4 class="widget-title"><i class="fa-solid fa-piggy-bank"></i>Épargnes</h4>
            <div class="widget-middle">
                <span class="widget-main-amount">2 500.00 €</span>
                <div class="widget-circle green">
                    <span>+5.1%</span>
                </div>
            </div>
            <span class="widget-secondary-amount"><span class="color-red">-100.00 €</span> par rapport au dernier mois</span>
        </div>
        <div class="block widget">
            <h4 class="widget-title"><i class="fa-solid fa-money-bill-trend-up"></i>Investisements</h4>
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
                                    echo "<i class='fa-solid fa-wallet'></i>";
                                    break;
                                case 2 :
                                    echo "<i class='fa-solid fa-piggy-bank'></i>";
                                    break;
                                case 3 :
                                    echo "<i class='fa-solid fa-credit-card'></i>";
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
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </li>    
                        <li class="context-menu_list-item">
                                <button class="context-menu_circle" onclick="handleContextMenuClick(event, 'modify', <?=$account['id']?>)">
                                    <i class="fa-solid fa-pencil"></i>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            <?php endforeach;?>
            <button id="0" class="add-account" onclick="showAccountModal('create', 0)">
                <div class="blue"><i class="fa-solid fa-plus"></i></div>
                <span>Ajouter un compte</span>
            </button>
        </div>
    </div>
    <div class="main-operations">
        <div class="block operations">
            <div class="operations-title">
                <h2>Liste de transactions <?php isset($_GET['acc_Id'])?$account=$selectedAccount:$account=$selectedAccount?></h2> 

                <button class="operation-add blue" onclick="showOperationModal('create', 0, <?=$account?>)"><div class="white"><i class="fa-solid fa-plus"></i></div><span>Transaction</span></button>
            </div>
            <ul class="operation-list">
                <?php if($operationsByDate) :?>
                    <?php foreach($operationsByDate as $date => $operations):?>
                        <li class="operation-date">
                            <h3><?=date('d/m/Y', strtotime($date))?></h3>
                            <ul>
                                <?php foreach ($operations as $operation) :?>
                                <li class="operation-item">
                                    <div class="operation-item_circle"><i class="fa-solid fa-circle-question color-green"></i></div>
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
                                        <button class="btn-action btn-modify"><i class="fa-solid fa-pencil"></i>Modifier</button>
                                        <button class="btn-action btn-delete"><i class="fa-solid fa-trash"></i>Supprimer</button>
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
<form id="hiddenModalForm" action="index.php?page=apercu" method="POST" style="display: none;">
    <input type="hidden" name="acc_Id" id="hiddenAccId">
    <input type="hidden" name="opp_Id" id="hiddenOppId">
    <input type="hidden" name="action" id="hiddenAction">
    <input type="hidden" name="acc_For_Op" id="hiddenAccForOp">
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
        showAccountModal(action, accountId); // Call showAccountModal with the passed action ('delete' or 'modify')
    }

    // Function to show the acount modal
    function showAccountModal(action, accountId) {
    // Set values of the hidden form inputs
    document.getElementById('hiddenAccId').value = accountId;
    document.getElementById('hiddenOppId').remove();
    document.getElementById('hiddenAction').value = action;
    document.getElementById('hiddenModalForm').submit(); 
    }

    // Function to show the operation modal
    function showOperationModal(action, operationId, account) {
    // Set values of the hidden form inputs
    document.getElementById('hiddenOppId').value = operationId;
    document.getElementById('hiddenAccId').remove();
    document.getElementById('hiddenAction').value = action;
    document.getElementById('hiddenAccForOp').value = account; 
    document.getElementById('hiddenModalForm').submit(); 
    }
    
    // Function to hide the modal and re-enable scroll
    function hideModal(event) {
        event.preventDefault();
        document.location = "index.php?page=apercu";
    }
 
</script>