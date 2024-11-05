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
                <div id="<?=$account['id']?>" class="account">
                    <?php if($account['type'] == 1) :?>
                        <div class="account-img green"><i class="fas fa-credit-card"></i></div>
                        <?php else:?>
                        <div class="account-img blue"><i class="fas fa-piggy-bank"></i></div>
                    <?php endif ;?>
                    <button class="actions">...</button>
                    <h5 class="account-title"><?=$account['name']?></h5>
                    <span class="account-amount"><?=$account['amount']?></span>
                </div>
            <?php endforeach;?>
            <div class="account add-account">
                <div class="blue"><i class="fas fa-plus"></i></div>
                <span>Ajouter un compte</span>
            </div>
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
<script>
    // Select all elements with the class 'account'
    let accounts = document.querySelectorAll('.account');

    // Add event listeners to each account element
    accounts.forEach(account => {
        account.addEventListener('click', () => {
            document.location.href=`index.php?page=apercu&acc_Id=${account.id}`;
        });
    });
</script>