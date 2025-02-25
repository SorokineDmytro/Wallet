const logout = document.querySelector('.logout');
logout.addEventListener('click', async (event) => {
    try {
        const response = await fetch('index.php?url=login', { // Path to LoginController
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ logout: true })
        });

        const result = await response.json();

        if (result.success) {
            window.location.href = 'wellcome'; // Redirect after success
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Something went wrong.');
    }
});

const logoutMobile = document.querySelector('.logoutMobile');
logoutMobile.addEventListener('click', async (event) => {
    try {
        const response = await fetch('index.php?url=login', { // Path to LoginController
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ logout: true })
        });

        const result = await response.json();

        if (result.success) {
            window.location.href = 'wellcome'; // Redirect after success
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Something went wrong.');
    }
});