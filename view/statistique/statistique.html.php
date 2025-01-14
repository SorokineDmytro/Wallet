<div class="main-conatainer">
    <div class="charts">
        <div class="block diagram doughnut-chart">
            <h2 class="statistic-title">Répartition des dépenses</h2>
            <canvas id="curveDonutDepenses"></canvas>
            <div id="custom-legend"></div>
            <div class="statistic-button-container">
                <button class="statistic-btn">Mois</button>
                <button class="statistic-btn">Trimestre</button>
                <button class="statistic-btn">Demie-année</button>
                <button class="statistic-btn">Année</button>
                <button class="statistic-btn">Tout</button>
            </div>
            <div class="switchers"></div>
        </div>
        <div class="block diagram bar-chart">Block en preparation</div>
    </div>
    <div class="block diagram line-chart">Block en preparation</div>
</div>
<script>
    // Retrieve and parse the categories in JSON format passed from PHP
    const categories = JSON.parse('<?php echo $categoriesJSON; ?>');
    // Retrieve the operations total by client passed from PHP
    const operationsTotalByClient = JSON.parse('<?php echo $operationsTotalByClientJSON; ?>');

</script>