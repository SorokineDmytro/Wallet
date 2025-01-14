// Function to retrieve the formatted timestamp (the end of the day) for a given date
function getFormattedTimestamp(date) {
    // Get the current date
    const currentDate = new Date();
    currentDate.setHours(23, 59, 59, 999);
    // Subtract 1 day
    currentDate.setDate(currentDate.getDate() - date);
    // Format the new date as a timestamp
    const formattedTimestamp = `${currentDate.getFullYear()}-${String(currentDate.getMonth() + 1).padStart(2, '0')}-${String(currentDate.getDate()).padStart(2, '0')} ${String(currentDate.getHours()).padStart(2, '0')}:${String(currentDate.getMinutes()).padStart(2, '0')}:${String(currentDate.getSeconds()).padStart(2, '0')}`;
    return formattedTimestamp;
};
console.log(getFormattedTimestamp(0));

// Select the canvas element
const canvas = document.getElementById('curveDonutDepenses');
const ctx = canvas.getContext('2d');

// Generate categories names and colors to be used in chart's data
const depenseCategoriesNames = [];
const depenseCategoriesColors = [];
const depenseCategories = categories.filter((category) => category.type_id === 1);
depenseCategories.forEach(category => {
    depenseCategoriesNames.push(category.description);
    depenseCategoriesColors.push(category.color);
});
// Generate categories tootals and persentages to be used in chart's data
const depenses = operationsTotalByClient.filter((operation) => operation.type_id === 1);
console.log(depenses);
// Initialize the variable to store the total value of depenses
let total = 0;
// Calculate the total value
depenses.forEach(depense => {
    total += parseFloat(depense.montant);
    return total;
});
console.log(total);
// Initialize the variables to collect each category total 
let alimentation = 0;
let achat = 0;
let logement = 0;
let transport = 0;
let vehicule = 0;
let loisir = 0;
let multimedia = 0;
let fraisFinanciers = 0;
let placement = 0;
// Calculate the value of each categorie
depenses.forEach(depense => {
    switch (depense.categorie_id) {
        case 1:
            alimentation += parseFloat(depense.montant);
            break;
        case 2:
            achat += parseFloat(depense.montant);
            break;
        case 3:
            logement += parseFloat(depense.montant);
            break;
        case 4:
            transport += parseFloat(depense.montant);
            break;
        case 5:
            vehicule += parseFloat(depense.montant);
            break;
        case 6:
            loisir += parseFloat(depense.montant);
            break;
        case 7:
            multimedia += parseFloat(depense.montant);
            break;
        case 8:
            fraisFinanciers += parseFloat(depense.montant);
            break;
        case 9:
            placement += parseFloat(depense.montant);
            break;
    }
    return alimentation, achat, logement, transport, vehicule, loisir, multimedia, fraisFinanciers, placement;
});
const totalByCategory = [alimentation, achat, logement, transport, vehicule, loisir, multimedia, fraisFinanciers, placement];
console.log(totalByCategory);
// Calculate the total sum of the data
const totalSum = totalByCategory.reduce((sum, value) => sum + value, 0);
// Calculate each categorie percentage in total depenses
const percentages = [
    parseFloat((alimentation/total*100).toFixed(2)),
    parseFloat((achat/total*100).toFixed(2)),
    parseFloat((logement/total*100).toFixed(2)),
    parseFloat((transport/total*100).toFixed(2)),
    parseFloat((vehicule/total*100).toFixed(2)),
    parseFloat((loisir/total*100).toFixed(2)),
    parseFloat((multimedia/total*100).toFixed(2)),
    parseFloat((fraisFinanciers/total*100).toFixed(2)),
    parseFloat((placement/total*100).toFixed(2)),
];

// Dynamically adjust canvas size
function adjustCanvasSize() {
    const parentWidth = canvas.parentElement.offsetWidth;
    const parentHeight = canvas.parentElement.offsetHeight;

}

// Initialize the chart
let donutChart = new Chart(ctx, {
    plugins: [ChartDataLabels],
    type: 'doughnut',
    data: {
        labels: [...depenseCategoriesNames],
        datasets: [{
            data: [...totalByCategory], // Raw data
            backgroundColor: [...depenseCategoriesColors],
            hoverOffset: 10,
            borderRadius: 7.5,
            spacing: 1,
        }],
    },
    options: {
        responsive: true,
        maintainAspectRatio: false, // Allows full flexibility in resizing
        plugins: {
            legend: {
                display: false, // Custom legend managed separately
            },
            tooltip: {
                callbacks: {
                    label: (context) => {
                        const value = context.raw;
                        return ` ${value.toFixed(2)} € ou (${((value / totalSum) * 100).toFixed(2)} %)`;
                    },
                },
            },
            datalabels: {
                formatter: (value) => {
                    const percentage = ((value / totalSum) * 100).toFixed(1); // Calculate percentage
                    if (percentage < 5) return ''; // Hide labels for values < 5%
                    return `${percentage} %`; // Display percentage
                },
                color: '#fff',
            },
        },
    },
});

// Resize the canvas and chart dynamically
function resizeChart() {
    adjustCanvasSize();
    donutChart.resize();
}

// Observe the parent container for size changes
const resizeObserver = new ResizeObserver(resizeChart);
resizeObserver.observe(canvas.parentElement);

// Initial adjustment
resizeChart();

// Custom legend creation
const legendContainer = document.getElementById('custom-legend');
depenseCategoriesNames.forEach((name, index) => {
    // Create the container
    const legendItem = document.createElement('div');
    legendItem.className = 'legend-item';
    // Create color boxes
    const colorBox = document.createElement('span');
    colorBox.className = 'legend-item_box';
    colorBox.style.backgroundColor = depenseCategoriesColors[index];
    // Create labels
    const label = document.createElement('span');
    label.textContent = name;
    // Append all together
    legendItem.appendChild(colorBox);
    legendItem.appendChild(label);
    legendContainer.appendChild(legendItem);
});
