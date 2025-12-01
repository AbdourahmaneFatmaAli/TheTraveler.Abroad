<?php
session_start();
include 'config.php';


if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit;
}


$errorMsg = $successMsg = '';

if ($_SERVER['REQUEST_METHOD']=== 'POST') {
  $user_id = $_SESSION['user_id'];

   $username = trim($_POST['username']);

 $stmt = $pdo->prepare('SELECT user_id, first_name, email FROM users WHERE username = ? OR email = ?');
 $stmt->execute([$username, $username]);
 $user = $stmt->fetch();


 


  if (!$user) {
    $errorMsg = 'User not found. Please sign up first';
  } else {
   
    $destination = trim($_POST['destination']);
    $description = trim($_POST['description']);

  
    $wordcount = str_word_count($description);
    if ($wordcount > 500) {
      $errorMsg = 'Your story must not exceed 500 words.';
   } elseif (!isset ($_FILES['picture']) || $_FILES['picture']['error'] !== UPLOAD_ERR_OK) {
    
    $errorMsg = 'Please upload an image';

   } else {
    $user_id = $_SESSION['user_id'];
    $insertExp = $pdo->prepare ('
    INSERT INTO experiences (first_name, email, destination, description, user_id) VALUES (?, ?, ?, ?, ?)');

    $insertExp->execute([$user['first_name'], $user['email'], $destination, $description, $user_id]);
    $experience_id = $pdo->lastInsertId();

    $uploadDir = 'upload/';
    if(!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

    $imageName = time() . '_' . basename($_FILES['picture']['name']);
    $imagePath = $uploadDir . $imageName;

    if (move_uploaded_file($_FILES['picture']['tmp_name'], $imagePath)) {
      $insertImg = $pdo->prepare('
      INSERT INTO experience_images (experience_id, image_url)
      VALUES (?, ?)');

   if ($insertImg->execute([$experience_id, $imagePath])) {

    header('Location: index.php?success=1');
    exit;

} else {
    $errorMsg = 'Failed to upload image';
}

            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en"> 
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
<title>Upload Your Travel Story</title>

<style>
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: sans-serif;
    background: linear-gradient(135deg, #ffffffff 0%, #c4d7f8ff 100%);
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: center;
    min-height: 100vh;
    padding: 40px 20px;
    color: #333;
}

.page-title {
    text-align: center;
    color: #333;
    margin-bottom: 30px;
    font-size: 2.5rem;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
    font-weight: 700;
    letter-spacing: 1px;
}

.form-container {
    background-color: white;
    padding: 40px;
    border-radius: 15px;
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
    max-width: 500px;
    width: 100%;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.form-container:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
}

.form-group {
    margin-bottom: 25px;
}

label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #444;
    font-size: 1rem;
}

input[type="text"],
input[type="email"],
textarea,
input[type="file"] {
    width: 100%;
    padding: 14px;
    border-radius: 8px;
    border: 2px solid #e1e5ee;
    font-size: 1rem;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

input[type="text"]:focus,
input[type="email"]:focus,
textarea:focus {
    outline: none;
    border-color: #6a1b9a;
    box-shadow: 0 0 0 3px rgba(106, 27, 154, 0.2);
}

textarea {
    height: 150px;
    resize: vertical;
    font-family: inherit;
}

input[type="file"] {
    padding: 10px;
    background-color: #f8f9fa;
    cursor: pointer;
}

input[type="file"]::file-selector-button {
    background: #6a1b9a;
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 5px;
    cursor: pointer;
    margin-right: 10px;
    transition: background-color 0.3s ease;
}

input[type="file"]::file-selector-button:hover {
    background: #4a0d73;
}

.submit-btn {
    width: 100%;
    background: linear-gradient(to right, #6a1b9a, #8e24aa);
    color: white;
    border: none;
    padding: 16px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 1.1rem;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(106, 27, 154, 0.4);
    letter-spacing: 0.5px;
}

.submit-btn:hover {
    background: linear-gradient(to right, #4a0d73, #6a1b9a);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(106, 27, 154, 0.5);
}

.submit-btn:active {
    transform: translateY(0);
}

.signup-section {
    text-align: center;
    margin-top: 25px;
    padding-top: 20px;
    border-top: 1px solid #eaeaea;
}

.signup-link {
    color: #6a1b9a;
    text-decoration: none;
    font-weight: 600;
    transition: color 0.3s ease;
}

.signup-link:hover {
    color: #4a0d73;
    text-decoration: underline;
}

.file-info {
    font-size: 0.85rem;
    color: #666;
    margin-top: 5px;
}

.error-msg {
    color: #d32f2f;
    background-color: #ffebee;
    padding: 12px;
    border-radius: 8px;
    margin-bottom: 20px;
    border-left: 4px solid #d32f2f;
}

.success-msg {
    color: #000000;
    background-color: #f0f0f0;
    padding: 12px;
    border-radius: 8px;
    margin-bottom: 20px;
    border-left: 4px solid #000000;
}

@media (max-width: 600px) {
    .form-container {
        padding: 25px;
    }
    
    .page-title {
        font-size: 2rem;
    }
}
</style>
</head>
<body>
    <h1 class="page-title">Share Your Travel Story</h1>
    
    <div class="form-container">
        <form action="upload.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Username or Email:</label>
                <input type="text" name="username" placeholder="Enter your username or email" required>
            </div>

            <div class="form-group">
                <label>Destination:</label>
                <input type="text" name="destination" required>
            </div>

            <div class="form-group">
                <label>Upload Image:</label>
                <input type="file" name="picture" accept="image/*" required>
            </div>

            <div class="form-group">
                <label>Your Story:</label>
                <textarea name="description" rows="10" required></textarea>
            </div>

            <?php if ($errorMsg) echo "<div class='error-msg'>$errorMsg</div>"; ?>
            <?php if ($successMsg) echo "<div class='success-msg'>$successMsg</div>"; ?>

            <button type="submit" class="submit-btn">Submit Story</button>
            
            <div class="signup-section">
                Don't have an account? <a href="signup.php">Sign up here</a>
                <div style="text-align:center; margin-top:15px;">
                <a href="index.php" style="color:#6a1b9a; font-weight:600; text-decoration:none;">
                 ← Return to Home
                </a>
            </div>

            </div>
        </form>
    </div>
</body>
</html>