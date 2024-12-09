<?php if ($showOperationModal): ?>
    <div class="overlay"></div>
    <div id="modal_operation" class="modal-operation">
        <form id="form_operation" class="form-operation" action="operation&page=<?=$modalAction?>Operation" method="post">
                <h2 class="form-title">
                    <?php
                        if ($modalAction == 'create') echo "Creation d'une opération";
                        elseif ($modalAction == 'modify') echo "Modifiation de l'opération";
                        elseif ($modalAction == 'delete') echo "Suppression de l'opération";
                    ?>
                </h2>
                <button class="modal-close" onclick="hideModal(event)"><i class="fa-solid fa-xmark"></i></button>
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
                                <legend for="type_id" class="op-type-legend">Type d'opération:</legend>
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
                            <fieldset class="form-container op-cat">
                                <legend for="type_id" class="op-cat-legend">Categorie :</legend>
                                <div class="op-cat-container">
                                    <?php foreach($categories as $categorie): ?>
                                        <div class="op-cat-radio">
                                            <input type="radio" id="cat<?=$categorie['id']?>" name="categorie_id" value="<?=$categorie['id']?>" <?= ($categories[0]['id'] == $categorie['id']) ? "checked" : "" ?>>
                                            <label for="cat<?=$categorie['id']?>" style="background-color:<?=$categorie['color']?>"><i class="fa-solid fa-<?=$categorie['icone']?>"></i></label>
                                            <span><?=$categorie['description']?></span>
                                        </div>
                                    <?php endforeach;?>
                                </div>
                            </fieldset>
                            <fieldset class="form-container op-s-cat">
                                <legend for="type_id" class="op-s-cat-legend">Sous-categorie :</legend>
                                <div class="op-s-cat-container" id="opScatContainer">
                                    <!-- Sous-categorie is populated here by JS using JSON -->
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
        // Operations type Transfert selected logic
        document.addEventListener('DOMContentLoaded', () => {
        // Select the radio inputs and op-accTr container
        const typeTransfertRadio = document.getElementById('type3');
        const formContainerOpAccTr = document.querySelector('.op-accTr');
        const typeRadios = document.getElementsByName('type_id');
        const categoriesContainer = document.querySelector('.op-cat');
        const sousCategoriesContainer = document.querySelector('.op-s-cat');
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
        });


        // Logic to prohibit the selection of the same account as the transfert target 
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


        // ----------------Categories and sous-categoris selection-----------------

        // Add an eventListener to get a selected categorie ID for future fetch operations with it's sous-categorie
        document.addEventListener('DOMContentLoaded', () => {
        // Operations type Depense(1) and Revenu(2) selected logic
        const typeDepenseRadio = document.getElementById('type1');
        const typeRevenuRadio = document.getElementById('type2');

        // Retrieve and parse the categories from categoriesJSON passed from PHP
        const categories = JSON.parse('<?php echo $categoriesJSON; ?>');
        // Retrieve and parse the sousCategories JSON passed from PHP
        const sousCategories = JSON.parse('<?php echo $sousCategories; ?>');

        // Select all radio inputs for categorie_id
        const categorieRadios = document.querySelectorAll('input[name="categorie_id"]');

        // Function to get the checked radio's ID and filter corresponding sousCategories
        function getCheckedCategorieId() {
            const checkedRadio = document.querySelector('input[name="categorie_id"]:checked');
            if (checkedRadio) {
                const selectedCategorieId = checkedRadio.value;
                let selectedColor;
                categories.forEach(category => {
                    if (category.id == selectedCategorieId) {
                       selectedColor = category.color;
                    }
                })
                // Clear the sousCategories container before render
                opScatContainer.innerHTML = "";

                // Filter the sousCategories based on the selected category ID
                const filteredSousCategories = sousCategories.filter(sousCategorie => sousCategorie.categorie_id == selectedCategorieId);

                // Create and append elements for each filtered sousCategorie
                filteredSousCategories.forEach((sousCategorie, index) => {
                    // Create a container div for the radio button and label
                    const div = document.createElement('div');
                    div.className = 'op-s-cat-radio';

                    // Create the input (radio) element
                    const input = document.createElement('input');
                    input.type = 'radio';
                    input.id = `s-cat${sousCategorie.id}`;
                    input.name = 'souscategorie_id';
                    input.value = sousCategorie.id;
                    if (index === 0) {
                        input.checked = true;
                    }

                    // Create the label element
                    const label = document.createElement('label');
                    label.htmlFor = `s-cat${sousCategorie.id}`;
                    label.style.backgroundColor = selectedColor; 

                    // Create the icon (optional) within the label
                    const icon = document.createElement('i');
                    icon.className = `fa-solid fa-${sousCategorie.icone}`; // Assuming you have an icon class name
                    label.appendChild(icon);

                    // Create the span element for the description
                    const span = document.createElement('span');
                    span.textContent = sousCategorie.description;

                    // Append the elements
                    div.appendChild(input);
                    div.appendChild(label);
                    div.appendChild(span);

                    // Append the div to the container
                    opScatContainer.appendChild(div);
                });
            }
        }

        // Add change event listener to all radio buttons
        categorieRadios.forEach(radio => {
            radio.addEventListener('change', getCheckedCategorieId);
        });

        // Optionally trigger it on page load to capture any default checked state
        getCheckedCategorieId();
    });
    </script>
<?php endif; ?>
