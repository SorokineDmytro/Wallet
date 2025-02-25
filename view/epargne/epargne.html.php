<div class="savings-container">
    <div class="block simulator-title">
        <p>Calculateur d'intérêt composé d'épargne</p>
    </div>
    <div class="block savings-balance">
        <p>Total de tous comptes d'épargne en ce moment : <span class="savings-total"></span></p>
    </div>
    <div class="block form">
        <form>
            <fieldset class="simple">
                <legend>Étape 1 : Montant initial <span class="info-btn"><i class="fas fa-question"></i><span class="info-text">Le montant initial d'argent que vous souhaitez investir</span></span></legend>
                <div class="line-input">
                    <label for="initialAmount" class="hidden">Montant initial</label>
                    <input type="number" name="initialAmount" id="initialAmount" class="full-width"min="0" max="100000000" step="1000" value="0">
                </div>
            </fieldset>
            <fieldset class="double">
                <legend>Étape 2 : Montant de contributions <span class="info-btn"><i class="fas fa-question"></i><span class="info-text">Le montant d'argent que vous souhaitez ajouter à chaque période de temps</span></span></legend>
                <div class="line-input">
                    <label for="contribution">Contributions (€) :</label>
                    <input type="number" name="contribution" id="contribution" min="0" max="100000000" step="100" value="0">
                </div>
                <div class="line-input">
                    <label for="contributionInterval">Périodicité :</label>
                    <select name="contributionInterval" id="contributionInterval">
                        <option value="month">Chaque mois</option>
                        <option value="quarter">Chaque trimestre</option>
                        <option value="halfYear">Chaque demi-année</option>
                        <option value="year">Chaque année</option>
                    </select>
                </div>
            </fieldset>
            <fieldset class="double">
                <legend>Étape 3 Calcul des intérêts <span class="info-btn"><i class="fas fa-question"></i><span class="info-text">Votre taux d'intérêt supposé et la période de son accumulation</span></span></legend>
                <div class="line-input">
                    <label for="interestRate">Taux d'intérêt (%) :</label>
                    <input type="number" name="interestRate" id="interestRate" min="0" max="100" step="0.25" value="0">
                </div>
                <div class="line-input">
                    <label for="interestInterval">Périodicité :</label>
                    <select name="interestInterval" id="interestInterval">
                        <option value="month">Chaque mois</option>
                        <option value="quarter">Chaque trimestre</option>
                        <option value="halfYear">Chaque demi-année</option>
                        <option value="year" selected>Chaque année</option>
                    </select>
                    </div>
            </fieldset>
            <fieldset class="simple">
                <legend>Étape 4 : Nombre d'années <span class="info-btn"><i class="fas fa-question"></i><span class="info-text">Temps en années pendant lequel vous prévoyez d'épargner de l'argent.</span></span></legend>
                <div class="line-input">
                    <label for="period" class="hidden">Nombre d'années</label>
                    <input type="number" name="period" id="period" class="full-width" min="0" max="1000" step="1" value="0">
                </div>
            </fieldset>
            <div class="btn-container">
                <button type="reset">Réinitialiser</button>
                <button type="submit" id="submitBtn" disabled="true" class="disabled" onclick="calculateCompoundInterest(event)">Calculer</button>
            </div>
        </form>
    </div>
    <div class="statistic">
        <div id="total"></div>
        <div id="totalContributions"></div>
        <div id="totalInterests"></div>

        <div id="chart">
            <canvas id="savingsChart"></canvas>
        </div>
    </div>
    <div id="table" class="table block"></div>
</div>

<script>
    // Retrieve and parse the accounts in JSON format passed from PHP
    const savingAccounts = JSON.parse('<?php echo $savingAccountsJSON; ?>');
    // Retrieve and parse the operations in JSON format passed from PHP
    const operationsTotalByClient = JSON.parse('<?php echo $operationsTotalByClientJSON; ?>');
</script>