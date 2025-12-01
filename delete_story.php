<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$experience_id = $_POST['experience_id'];
$user_id = $_SESSION['user_id'];


$stmt = $pdo->prepare("SELECT * FROM experiences WHERE experience_id = ? AND user_id = ?");
$stmt->execute([$experience_id, $user_id]);
$experience = $stmt->fetch();

if ($experience) {

    $stmt_img = $pdo->prepare("SELECT image_url FROM experience_images WHERE experience_id = ?");
    $stmt_img->execute([$experience_id]);
    $images = $stmt_img->fetchAll();

    foreach ($images as $img) {
        if (file_exists($img['image_url'])) unlink($img['image_url']);
    }

  
    $stmt_delete = $pdo->prepare("DELETE FROM experiences WHERE experience_id = ? AND user_id = ?");
    $stmt_delete->execute([$experience_id, $user_id]);

    header("Location: index.php?deleted=1");
    exit;
} else {
    header("Location: index.php?error=not_allowed");
    exit;
}
?>
