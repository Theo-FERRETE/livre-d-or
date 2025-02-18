<?php
session_start();
require 'config.php';

// Récupérer les commentaires avec le prénom des utilisateurs
$comment = $pdo->query("
    SELECT c.comment, u.prenom, c.date 
    FROM comment c 
    JOIN `user` u ON c.id_user = u.id 
    ORDER BY c.date DESC
")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livre d'Or</title>
    <link rel="stylesheet" href="./css/styles.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="./assets/img/logo1.webp" alt="Logo">
        </div>
        <div class="login-button">
            <?php if (isset($_SESSION['user'])): ?>
                <a href="logout.php">Déconnexion</a>
            <?php else: ?>
                <a href="auth.php">Connexion</a>
            <?php endif; ?>
        </div>
    </header>
    <div class="container">
        <!-- Zone des commentaires -->
        <aside class="sidebar-container">
            <h2>Avis et commentaires</h2>
        
            <ul>
                <?php foreach ($comment as $c): ?>
                    <li>
                        <strong><?= htmlspecialchars($c['prenom']) ?></strong> (<?= $c['date'] ?>) : <br><?= htmlspecialchars($c['comment']) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
            <?php if (isset($_SESSION['user'])): ?>
                <a href="commentaires.php">Ajouter un commentaire</a>
            <?php else: ?>
                <p>Veuillez vous <a href="auth.php">connecter</a> pour ajouter un commentaire.</p>
            <?php endif; ?>
        </aside>
        <div class="slideshow-container">
            <img src="./assets/img/mariage2.jpeg" alt="">
            <img src="./assets/img/mariage3.jpeg" alt="">
            <img src="./assets/img/mariage4.jpeg" alt="">
            <img src="./assets/img/mariage5.jpeg" alt="">
            <img src="./assets/img/mariage6.jpeg" alt="">
            <img src="./assets/img/mariage7.jpeg" alt="">
            <button id="prev">&#10094;</button>
            <button id="next">&#10095;</button>
        </div>
    </div>
    <script src="./js/script.js"></script>
    <script src="./js/slideshow.js"></script>
<footer>
    <p>&copy; 2023 Livre d'Or</p>
</footer>



</body>
</html>
