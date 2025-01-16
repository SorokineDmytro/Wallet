//============================================ RETRIEVE AND MDIFY TIMESTAMP LOGIC ============================================
// Function to retrieve the formatted year and month for a given month (this month is 0, last month is -1, next month is +1, etc.)
function getMonth(offset) {
    // Get the current date
    const currentDate = new Date();
    // Adjust the month using the offset
    const adjustedDate = new Date(
        currentDate.getFullYear(),
        currentDate.getMonth() + offset
    );
    // Format the adjusted date as YYYY-MM
    const formattedTimestamp = `${adjustedDate.getFullYear()}-${String(adjustedDate.getMonth() + 1).padStart(2, '0')}`;
    const offsetStart = formattedTimestamp;
    const offsetEnd = formattedTimestamp;
    // Return both values in an array
    return [offsetStart, offsetEnd];
}

// Function to retrieve the formatted year and month for a given quarter (this quarter is 0, last quarter is -1, next quarter is +1, etc.)
function getQuarter(offset) {
    // Get the current date
    const currentDate = new Date();
    // Calculate the current quarter (0-based: 0 for Q1, 1 for Q2, etc.)
    const currentQuarter = Math.floor(currentDate.getMonth() / 3);
    // Calculate the adjusted quarter and year based on the offset
    const totalQuarters = currentQuarter + offset;
    const adjustedYear = currentDate.getFullYear() + Math.floor(totalQuarters / 4);
    const adjustedQuarter = ((totalQuarters % 4) + 4) % 4; // Ensure the quarter is within 0-3
    // Determine the start and end months of the adjusted quarter
    const startMonth = adjustedQuarter * 3; // 0-based month index
    const endMonth = startMonth + 2; // End of the quarter
    // Format the start and end dates as YYYY-MM
    const offsetStart = `${adjustedYear}-${String(startMonth + 1).padStart(2, '0')}`;
    const offsetEnd = `${adjustedYear}-${String(endMonth + 1).padStart(2, '0')}`;
    // Return both values in an array or object
    return [offsetStart, offsetEnd];
}

// Function to retrieve the formatted year and month for a given half-year (this half-year is 0, last half-year is -1, next half-year is +1, etc.)
function getHalfYear(offset) {
    // Get the current date
    const currentDate = new Date();
    // Calculate the current half-year (0 for H1, 1 for H2)
    const currentHalfYear = Math.floor(currentDate.getMonth() / 6);
    // Calculate the adjusted half-year and year based on the offset
    const totalHalfYears = currentHalfYear + offset;
    const adjustedYear = currentDate.getFullYear() + Math.floor(totalHalfYears / 2);
    const adjustedHalfYear = ((totalHalfYears % 2) + 2) % 2; // Ensure the half-year is within 0-1
    // Determine the start and end months of the adjusted half-year
    const startMonth = adjustedHalfYear * 6; // 0 for H1, 6 for H2
    const endMonth = startMonth + 5; // End of the half-year
    // Format the start and end dates as YYYY-MM
    const offsetStart = `${adjustedYear}-${String(startMonth + 1).padStart(2, '0')}`;
    const offsetEnd = `${adjustedYear}-${String(endMonth + 1).padStart(2, '0')}`;
    // Return both values in an array or object
    return [offsetStart, offsetEnd];
}

// Function to retrieve the formatted year and month for a given month (this year is 0, last year is -1, next year is +1, etc.)
function getYear(offset) {
    // Get the current date
    const currentDate = new Date();
    // Adjust the month using the offset
    const adjustedDate = new Date(
        currentDate.getFullYear() + offset,
        currentDate.getMonth(),
    );
    // Determine the start and end months of the adjusted half-year
    const startMonth = 0; // 0 for H1, 6 for H2
    const endMonth = startMonth + 11; // End of the half-year
    // Format the start and end dates as YYYY-MM
    const offsetStart = `${adjustedDate.getFullYear()}-${String(startMonth + 1).padStart(2, '0')}`;
    const offsetEnd = `${adjustedDate.getFullYear()}-${String(endMonth + 1).padStart(2, '0')}`;
    // Return both values in an array
    return [offsetStart, offsetEnd];
}

function getAll() {
    const offsetStart = '0001-01';
    const offsetEnd = '9999-12';
    // Return both values in an array
    return [offsetStart, offsetEnd];
}

// Function to thransform year and month to french format ('2025-01' => 'Janvier 2025')
function transformMonthAndYearToFormatFr(dateString) {
    const year = dateString.slice(0, 4);
    const month = dateString.slice(5, 7);
    const frenchMonth = [
        'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'
    ];
    const formattedMonth = frenchMonth[parseInt(month, 10) - 1];
    return `${formattedMonth} ${year}`;
}

//============================================ COMMON FUNCTIONS ============================================
// Function to create switch buttons prev and next and populate the text-field (takes params: name of the canvas to create classes in html, container to populate data in, canva's index, offset of period)
function createSwitchers(canvasName, functionName, container, index, period) {
    container.innerHTML = '';
    // Create a button previous period
    const prevBtn = document.createElement('button');
    prevBtn.classList = (`offset-btn ${canvasName}-btn-previous`);
    prevBtn.textContent = '<';
    // Create a text field 
    const textField = document.createElement('span');
    textField.classList = (`offset-text ${canvasName}-text`);
    textField.textContent = `du ${transformMonthAndYearToFormatFr(getMonth(0)[0])} - au ${transformMonthAndYearToFormatFr(getMonth(0)[1])}`;
    // Create a button next period
    const nextBtn = document.createElement('button');
    nextBtn.classList = (`offset-btn ${canvasName}-btn-next`);
    nextBtn.textContent = '>';
    // Appending all together
    container.appendChild(prevBtn);
    container.appendChild(textField);
    container.appendChild(nextBtn);
    // Initial eventListeners for prev and next buttons 
    prevBtn.addEventListener('click', () => {
        index -= 1;
        if(canvasName == 'doughnut') {
            document.getElementById('custom-legend').innerHTML = '';
        }
        functionName(period(index)[0], period(index)[1]);
        textField.innerHTML = '';
        textField.innerHTML = `du ${transformMonthAndYearToFormatFr(period(index)[0])} - au ${transformMonthAndYearToFormatFr(period(index)[1])}`;
        return index;
    });
    nextBtn.addEventListener('click', () => {
        index += 1;
        if(canvasName == 'doughnut') {
            document.getElementById('custom-legend').innerHTML = '';
        }
        functionName(period(index)[0], period(index)[1]);
        textField.innerHTML = '';
        textField.innerHTML = `du ${transformMonthAndYearToFormatFr(period(index)[0])} - au ${transformMonthAndYearToFormatFr(period(index)[1])}`;
        return index;
    });
}

//====================================================== EXPENSES CANVA'S (DOUGHNUT) LOGIC =========================================================
// Getting html elements from the page
let doughnutIndex = 0; // Index of a period (0 equals to now)

const statDoughnutButtons = document.querySelectorAll('.doughnut-btn'); // Buttons to change the periods
const doughnutSwitchers = document.querySelector('.doughnut-switchers-container'); // Container of offset butttons and text to modify

// Variable to hold the chart instance
let doughnutChart = null;

// Initial function call to generate switcher's content 
createSwitchers('doughnut', drawExpensesCanvas, doughnutSwitchers, doughnutIndex, getMonth);

// Select the canvas element
const canvasDoughnut = document.getElementById('curveDoughnutDepenses');
const ctxDoughnut = canvasDoughnut.getContext('2d');

function drawExpensesCanvas(offsetStart, offsetEnd) {
    // Destroy the existing chart if it exists
    if (doughnutChart) {
        doughnutChart.destroy();
    }

    // Generate categories totals and percentages to be used in chart's data
    const expenses = operationsTotalByClient.filter(
        (operation) => operation.type_id === 1 && 
        operation.timestamp.slice(0, 7) >= offsetStart && 
        operation.timestamp.slice(0, 7) <= offsetEnd
    );

    // Filtered and sorted list of possible category_id to be used as a reference 
    let collectorExpenseArray = [];
    let categoriesIdByExpenses = [];
    expenses.forEach((expense) => {
        collectorExpenseArray.push(expense.categorie_id);
        categoriesIdByExpenses = [...new Set(collectorExpenseArray)].sort((a,b) => a - b);
        return categoriesIdByExpenses;
    });

    // Generate categories names and colors using a referenced array of eexpense's id to be used in chart's data
    const expenseCategoriesNames = [];
    const expenseCategoriesColors = [];
    const expenseCategories = categories.filter((category) => categoriesIdByExpenses.includes(category.id));
    expenseCategories.forEach(category => {
        expenseCategoriesNames.push(category.description);
        expenseCategoriesColors.push(category.color);
    });

    // Initialize the variable to store the total value of expenses
    let total = 0;
    // Calculate the total value
    expenses.forEach(expense => {
        total += parseFloat(expense.montant);
        return total;
    });

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
    expenses.forEach(expense => {
        switch (expense.categorie_id) {
            case 1:
                alimentation += parseFloat(expense.montant);
                break;
            case 2:
                achat += parseFloat(expense.montant);
                break;
            case 3:
                logement += parseFloat(expense.montant);
                break;
            case 4:
                transport += parseFloat(expense.montant);
                break;
            case 5:
                vehicule += parseFloat(expense.montant);
                break;
            case 6:
                loisir += parseFloat(expense.montant);
                break;
            case 7:
                multimedia += parseFloat(expense.montant);
                break;
            case 8:
                fraisFinanciers += parseFloat(expense.montant);
                break;
            case 9:
                placement += parseFloat(expense.montant);
                break;
        }
        return alimentation, achat, logement, transport, vehicule, loisir, multimedia, fraisFinanciers, placement;
    });
    const totalByCategory = [alimentation, achat, logement, transport, vehicule, loisir, multimedia, fraisFinanciers, placement].filter((item) => item > 0);

    // Calculate the total sum of the data
    const totalSum = totalByCategory.reduce((sum, value) => sum + value, 0);

    // Initialize the chart
    doughnutChart = new Chart(ctxDoughnut, {
        plugins: [ChartDataLabels],
        type: 'doughnut',
        data: {
            labels: [...expenseCategoriesNames],
            datasets: [{
                data: [...totalByCategory],
                backgroundColor: [...expenseCategoriesColors],
                hoverOffset: 10,
                borderRadius: 7.5,
                spacing: 1,
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, // Allows full flexibility in resizing
            layout: {
                padding: 5,
            },
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
    
    // Custom legend creation
    const legendContainer = document.getElementById('custom-legend');
    expenseCategoriesNames.forEach((name, index) => {
        // Create the container
        const legendItem = document.createElement('div');
        legendItem.className = 'legend-item';
        // Create color boxes
        const colorBox = document.createElement('span');
        colorBox.className = 'legend-item_box';
        colorBox.style.backgroundColor = expenseCategoriesColors[index];
        // Create labels
        const label = document.createElement('span');
        label.textContent = name;
        // Append all together
        legendItem.appendChild(colorBox);
        legendItem.appendChild(label);
        legendContainer.appendChild(legendItem);
    });

    // Show total expense ammount on the page
    const totalContainer = document.querySelector('.expenses-total');
    if(total === 0) {
        totalContainer.classList.add('statErrorMessage');
        totalContainer.innerHTML = "Oops… Il n'y a aucune opération dans la période sélectionnée";
    } else {
        totalContainer.classList.remove('statErrorMessage');
        totalContainer.innerHTML = `${total.toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })} €`; 
    }
}
drawExpensesCanvas(getMonth(doughnutIndex)[0], getMonth(doughnutIndex)[1]);

// Logic for each offset button
const statDoughnutBtnMonth = document.getElementById('doughnut-month');
statDoughnutBtnMonth.addEventListener('click', () => {
    doughnutIndex = 0;
    document.getElementById('custom-legend').innerHTML = '';
    createSwitchers('doughnut', drawExpensesCanvas, doughnutSwitchers, doughnutIndex, getMonth);
    drawExpensesCanvas(getMonth(doughnutIndex)[0], getMonth(doughnutIndex)[1]);
    statDoughnutButtons.forEach((button) => {
        button.classList.remove('btn-active');
    })
    statDoughnutBtnMonth.classList.add('btn-active');
    // Text representation of the selected period
    const textField = document.querySelector('.doughnut-text');
    textField.innerHTML = '';
    textField.innerHTML = `du ${transformMonthAndYearToFormatFr(getMonth(doughnutIndex)[0])} - au ${transformMonthAndYearToFormatFr(getMonth(doughnutIndex)[1])}`;
    return doughnutIndex;
});

const statDoughnutBtnQuarter = document.getElementById('doughnut-quarter');
statDoughnutBtnQuarter.addEventListener('click', () => {
    doughnutIndex = 0;
    document.getElementById('custom-legend').innerHTML = '';
    createSwitchers('doughnut', drawExpensesCanvas, doughnutSwitchers, doughnutIndex, getQuarter);
    drawExpensesCanvas(getQuarter(doughnutIndex)[0], getQuarter(doughnutIndex)[1]);
    statDoughnutButtons.forEach((button) => {
        button.classList.remove('btn-active');
    })
    statDoughnutBtnQuarter.classList.add('btn-active');
    // Text representation of the selected period
    const textField = document.querySelector('.doughnut-text');
    textField.innerHTML = '';
    textField.innerHTML = `du ${transformMonthAndYearToFormatFr(getQuarter(doughnutIndex)[0])} - au ${transformMonthAndYearToFormatFr(getQuarter(doughnutIndex)[1])}`;
    return doughnutIndex;
});

const statDoughnutBtnHalfYear = document.getElementById('doughnut-halfYear');
statDoughnutBtnHalfYear.addEventListener('click', () => {
    doughnutIndex = 0;
    document.getElementById('custom-legend').innerHTML = '';
    createSwitchers('doughnut', drawExpensesCanvas, doughnutSwitchers, doughnutIndex, getHalfYear);
    drawExpensesCanvas(getHalfYear(doughnutIndex)[0], getHalfYear(doughnutIndex)[1]);
    statDoughnutButtons.forEach((button) => {
        button.classList.remove('btn-active');
    })
    statDoughnutBtnHalfYear.classList.add('btn-active');
    // Text representation of the selected period
    const textField = document.querySelector('.doughnut-text');
    textField.innerHTML = '';
    textField.innerHTML = `du ${transformMonthAndYearToFormatFr(getHalfYear(doughnutIndex)[0])} - au ${transformMonthAndYearToFormatFr(getHalfYear(doughnutIndex)[1])}`;
    return doughnutIndex;
});

const statDoughnutBtnYear = document.getElementById('doughnut-year');
statDoughnutBtnYear.addEventListener('click', () => {
    doughnutIndex = 0;
    document.getElementById('custom-legend').innerHTML = '';
    createSwitchers('doughnut', drawExpensesCanvas, doughnutSwitchers, doughnutIndex, getYear);
    drawExpensesCanvas(getYear(doughnutIndex)[0], getYear(doughnutIndex)[1]);
    statDoughnutButtons.forEach((button) => {
        button.classList.remove('btn-active');
    })
    statDoughnutBtnYear.classList.add('btn-active');
    // Text representation of the selected period
    const textField = document.querySelector('.doughnut-text');
    textField.innerHTML = '';
    textField.innerHTML = `du ${transformMonthAndYearToFormatFr(getYear(doughnutIndex)[0])} - au ${transformMonthAndYearToFormatFr(getYear(doughnutIndex)[1])}`;
    return doughnutIndex;
});

const statDoughnutBtnAll = document.getElementById('doughnut-all');
statDoughnutBtnAll.addEventListener('click', () => {
    doughnutIndex = 0;
    document.getElementById('custom-legend').innerHTML = '';
    doughnutSwitchers.innerHTML = '';
    drawExpensesCanvas(getAll(doughnutIndex)[0], getAll(doughnutIndex)[1]);
    statDoughnutButtons.forEach((button) => {
        button.classList.remove('btn-active');
    })
    statDoughnutBtnAll.classList.add('btn-active');
    return doughnutIndex;
});

//====================================================== FLUX CANVA'S (BAR) LOGIC =========================================================
// Getting html elements from the page
let barIndex = 0; // Index of a period (0 equals to now)

const statBarButtons = document.querySelectorAll('.bar-btn'); // Buttons to change the periods
const barSwitchers = document.querySelector('.bar-switchers-container'); // Container of offset butttons and text to modify
const barComparisonText = document.querySelector('.bar-comparison-text'); // Container to populate the flux text

// Variable to hold the chart instance
let barChart = null;

// Initial function call to generate switcher's content 
createSwitchers('bar', drawFluxCanvas, barSwitchers, barIndex, getMonth);

// Select the canvas element
const canvasBar = document.getElementById('curveBarFlux');
const ctxBar = canvasBar.getContext('2d');

function drawFluxCanvas(offsetStart, offsetEnd) {

    // Destroy the existing chart if it exists
    if (barChart) {
        barChart.destroy();
    }

    // Find total of expenses to be used in chart's data
    const expenses = operationsTotalByClient.filter(
        (operation) => operation.type_id === 1 && 
        operation.timestamp.slice(0, 7) >= offsetStart && 
        operation.timestamp.slice(0, 7) <= offsetEnd
    );

    // Initialize the variable to store the total value of expenses
    let totalExpenses = 0;
    // Calculate the total value
    expenses.forEach(expense => {
        totalExpenses += parseFloat(expense.montant);
        return totalExpenses;
    });
    
    // Find total of revenus to be used in chart's data
    const revenus = operationsTotalByClient.filter(
        (operation) => operation.type_id === 2 && 
        operation.timestamp.slice(0, 7) >= offsetStart && 
        operation.timestamp.slice(0, 7) <= offsetEnd
    );

    // Initialize the variable to store the total value of revenus
    let totalRevenus = 0;
    // Calculate the total value
    revenus.forEach(revenu => {
        totalRevenus += parseFloat(revenu.montant);
        return totalRevenus;
    });

    const flux = totalRevenus + totalExpenses * -1;
    if (flux > 0) {
        barComparisonText.innerHTML = "Dans la période sélectionnée, votre flux est égal à <span class='bar-comparison-value'></span>";
        const barComparison =  document.querySelector('.bar-comparison-value');
        barComparison.classList.remove('color-red');
        barComparison.classList.add('color-green');
        barComparison.innerHTML = `${flux.toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })} €`;
    } else if (flux < 0) {
        barComparisonText.innerHTML = "Dans la période sélectionnée, votre flux est égal à <span class='bar-comparison-value'></span>";
        const barComparison =  document.querySelector('.bar-comparison-value');
        barComparison.classList.remove('color-green');
        barComparison.classList.add('color-red');
        barComparison.innerHTML = `${flux.toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })} €`;
    } else if (totalRevenus == 0 && totalExpenses == 0) {
        barComparisonText.innerHTML = "Oops… Il n'y a aucune opération dans la période sélectionnée";
    } else {
        barComparisonText.innerHTML = "Dans la période sélectionnée, votre flux est égal à <span class='bar-comparison-value'></span>";
        const barComparison =  document.querySelector('.bar-comparison-value');
        barComparison.classList.remove('color-red');
        barComparison.classList.remove('color-green');
        barComparison.innerHTML = `${flux.toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })} €`;
    }
    
    // Initialize the chart
    barChart = new Chart(ctxBar, {
        plugins: [ChartDataLabels],
        type: 'bar',
        data: {
          labels: [""],
          datasets: [
            {
              label: "Dépenses",
              backgroundColor: "#ee3939",
              data: [totalExpenses * -1]
            }, {
              label: "Revenus",
              backgroundColor: "#16a18c",
              data: [totalRevenus]
            }
          ]
        },
        options: {
            indexAxis: 'y',
            // Elements options apply to all of the options unless overridden in a dataset
            // In this case, we are setting the border of each horizontal bar to be 2px wide
            elements: {
              bar: {
                borderWidth: 0,
                borderRadius: 20
              }
            },
            responsive: true,
            maintainAspectRatio: false, // Allows full flexibility in resizing
            scales: {
              x: {
                stacked: true,
              },
              y: {
                stacked: true
              }
            },
            plugins: {
                legend: {
                    display: false, // Custom legend managed separately
                },
                tooltip: {
                    callbacks: {
                        label: (context) => {
                            const value = context.raw;
                            return ` ${value.toFixed(2)} €`;
                        },
                    },
                },
                datalabels: {
                    formatter: (value) => {
                        return `${value.toFixed(2)} €`;
                    },
                    color: '#fff',
                },
            },
        },
    });
}
drawFluxCanvas(getMonth(barIndex)[0], getMonth(barIndex)[1]);

// Logic for each offset button
const statBarBtnMonth = document.getElementById('bar-month');
statBarBtnMonth.addEventListener('click', () => {
    barIndex = 0;
    // Place for comparsion info
    createSwitchers('bar', drawFluxCanvas, barSwitchers, barIndex, getMonth);
    drawFluxCanvas(getMonth(barIndex)[0], getMonth(barIndex)[1]);
    statBarButtons.forEach((button) => {
        button.classList.remove('btn-active');
    })
    statBarBtnMonth.classList.add('btn-active');
    // Text representation of the selected period
    const textField = document.querySelector('.bar-text');
    textField.innerHTML = '';
    textField.innerHTML = `du ${transformMonthAndYearToFormatFr(getMonth(barIndex)[0])} - au ${transformMonthAndYearToFormatFr(getMonth(barIndex)[1])}`;
    return barIndex;
});

const statBarBtnQuarter = document.getElementById('bar-quarter');
statBarBtnQuarter.addEventListener('click', () => {
    barIndex = 0;
    // Place for comparsion info
    createSwitchers('bar', drawFluxCanvas, barSwitchers, barIndex, getQuarter);
    drawFluxCanvas(getQuarter(barIndex)[0], getQuarter(barIndex)[1]);
    statBarButtons.forEach((button) => {
        button.classList.remove('btn-active');
    })
    statBarBtnQuarter.classList.add('btn-active');
    // Text representation of the selected period
    const textField = document.querySelector('.bar-text');
    textField.innerHTML = '';
    textField.innerHTML = `du ${transformMonthAndYearToFormatFr(getQuarter(barIndex)[0])} - au ${transformMonthAndYearToFormatFr(getQuarter(barIndex)[1])}`;
    return barIndex;
});

const statBarBtnHalfYear = document.getElementById('bar-halfYear');
statBarBtnHalfYear.addEventListener('click', () => {
    barIndex = 0;
    // Place for comparsion info
    createSwitchers('bar', drawFluxCanvas, barSwitchers, barIndex, getHalfYear);
    drawFluxCanvas(getHalfYear(barIndex)[0], getHalfYear(barIndex)[1]);
    statBarButtons.forEach((button) => {
        button.classList.remove('btn-active');
    })
    statBarBtnHalfYear.classList.add('btn-active');
    // Text representation of the selected period
    const textField = document.querySelector('.bar-text');
    textField.innerHTML = '';
    textField.innerHTML = `du ${transformMonthAndYearToFormatFr(getHalfYear(barIndex)[0])} - au ${transformMonthAndYearToFormatFr(getHalfYear(barIndex)[1])}`;
    return barIndex;
});

const statBarBtnYear = document.getElementById('bar-year');
statBarBtnYear.addEventListener('click', () => {
    barIndex = 0;
    // Place for comparsion info
    createSwitchers('bar', drawFluxCanvas, barSwitchers, barIndex, getYear);
    drawFluxCanvas(getYear(barIndex)[0], getYear(barIndex)[1]);
    statBarButtons.forEach((button) => {
        button.classList.remove('btn-active');
    })
    statBarBtnYear.classList.add('btn-active');
    // Text representation of the selected period
    const textField = document.querySelector('.bar-text');
    textField.innerHTML = '';
    textField.innerHTML = `du ${transformMonthAndYearToFormatFr(getYear(barIndex)[0])} - au ${transformMonthAndYearToFormatFr(getYear(barIndex)[1])}`;
    return barIndex;
});

const statBarBtnAll = document.getElementById('bar-all');
statBarBtnAll.addEventListener('click', () => {
    barIndex = 0;
    // Place for comparsion info
    barSwitchers.innerHTML = '';
    drawFluxCanvas(getAll(barIndex)[0], getAll(barIndex)[1]);
    statBarButtons.forEach((button) => {
        button.classList.remove('btn-active');
    })
    statBarBtnAll.classList.add('btn-active');
    return barIndex;
});