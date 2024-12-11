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

                <button class="operation-add blue" onclick="showOperationModal('create', 0, <?= $selectedAccount ?>);"><div class="white"><i class="fa-solid fa-plus"></i></div><span>Transaction</span></button>
            </div>
            <ul class="operation-list">
                <?php if($operationsByDate) :?>
                    <?php foreach($operationsByDate as $date => $operations):?>
                        <li class="operation-date">
                            <h3><?=date('d/m/Y', strtotime($date))?></h3>
                            <ul>
                                <?php foreach ($operations as $operation) :?>
                                <li class="operation-item">
                                    <div class="operation-item_circle" style="background-color:<?=$operation['op_color']?>"><i class="fa-solid fa-<?=$operation['op_icon']?>"></i></div>
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
                                    <!-- <span class="operation-item_dest-account">
                                        <?= $operation['op_dest_account']?$operation['op_dest_account']:'' ?>
                                    </span> -->
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
                                        <button class="btn-action btn-modify" onclick="showOperationModal('modify', <?= $operation['op_id']?>, <?= $operation['op_accountId']?>);"><i class="fa-solid fa-pencil"></i>Modifier</button>
                                        <button class="btn-action btn-delete" onclick="showOperationModal('delete', <?= $operation['op_id']?>, <?= $operation['op_accountId']?>);"><i class="fa-solid fa-trash"></i>Supprimer</button>
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
<div id="overlay" class="overlay hidden"></div>
<script>
    // Retrieve and parse the accounts JSON passed from PHP
    const accountsJSON = JSON.parse('<?php echo $accountsJSON; ?>');
    // Retrieve and parse the categories from categoriesJSON passed from PHP
    const categories = JSON.parse('<?php echo $categoriesJSON; ?>');
    // Retrieve and parse the sousCategories JSON passed from PHP
    const sousCategories = JSON.parse('<?php echo $sousCategories; ?>');

    // Retrieve and parse the operations passed from PHP

</script>