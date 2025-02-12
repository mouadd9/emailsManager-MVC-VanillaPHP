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
                <div class="email-lists">
                    <div class="email-tables">
                        <!-- Valid Emails -->
                        <div class="email-table">
                            <div class="table-container">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Emails Valides</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($validEmails as $email): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($email) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Invalid Emails -->
                        <div class="email-table">
                            <div class="table-container">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Emails Non Valides</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($invalidEmails as $email): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($email) ?></td>
                                            </tr>
                                        <?php endforeach; ?>    
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Sorted Emails -->
                        <div class="email-table">
                            <div class="table-container">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Emails Triés</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($sortedEmails as $email): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($email) ?></td>
                                            </tr>
                                        <?php endforeach; ?>    
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <h2>Emails par Domaine</h2>
                    <!-- Domain Tables -->
                    <div class="domain-tables">
    
                        <?php foreach ($domainEmails as $domain => $emails): ?>
                            <div class="domain-table">
                                <div class="table-container">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th><?= htmlspecialchars($domain) ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($emails as $email): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($email) ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>  
        </main>
    </div>
    <script src="js/app.js"></script>
</body>
</html>
