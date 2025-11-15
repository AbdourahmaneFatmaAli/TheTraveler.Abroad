<?php 
session_start();
include 'config.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);

    if($password !== $confirm_password){
        $_SESSION['signup_error'] = 'Password does not match';
        header('Location: /TheTraveler.Abroad/signup.php');
        exit();
    }


    $stmt = $pdo->prepare('SELECT user_id FROM users WHERE email = ? OR username = ?');
    $stmt->execute([$email, $username]);
    if($stmt->fetch()) {
        $_SESSION['signup_error'] = 'User already exists with this email or username';
        header('Location: /TheTraveler.Abroad/signup.php');
        exit();
    }
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare('INSERT INTO users (username, email, password, first_name, last_name) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$username, $email, $hashed_password, $first_name, $last_name]);

        $_SESSION['signup_success'] = 'Account created successfully! Please login.';
        header('Location: /TheTraveler.Abroad/login.html'); 
        exit();

    } catch (PDOException $e) {
        $_SESSION['signup_error'] = 'Error creating account: ' . $e->getMessage();
        header('Location: /TheTraveler.Abroad/signup.php');
        exit();
    }
}


