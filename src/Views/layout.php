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
    <link rel="stylesheet" href="../public/css/style.css">
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
                    <input type="text" id="email" name="email" placeholder="Exemple: utilisateur@domaine.com" required>
                    <button type="submit">Ajouter</button>
                </form>
                <div class="actions">
                    <button onclick="performAction('verifierAdresses')">Vérifier les emails</button>
                    <button onclick="performAction('afficherFrequences')">Afficher fréquences</button>
                    <button onclick="performAction('supprimerDoublons')">Supprimer doublons</button>
                    <button onclick="performAction('trierEmails')">Trier les emails</button>
                    <button onclick="performAction('separerDomaines')">Séparer par domaine</button>
                </div>
                <div>
                    <h3>Liste des emails Emails.txt</h3>
                    <ul id="emailList">
                        <?php foreach($emails as $email): ?>
                            <li><?= $email ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div id="resultArea"></div>
            </div>  
        </main>
    </div>
    <script src="../public/js/app.js"></script>
</body>
</html>
