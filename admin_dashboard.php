<?php
require_once 'config.php';
requireAdmin();

// Get statistics
$stmt = $pdo->query("SELECT COUNT(*) as total_users FROM users");
$total_users = $stmt->fetch(PDO::FETCH_ASSOC)['total_users'];

$stmt = $pdo->query("SELECT COUNT(*) as total_destinations FROM destinations");
$total_destinations = $stmt->fetch(PDO::FETCH_ASSOC)['total_destinations'];

$stmt = $pdo->query("SELECT COUNT(*) as total_experiences FROM experiences");
$total_experiences = $stmt->fetch(PDO::FETCH_ASSOC)['total_experiences'];

$stmt = $pdo->query("SELECT COUNT(*) as pending_users FROM users WHERE role = 'contributor'");
$pending_users = $stmt->fetch(PDO::FETCH_ASSOC)['pending_users'];

// Get users for management
$users_stmt = $pdo->query("SELECT * FROM users ORDER BY created_at DESC");
$users = $users_stmt->fetchAll(PDO::FETCH_ASSOC);

// Get destinations
$destinations_stmt = $pdo->query("SELECT * FROM destinations ORDER BY created_at DESC");
$destinations = $destinations_stmt->fetchAll(PDO::FETCH_ASSOC);

// Get experiences
$experiences_stmt = $pdo->query("SELECT * FROM experiences ORDER BY created_at DESC");
$experiences = $experiences_stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle user role update
if (isset($_POST['update_role'])) {
    $user_id = $_POST['user_id'];
    $new_role = $_POST['role'];
    
    $stmt = $pdo->prepare("UPDATE users SET role = ? WHERE user_id = ?");
    $stmt->execute([$new_role, $user_id]);
    header("Location: admin_dashboard.php");
    exit();
}

// Handle user deletion
if (isset($_POST['delete_user'])) {
    $user_id = $_POST['user_id'];
    
    $stmt = $pdo->prepare("DELETE FROM users WHERE user_id = ?");
    $stmt->execute([$user_id]);
    header("Location: admin_dashboard.php");
    exit();
}

// Handle destination deletion
if (isset($_POST['delete_destination'])) {
    $destination_id = $_POST['destination_id'];
    
    $stmt = $pdo->prepare("DELETE FROM destinations WHERE destination_id = ?");
    $stmt->execute([$destination_id]);
    header("Location: admin_dashboard.php");
    exit();
}

// Handle experience deletion
if (isset($_POST['delete_experience'])) {
    $experience_id = $_POST['experience_id'];
    
    $stmt = $pdo->prepare("DELETE FROM experiences WHERE experience_id = ?");
    $stmt->execute([$experience_id]);
    header("Location: admin_dashboard.php");
    exit();
}
?>