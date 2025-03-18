<div class="block container">
    <h2><?=$title?></h2>
    <form id="forgot-password-form">
        <div class="line-input">
            <label for="email" class="required">E-mail de récupération</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="action-buttons">
            <a href="javascript:history.back()" class="action-btn back">Retour</a>
            <button type="submit" class="action-btn reset">Réinitialiser</button>
        </div>
    </form>
    <p id="forgot-message"></p>
</div>
    
<script>
    document.getElementById("forgot-password-form").addEventListener("submit", function(event) {
        event.preventDefault();
        let email = document.getElementById("email").value;

        fetch('index.php?url=forgotPasswordLogic', {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "email=" + encodeURIComponent(email),
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById("forgot-message").textContent = data.message;
        })
        .catch(error => console.error("Error:", error));
    });
</script>

