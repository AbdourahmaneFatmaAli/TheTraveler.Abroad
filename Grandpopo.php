<?php 
session_start();
include 'config.php';

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$destination = 'Grandpopo';
$experience_id = null; 


if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $author = trim($_POST['author']);
    $email = trim($_POST['email']);
    $content = trim($_POST['content']);

    if ($author && $email && $content) {
        $stmt = $pdo->prepare("
    INSERT INTO comments (user_id, experience_id, destination, author, email, content) 
    VALUES (?, ?, ?, ?, ?, ?)
");

$stmt->execute([
    $user_id,
    $experience_id,
    $destination,
    $author,
    $email,
    $content
]);


header("Location: morondava.php");
    exit;
    
}
}
$stmt = $pdo->prepare("SELECT * FROM comments WHERE destination = ? ORDER BY created_at DESC");
$stmt->execute([$destination]);

$comments = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>grandpopo, Benin</title>
    


<style>
  body{
    font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
    background-color: white;
    color: black;
    text-align: center;
    margin: 0;
    padding: 20px;
  }

  img{
    width: 45%;
    height: 250px;
    object-fit: cover;
    border-radius: 8px;
    margin: 10px;
    

  }

  a {
    display: inline-block;
    margin-top: 20px;
    text-decoration: none;
    background: Orange;
    color: black;
    padding: 10px 20px;
    border-radius: 5px;
  }

  a:hover{
    background: darkorange;

  }
  
.comments-section {
    max-width: 700px;
    margin: 40px auto;
    padding: 20px;
    background: #f8f8f8;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

.comment-section-title {
    margin-bottom: 20px;
    font-size: 22px;
    font-weight: bold;
}


.comment-form {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-bottom: 30px;
}

.comment-form input,
.comment-form textarea {
    width: 100%;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 15px;
    font-family: inherit;
    background: white;
}

.comment-form input:focus,
.comment-form textarea:focus {
    border-color: orange;
    outline: none;
}

.comment-form button {
    padding: 12px;
    font-size: 16px;
    background: orange;
    color: black;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: bold;
}

.comment-form button:hover {
    background: darkorange;
}


.comment {
    background: white;
    padding: 15px 20px;
    border-radius: 8px;
    margin-bottom: 15px;
    text-align: left;
    border-left: 4px solid orange;
}

.comment p {
    margin: 5px 0;
    line-height: 1.5;
}

.comment strong {
    color: darkorange;
    font-size: 15px;
}

</style>

</head>
<body>
    <h1>Grand Popo, Benin</h1>
    <p>Grand Popo is interesting for its historical role
    as a major port during the transatlantic slave trade and its modern identity
    as a cultural hub with a strong connection to voodoo. 
    Today, it is known for its beautiful beaches, the "Mouth of the King" where 
    the Mono River meets the ocean, the Villa Karo cultural center, and its vibrant 
    fishing and cultural traditions, especially festivals like the Nonvitcha.  </p>
    
    <div>
        <img src="assets/coco-beach.jpg" alt="Grand Popo Coco beach">
        <p>Grand Popo Coco beach</p>
        <img src="assets/0548016001606546234.png" alt="Beach View">
        <p>Beach View</p>


    </div>

    <a href="index.php">Back to Home</a>

    
    <div class="comments-section">
      <h4 class="comment-section-title">Leave a comment</h4>
      <form class="comment-form" method="POST">
              <input type="text" name="author" placeholder="Your name" required>
              <input type="email" name="email" placeholder="Your Email" required>
              <textarea name="content" rows="3" placeholder="Share your thoughts..." required></textarea>
              <button type="submit">Post Comment</button>
      </form>

      <h2>Comments</h2>
  <?php if(count($comments) > 0): ?>
      <?php foreach($comments as $c): ?>
        <div class="comment">
          <p><strong><?= htmlspecialchars($c['author']) ?></strong> (<?= htmlspecialchars($c['email']) ?>) - <?= $c['created_at'] ?></p>
          <p><?= htmlspecialchars($c['content']) ?></p>
        </div>
      <?php endforeach; ?>
  <?php else: ?>
      <p>No comments yet. Be the first to comment!</p>
  <?php endif; ?>
</div>

</body>
</html>