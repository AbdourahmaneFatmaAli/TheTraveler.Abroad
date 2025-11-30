<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $first = $_POST['first_name'];
    $last  = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password_hash'];

   
    $hashed = password_hash($password, PASSWORD_DEFAULT);

  
    $stmt = $pdo->prepare("INSERT INTO users(first_name, last_name, email, password_hash) 
                           VALUES(?,?,?,?)");
    $stmt->execute([$first, $last, $email, $hashed]);

   
    header("Location: Login1.php");
    exit;
}
?>
