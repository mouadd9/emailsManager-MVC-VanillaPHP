<?php
/**
 * This is our main template file
 * It defines the basic HTML structure of our page
 * PHP will replace <?= ?> tags with actual values
 */
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1><?= $pageTitle ?></h1>
        </header>
        <main>
            <!-- Formulaire pour ajouter un nouvel email -->
            <div class="email-form">
                <h2>Ajouter un email</h2>
                <form id="emailForm" >
                    <div class="form-group">
                        <input type="text" id="email" name="email" placeholder="Exemple: utilisateur@domaine.com" required>
                        <button type="submit">Ajouter</button>
                    </div>
                </form>
                <div class="actions">
                    <button onclick="performAction('verifierAdresses')">Vérifier les emails</button>
                    <button onclick="performAction('afficherFrequences')">Afficher fréquences</button>
                    <button onclick="performAction('supprimerDoublons')">Supprimer doublons</button>
                    <button onclick="performAction('trierEmails')">Trier les emails</button>
                    <button onclick="performAction('separerDomaines')">Séparer par domaine</button>
                </div>

                <div id="resultArea"></div>

                <!-- Email Lists -->
                <div class="email-lists" id="emailLists">
                    <?php require ROOT_PATH . '/src/Views/partial/tables.php'; ?>
                </div>

                <!-- Email Frequencies -->
                <div class="email-frequencies" id="emailFrequencies" style="display: none;">
                    <h2>Fréquences des Emails</h2>
                    <ul id="frequencyList"></ul>
                </div>
            </div>  
        </main>
    </div>
    <script src="js/app.js"></script>
</body>
</html>
