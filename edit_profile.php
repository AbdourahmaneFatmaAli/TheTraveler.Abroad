<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT first_name, last_name, email FROM users WHERE user_id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = trim($_POST['first_name']);
    $last_name  = trim($_POST['last_name']);
    $email      = trim($_POST['email']);

    $stmt = $pdo->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ? WHERE user_id = ?");
    $stmt->execute([$first_name, $last_name, $email, $user_id]);

    header("Location: Profile.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Profile</title>
<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f0f0f0;
    margin: 0;
    padding: 50px 20px;
}

.edit-container {
    max-width: 400px;
    margin: 0 auto;
    background: #fff;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

h1 {
    text-align: center;
    color: #333;
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 15px;
}

label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

input[type="text"], input[type="email"] {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}

.btn-submit {
    width: 100%;
    padding: 10px;
    background-color: #5b21b6;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-weight: bold;
}

.btn-submit:hover {
    background-color: #4c1d95;
}

.back-link {
    display: block;
    text-align: center;
    margin-top: 15px;
    text-decoration: none;
    color: #5b21b6;
}
</style>




</head>
<body>

<div class="edit-container">
    <h1>Edit Profile</h1>

    <form method="POST" novalidate>

        <div class="form-group">
            <label for="first_name">First Name</label>
            <input id="first_name" type="text" name="first_name" value="<?= htmlspecialchars($user['first_name'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input id="last_name" type="text" name="last_name" value="<?= htmlspecialchars($user['last_name'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label for="email">Email Address</label>
            <input id="email" type="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" required>
        </div>

        <button type="submit" class="btn-submit">Save Changes</button>

    </form>

    <a href="profile.php" class="back-link">Back to Profile</a>
</div>

</body>
</html>
