<?php
/**
 * This is our main template file
 * It defines the basic HTML structure of our page
 * PHP will replace <?= ?> tags with actual values
 */
?>
<!DOCTYPE html>
<html>
<head>
    <!-- $pageTitle comes from the controller -->
    <title><?= $pageTitle ?></title>
</head>
<body>
    <!-- Main heading uses same title -->
    <h1><?= $pageTitle ?></h1>
    
    <!-- Email list section -->
    <h2>Email List:</h2>
    <ul>
        <?php 
        // Loop through each email in the $emails array
        // This array comes from the controller
        foreach($emails as $email): 
        ?>
            <li><?= $email ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
