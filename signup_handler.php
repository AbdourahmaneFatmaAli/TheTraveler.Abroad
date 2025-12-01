<?php

include 'config.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];


    if($password !== $confirm_password){
        die('Password does not match');
    }


    $stmt = $pdo->prepare('SELECT user_id FROM users WHERE email = ? OR username = ? ');
    $stmt->execute([$email, $username]);
    if($stmt->fetch()) {
        die('User already exists with this email or username');
    }


    $hashed_password= password_hash($password, PASSWORD_DEFAULT);

    try{
        $stmt = $pdo->prepare('INSERT INTO users (username, email, password) VALUES (?,?,?)');

        $stmt->execute([$username, $email, $hashed_password]);


        session_start();
        $_SESSION['signup_success'] = 'Account created successfully, now login';

        header('Location: login.php');
        exit();


     } catch (PDOException $e) {
        die('Error creating account:' . $e->getMessage());
     }


}
?>




