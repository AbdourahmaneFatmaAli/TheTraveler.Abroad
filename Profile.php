<?php
session_start();
include 'config.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT user_id, first_name, last_name, email FROM users WHERE user_id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 50px 20px;
        }

        .profile-container {
            max-width: 500px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        h1 {
            text-align: center;
            color: #5b21b6;
            margin-bottom: 30px;
        }

        .info {
            margin-bottom: 30px;
        }

        .info p {
            font-size: 18px;
            margin: 15px 0;
            color: #333;
        }

        .info strong {
            color: #000;
        }

        a {
            display: inline-block;
            padding: 10px 20px;
            margin: 5px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }

        .edit-btn {
            background-color: #5b21b6;
            color: white;
        }

        .logout-btn {
            background-color: #dc2626;
            color: white;
        }

        .home-link {
            background-color: #10b981;
            color: white;
        }

        a:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>

<div class="profile-container">
    <h1>My Profile</h1>

    <div class="info">
        <p><strong>Name:</strong> <?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
    </div>

    <a href="edit_profile.php" class="edit-btn">Edit Profile</a>
    <a href="logout.php" class="logout-btn">Logout</a>
    <a href="index.php" class="home-link">Return to Home</a>
</div>

</body>
</html>