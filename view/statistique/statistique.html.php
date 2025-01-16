<div class="main-conatainer">
    <div class="charts">
        <!-- Doughnut expenses diagram  -->
        <div class="block diagram doughnut-chart">
            <h2 class="statistic-title">Répartition des dépenses</h2>
            <canvas id="curveDoughnutDepenses"></canvas>
            <div id="custom-legend">
                <!-- Category names and colors are populated here by JS script -->
            </div>
            <div class="statistic-button-container">
                <button class="statistic-btn doughnut-btn btn-active" id="doughnut-month">Mois</button>
                <button class="statistic-btn doughnut-btn" id="doughnut-quarter">Trimestre</button>
                <button class="statistic-btn doughnut-btn" id="doughnut-halfYear">Demi-année</button>
                <button class="statistic-btn doughnut-btn" id="doughnut-year">Année</button>
                <button class="statistic-btn doughnut-btn" id="doughnut-all">Tout</button>
            </div>
            <div class="switchers-container doughnut-switchers-container">
                <!-- Text is poulated here by JS script for a selected period -->
            </div>
            <span class="expenses-total"></span>
        </div>
        <!-- Bar expenses/revenus diagram  -->
        <div class="block diagram bar-chart">
            <h2 class="statistic-title">Flux de trésorerie</h2>
            <div class="bar-comparison">
            <span class="bar-comparison-text">
                <span class="bar-comparison-value"></span>
            </span>
            </div> 
            <canvas id="curveBarFlux"></canvas>
            <div class="statistic-button-container">
                <button class="statistic-btn bar-btn btn-active" id="bar-month">Mois</button>
                <button class="statistic-btn bar-btn" id="bar-quarter">Trimestre</button>
                <button class="statistic-btn bar-btn" id="bar-halfYear">Demi-année</button>
                <button class="statistic-btn bar-btn" id="bar-year">Année</button>
                <button class="statistic-btn bar-btn" id="bar-all">Tout</button>
            </div>
            <div class="switchers-container bar-switchers-container">
                <!-- Text is poulated here by JS script for a selected period -->
            </div>
        </div>
    </div>
    <!-- Bar actual balance diagram  -->
    <div class="block diagram line-chart">
        <h2 class="statistic-title">Tendance du solde</h2>
        <canvas id="curveLineTendance"></canvas>
    </div>
</div>
<script>
    // Retrieve and parse the categories in JSON format passed from PHP
    const categories = JSON.parse('<?php echo $categoriesJSON; ?>');
    // Retrieve the operations total by client passed from PHP
    const operationsTotalByClient = JSON.parse('<?php echo $operationsTotalByClientJSON; ?>');

</script>