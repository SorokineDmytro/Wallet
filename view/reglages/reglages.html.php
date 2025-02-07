<section class="settings">
    <div class="block settings-container">
        <div class="settings-container-logo">
            <div class="circle-photo" style="background-image:url('<?= $clientInfo['photo']?>');">
                <button type="button" class="action-btn" onclick="showModal('photo')"><i class="fas fa-pen"></i></button>
            </div>
            <span class="settings-register-date">
                Enregistré depuis: <?= $clientInfo['register_date']?>
                <button type="button" class="action-btn" onclick="showModal('delete')"><i class="fas fa-trash"></i></button>
            </span>
        </div>
        <div class="settings-container-content">
            <div class="settings-header">
                <span class="settings-name">
                    <?= $clientInfo['firstName']?> <?= $clientInfo['lastName']?>
                </span>
                <span class="settings-email">
                    <?= $clientInfo['email']?>
                </span>
            </div>
            <div class="settings-main">
                <div class="title">
                    <h3>Information personnelle</h3>
                    <button type="button" class="action-btn" onclick="showModal('information')"><i class="fas fa-pen"></i></button>
                </div>
                <ul class="info-list">
                    <li class="info_list_item">
                        <span class="info-list_item-label">Nom:</span>
                        <span class="info-list_item-text"><?= $clientInfo['lastName']?></span>
                    </li>
                    <li class="info_list_item">
                        <span class="info-list_item-label">Prénom: </span>
                        <span class="info-list_item-text"><?= $clientInfo['firstName']?></span>
                    </li>
                    <li class="info_list_item">
                        <span class="info-list_item-label">E-mail:</span>
                        <span class="info-list_item-text"><?= $clientInfo['email']?></span>
                    </li>
                </ul>
            </div>
            <div class="settings-password">
                <div class="title">
                    <h3>Mot de passe</h3>
                    <button type="button" class="action-btn" onclick="showModal('password')"><i class="fas fa-pen"></i></button>
                </div>
                <ul class="info-list">
                    <li class="info_list_item">
                        <span class="info-list_item-label">Mot de passe:</span>
                        <span class="info-list_item-text">********</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="settings-image"></div>
    <div id="overlay" class="overlay hidden"></div>
</section>
<script>
    // Retrieve and parse the accountInfo in JSON format passed from PHP
    const clientInfoJSON = JSON.parse('<?php echo $clientInfoJSON; ?>');
    // Retrieve and parse the clientsList in JSON format passed from PHP
    const clientsEmailListJSON = JSON.parse('<?php echo $clientsEmailListJSON; ?>');
</script>