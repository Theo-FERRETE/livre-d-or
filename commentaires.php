<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user'])) {
    header('Location: auth.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_comment'])) {
    $comment = htmlspecialchars($_POST['comment']);
    $id_user = $_SESSION['user']['id'];

    if (!empty($comment)) {
        $stmt = $pdo->prepare("INSERT INTO comment (comment, id_user) VALUES (?, ?)");
        if ($stmt->execute([$comment, $id_user])) {
            echo "Commentaire ajouté avec succès !";
            header("Location: index.php");
            exit();
        } else {
            echo "Erreur lors de l'ajout du commentaire.";
        }
    } else {
        echo "Veuillez écrire un commentaire.";
    }
}
?>

<form method="POST">
    <textarea name="comment" placeholder="Votre commentaire"></textarea>
    <button type="submit" name="submit_comment">Publier</button>
</form>
