<?php
require 'config.php';

// Récupérer les commentaires
$stmt = $pdo->query("SELECT comment.*, user.prenom, user.nom FROM comment JOIN user ON comment.id_user = user.id ORDER BY comment.date DESC");
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil</title>
    <link rel="stylesheet" href="./assets/css/styles.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="./assets/img/logo1.webp" alt="Logo">
        </div>
        <div class="login-button">
            <?php if (isset($_SESSION['user'])): ?>
                <a href="logout.php" class="logout-btn">Déconnexion</a>
            <?php else: ?>
                <a href="#" class="login-btn">Connexion</a>
            <?php endif; ?>
        </div>
    </header>

    <div class="container">
        <!-- Slideshow -->
        <div class="slideshow-container">
            <img src="./assets/img/mariage3.jpeg" alt="Image 1">
            <img src="assets/img/mariage4.jpeg" alt="Image 2">
            <img src="./assets/img/mariage5.jpg" alt="Image 3">
            <img src="./assets/img/mariage6.jpeg" alt="Image 4">
            <img src="./assets/img/mariage7.jpeg" alt="Image 5">
            <button class="prev">&#10094;</button>
            <button class="next">&#10095;</button>
        </div>

        <!-- Barre latérale des commentaires -->
        <div class="sidebar-container">
            <h2>Commentaires</h2>
            <ul>
                <?php foreach ($comments as $comment): ?>
                    <li>
                        <strong><?= htmlspecialchars($comment['prenom']) ?> <?= htmlspecialchars($comment['nom']) ?></strong>
                        <p><?= htmlspecialchars($comment['comment']) ?></p>
                        <small><?= $comment['date'] ?></small>
                    </li>
                <?php endforeach; ?>
            </ul>
            <a href="commentaires.php">Ajouter un commentaire</a>
        </div>
    </div>

    <!-- Modal de connexion et d'inscription -->
    <div class="modal login-modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div class="tab">
                <button class="tablinks" onclick="openTab(event, 'Login')" id="defaultOpen">Connexion</button>
                <button class="tablinks" onclick="openTab(event, 'Register')">Inscription</button>
            </div>
            <div id="Login" class="tabcontent">
                <h2>Connexion</h2>
                <form id="login-form" action="auth.php" method="POST">
                    <input type="email" name="email" placeholder="E-mail" required>
                    <input type="password" name="password" placeholder="Mot de passe" required>
                    <button type="submit" name="login_btn">Se connecter</button>
                </form>
            </div>
            <div id="Register" class="tabcontent">
                <h2>Inscription</h2>
                <form id="register-form" action="auth.php" method="POST">
                    <input type="text" name="prenom" placeholder="Prénom" required>
                    <input type="text" name="nom" placeholder="Nom" required>
                    <input type="email" name="email" placeholder="E-mail" required>
                    <input type="password" name="password" placeholder="Mot de passe" required>
                    <button type="submit" name="register">S'inscrire</button>
                </form>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2023 - Tous droits réservés</p>
    </footer>

    <script src="./assets/js/script.js"></script>
</body>
</html>