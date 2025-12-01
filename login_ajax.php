<?php
session_start();
require_once 'config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
$remember_me = isset($_POST['remember_me']);

if (empty($username) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Please fill in all fields']);
    exit;
}

try {
    // Check user credentials
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$username, $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user && password_verify($password, $user['password'])) {
        // Check if user is active
        if ($user['status'] !== 'active') {
            echo json_encode(['success' => false, 'message' => 'Your account is not active. Please contact administrator.']);
            exit;
        }
        
        // Set session variables
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];
        
        // Set remember me cookie if requested
        if ($remember_me) {
            $token = bin2hex(random_bytes(32));
            $expiry = time() + (30 * 24 * 60 * 60); // 30 days
            
            // Store token in database
            $stmt = $pdo->prepare("UPDATE users SET remember_token = ?, token_expiry = ? WHERE user_id = ?");
            $stmt->execute([$token, date('Y-m-d H:i:s', $expiry), $user['user_id']]);
            
            // Set cookie
            setcookie('remember_me', $token, $expiry, '/');
            setcookie('remembered_username', $user['username'], $expiry, '/');
        }
        
        // Determine redirect URL based on role
        $redirect = $user['role'] === 'admin' ? 'admin_dashboard.php' : 'dashboard.php';
        
        echo json_encode([
            'success' => true, 
            'message' => 'Login successful!', 
            'redirect' => $redirect
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid username or password']);
    }
} catch (PDOException $e) {
    error_log("Login error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'An error occurred. Please try again.']);
}
?>