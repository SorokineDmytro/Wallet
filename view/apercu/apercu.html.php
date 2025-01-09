<div class="main-conatainer">
    <div class="main-widgets">
        <div class="block widget"></div>
        <div class="block widget"></div>
        <div class="block widget"></div>
        <div class="block widget"></div>
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
                <h2>Liste de transactions sur le compte <?= $selectedAccountName ?></h2> 
                <button class="operation-add blue" onclick="showOperationModal('create', 0, <?= $selectedAccount ?>);"><div class="white"><i class="fa-solid fa-plus"></i></div><span>Transaction</span></button>
            </div>
            <ul class="operation-list">
                
            </ul>
        </div>
    </div>
</div>
<div id="overlay" class="overlay hidden"></div>
<script>
    // Retrieve and parse the accounts in JSON format passed from PHP
    const accountsJSON = JSON.parse('<?php echo $accountsJSON; ?>');
    // Retrieve and parse the categories in JSON format passed from PHP
    const categories = JSON.parse('<?php echo $categoriesJSON; ?>');
    // Retrieve and parse the sousCategories in JSON format passed from PHP
    const sousCategories = JSON.parse('<?php echo $sousCategories; ?>');
    // Retrieve and parse the operations in JSON format passed from PHP
    const operationsJSON = JSON.parse('<?php echo $operationsJSON; ?>');
    // Retrieve the selected account ID passed from PHP
    const selectedAccount = +JSON.parse('<?php echo $selectedAccountJSON; ?>');
    // Retrieve the mothly gains passed from PHP
    const totalActualMonthGains = JSON.parse('<?php echo $totalActualMonthGainsJSON; ?>');
    const totalLastMonthGains = JSON.parse('<?php echo $totalLastMonthGainsJSON; ?>');
    // Retrieve the mothly expenses passed from PHP
    const totalActualMonthDepenses = JSON.parse('<?php echo $totalActualMonthDepensesJSON; ?>');
    const totalLastMonthDepenses = JSON.parse('<?php echo $totalLastMonthDepensesJSON; ?>');
    // Retrieve the mothly saivings passed from PHP
    const totalActualMonthSavings = JSON.parse('<?php echo $totalActualMonthSavingsJSON; ?>');
    const totalLastMonthSavings = JSON.parse('<?php echo $totalLastMonthSavingsJSON; ?>');
    // Retrieve the mothly investments passed from PHP
    const totalActualMonthInvestments = JSON.parse('<?php echo $totalActualMonthInvestmentsJSON; ?>');
    const totalLastMonthInvestments = JSON.parse('<?php echo $totalLastMonthInvestmentsJSON; ?>');
</script>