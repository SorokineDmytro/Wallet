// Function to retrieve the formatted timestamp (the end of the day) for a given date (today is 0, yestuday is -1, etc.)
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

// Retrieve the information and caculate the account's balance by account number
function calculateAccountBalanceByAccountByDate(accountNumber, timestamp) {
    // Get the initial amount of the account
    let initialAmount = savingAccounts.find(account => account.id === accountNumber).amount;
    // Get the total revenues by account
    let revenus = 0;
    const totalRevenuesByAccount = operationsTotalByClient.filter(operation => operation.compte_id === accountNumber && operation.type_id === 2 && operation.timestamp <= timestamp);
    totalRevenuesByAccount.forEach(operation => {
        revenus += parseFloat(operation.montant);
    });
    // Get the total expenses by account
    let expenses = 0;
    const totalExpensesByAccount = operationsTotalByClient.filter(operation => operation.compte_id === accountNumber && operation.type_id === 1 && operation.timestamp <= timestamp);
    totalExpensesByAccount.forEach(operation => {
        expenses += parseFloat(operation.montant);
    }); 
    // Get the total transfers in by account
    let transfertsIn = 0;
    const totalTransfertsInByAccount = operationsTotalByClient.filter(operation => operation.compte_destinataire_id === accountNumber && operation.type_id === 3 && operation.timestamp <= timestamp);
    totalTransfertsInByAccount.forEach(operation => {
        transfertsIn += parseFloat(operation.montant);
    });
    // Get the total transfers out by account
    let transfertsOut = 0;
    const totalTransfertsOutByAccount = operationsTotalByClient.filter(operation => operation.compte_id === accountNumber && operation.type_id === 3 && operation.timestamp <= timestamp);
    totalTransfertsOutByAccount.forEach(operation => {
        transfertsOut += parseFloat(operation.montant);
    });
    // Calculate the account's balance
    return parseFloat(initialAmount) + revenus - expenses + transfertsIn - transfertsOut;
};

let totalBalance = 0;

if(savingAccounts) {
    savingAccounts.forEach(account => {
        totalBalance += calculateAccountBalanceByAccountByDate(account.id, getFormattedTimestamp(0));
    });
}

const savingsBlock = document.querySelector('.savings-total');
savingsBlock.textContent = ` ${totalBalance.toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })} €`;

// ========================================================== CALCULATOR ==========================================================
const submitBtn = document.querySelector('#submitBtn');
const amountInput = document.querySelector('#initialAmount');
const contributionInput = document.querySelector('#contribution');
const contributionSelect = document.querySelector('#contributionInterval');
const interestRateInput = document.querySelector('#interestRate');
const interestSelect = document.querySelector('#interestInterval');
const periodInput = document.querySelector('#period');

amountInput.addEventListener('input', () => validateInput(amountInput));
contributionInput.addEventListener('input', () => validateInput(contributionInput));
contributionSelect.addEventListener('change', () => validateInput(contributionInput));
interestRateInput.addEventListener('input', () => validateInput(interestRateInput));
interestSelect.addEventListener('change', () => validateInput(interestRateInput));
periodInput.addEventListener('input', () => validateInput(periodInput));

function validateInput(input) {
    if (isNaN(input.value) || input.value.trim() === '') {
        input.value = '';
    } else if (input.value < 0) {
        input.value = 0;
    }
    validationCheck();
}

function validationCheck() {
    if((amountInput.value > 0 || contributionInput.value > 0) && periodInput.value > 0) {
        submitBtn.disabled = false;
        submitBtn.classList.remove('disabled');
    } else {
        submitBtn.disabled = true;
        submitBtn.classList.add('disabled');
    }
}

// ============================ COMPOUND INTEREST CALCULATION ============================

function setSavingsData(event) {
    event.preventDefault();

    let data = {
        montant_initial: document.getElementById("initialAmount").value,
        contributions: document.getElementById("contribution").value,
        periode_contributions: document.getElementById("contributionInterval").value,
        taux_interet: document.getElementById("interestRate").value,
        periode_interet: document.getElementById("interestInterval").value,
        nombre_annees: document.getElementById("period").value,
    };

    let form = document.createElement("form");
    form.method = "POST";
    form.action = "index.php?url=epargne";

    let input = document.createElement("input");
    input.type = "hidden";
    input.name = "epargneData";
    input.value = JSON.stringify(data);
    form.appendChild(input);

    document.body.appendChild(form);
    form.submit();
}

function calculateCompoundInterest() {
    // Get the data came from the controller
    let data = epargneData;

    // Set the values of the inputs
    document.getElementById("initialAmount").value = data.montant_initial;
    document.getElementById("contribution").value = data.contributions;
    document.getElementById("contributionInterval").value = data.periode_contributions;
    document.getElementById("interestRate").value = data.taux_interet;
    document.getElementById("interestInterval").value = data.periode_interet;
    document.getElementById("period").value = data.nombre_annees;

    // Set the values of variables for the calculation
    const initialAmount = parseFloat(data.montant_initial);
    const contribution = parseFloat(data.contributions);
    const contributionInterval = data.periode_contributions;
    const interestRate = parseFloat(data.taux_interet) / 100;
    const interestInterval = data.periode_interet;
    const years = parseInt(data.nombre_annees);

    let periodsPerYear = { month: 12, quarter: 4, halfYear: 2, year: 1 };
    let contributionFrequency = periodsPerYear[contributionInterval]; 
    let interestFrequency = periodsPerYear[interestInterval]; 

    let balance = initialAmount;
    let totalContributions = 0;
    let totalInterests = 0;

    let yearArray = [];
    let initialAmountArray = [];
    let contributionsByYearArray = [];
    let interestsByYearArray = [];
    let balanceArray = [];

    let tableHTML = `
        <table>
            <thead>
                <tr>
                    <th>Année</th>
                    <th>Solde initial (€)</th>
                    <th>Contributions annuelles (€)</th>
                    <th>Contributions Totales (€)</th>
                    <th>Intérêts gagnés (€)</th>
                    <th>Intérêt total (€)</th>
                    <th>Solde final (€)</th>
                </tr>
            </thead>
            <tbody>
    `;

    for (let year = 1; year <= years; year++) {
        let initialBalance = balance;
        let yearlyContribution = 0;
        let yearlyInterest = 0;

        for (let month = 1; month <= 12; month++) {
            if (month % (12 / contributionFrequency) === 0) { 
                balance += contribution;
                yearlyContribution += contribution;
                totalContributions += contribution;
            }
            
            if (month % (12 / interestFrequency) === 0) {
                let interestEarned = balance * interestRate; 
                balance += interestEarned;
                yearlyInterest += interestEarned;
                totalInterests += interestEarned;
            }
        }

        tableHTML += `
            <tr>
                <td class='center'>${year}</td>
                <td class='center'>${initialBalance.toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })} €</td>
                <td class='center'>${yearlyContribution.toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })} €</td>
                <td class='center'>${totalContributions.toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })} €</td>
                <td class='center'>${yearlyInterest.toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })} €</td>
                <td class='center'>${totalInterests.toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })} €</td>
                <td class='center'>${balance.toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })} €</td>
            </tr>
        `;

        yearArray.push(year);
        initialAmountArray.push
        contributionsByYearArray.push(totalContributions);
        interestsByYearArray.push(totalInterests);
        balanceArray.push(balance);
    }

    tableHTML += `</tbody></table>`;
    document.getElementById("table").innerHTML = tableHTML;
    document.querySelector(".statistic").classList.add('block');
    document.getElementById("total").classList.add('block');
    document.getElementById("total").innerHTML = `Solde final <br> <span class="bold">${balance.toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })} €</span>`;
    document.getElementById("totalContributions").classList.add('block');
    document.getElementById("totalContributions").innerHTML = `Total contribué <br> <span class="bold">${totalContributions.toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })} €</span>`;
    document.getElementById("totalInterests").classList.add('block');
    document.getElementById("totalInterests").innerHTML = `Intérêts gagnés <br> <span class="bold">${totalInterests.toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })} €</span>`;
    document.getElementById("table").innerHTML = tableHTML;

    createChart(yearArray, initialAmountArray, contributionsByYearArray, interestsByYearArray);

}

// ============================ CHART ============================

let myChart = null;
function createChart(yearArray, initialAmountArray, contributionsByYearArray, interestsByYearArray) {
    const canvas = document.getElementById('savingsChart');
    const ctx = canvas.getContext('2d');

    if (myChart) {
        myChart.destroy();
    }

    myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: yearArray,
            datasets: [
                { label: 'Solde initial', data: initialAmountArray, backgroundColor: '#957fef' },
                { label: 'Total contribué', data: contributionsByYearArray, backgroundColor: '#377cf6' },
                { label: 'Intérêts gagnés', data: interestsByYearArray, backgroundColor: '#16a18c' }
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: true, position: 'bottom' },
                tooltip: {
                    callbacks: {
                        title: (tooltipItems) => `Année ${tooltipItems[0].label}`,
                        label: (tooltipItem) => `${tooltipItem.dataset.label}: ${tooltipItem.raw.toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })} €`
                    }
                }
            },
            scales: { x: { stacked: true }, y: { stacked: true } }
        },
    });
}

// Restore saved inputs and generate table/chart on page load
document.addEventListener("DOMContentLoaded", () => {
    calculateCompoundInterest();
});
