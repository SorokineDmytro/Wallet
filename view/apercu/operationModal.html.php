<?php if ($showOperationModal): ?>
    <div class="overlay"></div>
    <div id="modal_operation" class="modal-operation">
        <form id="form_operation" class="form-operation" action="index.php?id=&page=<?=$modalAction?>Operation" method="post">
                <h2 class="form-title">
                    <?php
                        if ($modalAction == 'create') echo "Creation d'une opération";
                        elseif ($modalAction == 'modify') echo "Modifiation de l'opération";
                        elseif ($modalAction == 'delete') echo "Suppression de l'opération";
                    ?>
                </h2>
                <button class="modal-close" onclick="hideModal(event)"><i class="fas fa-xmark"></i></button>
                    <?php if ($modalAction == 'delete'): ?>
                        <div class="opp-id d-none">
                                    <label for="id" class="form-label required">ID d'opération:</label>
                                    <input type="text" id="id" class="form-input" name="id" value="<?=$operationToModify['id']?>" >
                                </div>
                        <div class="form-body" style="display:flex; font-size:22px;">
                            <p>Êtes-vous sûr de vouloir supprimer cette opération ?<br> Cette action sera irreversible et affectera la statistique !</p>
                        </div>
                    <?php endif; ?>
                    <?php if ($modalAction == 'create'): ?>
                        <div class="form-op-body">
                            <fieldset class="form-container op-type">
                                <legend for="type_id" class="form-label op-type-legend">Type d'opération:</legend>
                                <div>
                                <div class="op-type-radio">
                                    <input type="radio" id="type1" name="type_id" value="1" checked="true">
                                    <label for="type1">Dépense</label>
                                </div>
                                <div class="op-type-radio">
                                    <input type="radio" id="type2" name="type_id" value="2">
                                    <label for="type2">Revenu</label>
                                </div>
                                <div class="op-type-radio">
                                    <input type="radio" id="type3" name="type_id" value="3">
                                    <label for="type3">Transfért</label>
                                </div>
                                </div>
                            </fieldset>
                            <div class="form-container op-date">
                                <label for="timestamp" class="form-label required">Date :</label>
                                <input type="datetime-local" value="<?=date('Y-m-d H:i:s')?>" id="timestamp" class="form-input" name="timestamp" required >
                            </div>
                            <div class="form-container op-amount">
                                <label for="montant" class="form-label required">Montant :</label>
                                <input type="number" min="0" step="0.01" value="0.00" id="montant" class="form-input" name="montant" required >
                            </div>
                            <div class="form-container op-acc">
                                <label for="compte_id" class="form-label required">Depuis le compte :</label>
                                <select id="compte_id" class="form-select" name="compte_id" required >
                                    <?php foreach($accounts as $account): ?>
                                    <option value="<?=$account['id']?>" <?= ($account['id'] == $acountToCreateOperation) ? 'selected' : '' ?>><?=$account['name']?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-container op-accTr d-none">
                                <label for="compte_destinataire_id" class="form-label required">Vers le compte :</label>
                                <select id="compte_destinataire_id" class="form-select" name="compte_destinataire_id" required >
                                    <?php foreach($accounts as $account): ?>
                                        <option value="<?=$account['id']?>"><?=$account['name']?></option>
                                        <?php endforeach; ?>
                                        <option value="" selected>En dehors de vos comptes</option>;
                                    </select>
                            </div>
                            <fieldset class="form-container op-revenu-s-cat">
                                <legend for="type_id" class="form-label op-revenu-s-cat-legend">Sous-categorie :</legend>
                                <div class="op-revenu-s-cat-container">
                                    <?php foreach($scatRevenus as $scatRevenu): ?>
                                        <div class="op-revenu-s-cat-radio">
                                            <input type="radio" id="s-cat<?=$scatRevenu['id']?>" name="souscategorie_id" value="<?=$scatRevenu['id']?>">
                                            <label for="s-cat<?=$scatRevenu['id']?>"><i class="fas fa-<?=$scatRevenu['icone']?>"></i></label>
                                            <span><?=$scatRevenu['description']?></span>
                                        </div>
                                    <?php endforeach;?>
                                </div>
                            </fieldset>
                        </div>
                    <?php endif; ?>
                    <?php if ($modalAction == 'modify'): ?>
                        <div class="form-body">
                                <div class="operation-id d-none">
                                    <label for="id" class="form-label required">ID de compte:</label>
                                    <input type="text" id="id" class="form-input" name="id" value="<?=$operationToModify['id']?>" >
                                </div>
                                <div class="form-container acc-type">
                                    <label for="typecompte_id" class="form-label required">Type de compte:</label>
                                    <select id="typecompte_id" class="form-select" name="typecompte_id" required >
                                        <option value="1" <?= ($operationToModify['type'] === 1) ? 'selected' : '' ?>>General</option>
                                        <option value="2" <?= ($operationToModify['type'] === 2) ? 'selected' : '' ?>>Epargne</option>
                                        <option value="3" <?= ($operationToModify['type'] === 3) ? 'selected' : '' ?>>Credit</option>
                                    </select>
                                </div>
                                <div class="form-container acc-name">
                                    <label for="numcompte" class="form-label required">Nom de compte:</label>
                                    <input type="text" id="numcompte" class="form-input" name="numcompte" value="<?=$operationToModify['name']?>" placeholder="Compte principal" required >
                                </div>
                                <div class="form-container acc-amount">
                                    <label for="montant_initial" class="form-label required">Montant initial:</label>
                                    <input type="number" min="0" step="0.01" value="<?= str_replace(' ', '', number_format($operationToModify['amount'], 2, '.', ''))?>" id="montant_initial" class="form-input" name="montant_initial" required >
                                </div>
                                <div class="form-container acc-color">
                                    <label for="color" class="form-label">Couleur de compte:</label>
                                    <input type="color" id="color" class="form-input" name="color" value="<?=$operationToModify['color']?>" placeholder="Selectionez un couleur" required >
                                </div>
                        </div>
                    <?php endif; ?>
                    <div class="form-buttons">
                        <button  class="form-btn btn-annul" onclick="hideModal(event)">Annuler</button>
                        <button type="submit" class="form-btn btn-submit">
                        <?php
                            if ($modalAction == 'create') echo "Créer";
                            elseif ($modalAction == 'modify') echo "Valider";
                            elseif ($modalAction == 'delete') echo "Supprimer";
                        ?>
                        </button>
                    </div>
            </form>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
        // Select the radio inputs and op-accTr container
        const type3Radio = document.getElementById('type3');
        const formContainerOpAccTr = document.querySelector('.op-accTr');
        const typeRadios = document.getElementsByName('type_id');
        // Function to show or hide the op-accTr container
        function toggleOpAccTr() {
            if (type3Radio.checked) {
                formContainerOpAccTr.classList.add('form-container');
                formContainerOpAccTr.classList.remove('d-none');
            } else {
                formContainerOpAccTr.classList.remove('form-container');
                formContainerOpAccTr.classList.add('d-none');
            }
        }
        // Add event listeners to all radio buttons to check on change
        typeRadios.forEach(radio => {
            radio.addEventListener('change', toggleOpAccTr);
        });
        // Initial check on page load
        toggleOpAccTr();
        });

        document.addEventListener('DOMContentLoaded', () => {
        const compteIdSelect = document.getElementById('compte_id');
        const compteDestinataireSelect = document.getElementById('compte_destinataire_id');

        compteIdSelect.addEventListener('change', () => {
            const selectedAccount = compteIdSelect.value;
            // Iterate over options in the destination select
            Array.from(compteDestinataireSelect.options).forEach(option => {
                // Disable if the value matches the selected account
                if (option.value === selectedAccount) {
                    option.disabled = true;
                } else {
                    option.disabled = false; // Enable other options
                }
            });
        });
        // Trigger change event on page load to set the initial state
        compteIdSelect.dispatchEvent(new Event('change'));
        });
    </script>
<?php endif; ?>
