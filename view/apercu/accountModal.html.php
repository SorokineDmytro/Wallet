<?php if ($showAccountModal): ?>
    <div class="overlay"></div>
    <div id="modal_account" class="modal-account">
        <form id="form_account" class="form-account" action="account&page=<?=$modalAction?>Account" method="post">
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