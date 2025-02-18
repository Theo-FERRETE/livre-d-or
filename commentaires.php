<?php
require 'config.php';

if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

// Ajouter un commentaire
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_comment'])) {
    $comment = htmlspecialchars($_POST['comment']);
    $id_user = $_SESSION['user']['id'];

    if (!empty($comment)) {
        $stmt = $pdo->prepare("INSERT INTO comment (comment, id_user) VALUES (?, ?)");
        $stmt->execute([$comment, $id_user]);
        header("Location: commentaires.php");
        exit();
    } else {
        echo "Veuillez écrire un commentaire.";
    }
}

// Supprimer un commentaire
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM comment WHERE id = ? AND id_user = ?");
    $stmt->execute([$id, $_SESSION['user']['id']]);
    header("Location: commentaires.php");
    exit();
}

// Modifier un commentaire
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM comment WHERE id = ? AND id_user = ?");
    $stmt->execute([$id, $_SESSION['user']['id']]);
    $comment = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($comment) {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_comment'])) {
            $newComment = htmlspecialchars($_POST['comment']);
            if (!empty($newComment)) {
                $stmt = $pdo->prepare("UPDATE comment SET comment = ? WHERE id = ?");
                $stmt->execute([$newComment, $id]);
                header("Location: commentaires.php");
                exit();
            } else {
                echo "Veuillez écrire un commentaire.";
            }
        }
    } else {
        echo "Ce commentaire n'existe pas.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Commentaires</title>
    <link rel="stylesheet" href="./assets/css/styles2.css">
</head>
<body>
    <header>
        <a href="index.php" class="back-btn">Retour à l'accueil</a>
        <?php if (isset($_SESSION['user'])): ?>
            <a href="logout.php" class="logout-btn">Déconnexion</a>
        <?php endif; ?>
    </header>

    <h2>Ajouter un commentaire</h2>
    <form method="POST">
        <textarea name="comment" placeholder="Votre commentaire"></textarea>
        <button type="submit" name="submit_comment">Publier</button>
    </form>

    <h2>Mes commentaires</h2>
    <ul>
        <?php
        $stmt = $pdo->prepare("SELECT * FROM comment WHERE id_user = ? ORDER BY date DESC");
        $stmt->execute([$_SESSION['user']['id']]);
        $userComments = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($userComments as $comment): ?>
            <li>
                <p><?= htmlspecialchars($comment['comment']) ?></p>
                <small><?= $comment['date'] ?></small>
                <a href="commentaires.php?edit=<?= $comment['id'] ?>">Modifier</a>
                <a href="commentaires.php?delete=<?= $comment['id'] ?>">Supprimer</a>
            </li>
        <?php endforeach; ?>
    </ul>

    <?php if (isset($_GET['edit']) && $comment): ?>
        <h2>Modifier le commentaire</h2>
        <form method="POST">
            <textarea name="comment"><?= htmlspecialchars($comment['comment']) ?></textarea>
            <button type="submit" name="edit_comment">Modifier</button>
        </form>
    <?php endif; ?>
</body>
</html>