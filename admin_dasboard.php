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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Travel Website</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #3498db;
            --admin: #e74c3c;
            --success: #27ae60;
            --warning: #f39c12;
            --dark: #2c3e50;
            --light: #ecf0f1;
            --gray: #95a5a6;
            --sidebar-width: 250px;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: #f5f7fa;
            color: #333;
        }
        
        .admin-dashboard {
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--dark);
            color: white;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            transition: all 0.3s;
            z-index: 1000;
        }
        
        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid #34495e;
            text-align: center;
        }
        
        .sidebar-header h2 {
            margin-bottom: 5px;
            color: white;
        }
        
        .sidebar-menu {
            list-style: none;
            margin-top: 20px;
        }
        
        .sidebar-menu li a {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            color: var(--light);
            text-decoration: none;
            transition: all 0.3s;
            border-left: 4px solid transparent;
        }
        
        .sidebar-menu li a i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        .sidebar-menu li a:hover,
        .sidebar-menu li a.active {
            background: rgba(255, 255, 255, 0.1);
            border-left: 4px solid var(--admin);
        }
        
        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            padding: 20px;
            transition: all 0.3s;
        }
        
        .header {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .header h1 {
            color: var(--dark);
            margin-bottom: 5px;
        }
        
        .header p {
            color: var(--gray);
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }
        
        /* Stats Cards */
        .stats-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            transition: transform 0.3s;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 24px;
        }
        
        .stat-icon.users {
            background: rgba(52, 152, 219, 0.2);
            color: var(--primary);
        }
        
        .stat-icon.destinations {
            background: rgba(46, 204, 113, 0.2);
            color: var(--success);
        }
        
        .stat-icon.experiences {
            background: rgba(155, 89, 182, 0.2);
            color: #9b59b6;
        }
        
        .stat-icon.pending {
            background: rgba(241, 196, 15, 0.2);
            color: var(--warning);
        }
        
        .stat-info h3 {
            color: var(--gray);
            font-size: 14px;
            margin-bottom: 5px;
        }
        
        .stat-number {
            font-size: 24px;
            font-weight: bold;
            color: var(--dark);
        }
        
        /* Content Sections */
        .content-section {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        
        .section-header h2 {
            color: var(--dark);
        }
        
        .section-actions {
            display: flex;
            gap: 10px;
        }
        
        .btn {
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            text-decoration: none;
        }
        
        .btn-primary {
            background: var(--primary);
            color: white;
        }
        
        .btn-success {
            background: var(--success);
            color: white;
        }
        
        .btn-warning {
            background: var(--warning);
            color: white;
        }
        
        .btn-danger {
            background: var(--admin);
            color: white;
        }
        
        .btn:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }
        
        /* Tables */
        .table-container {
            overflow-x: auto;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        table th, table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        
        table th {
            background: #f8f9fa;
            color: var(--dark);
            font-weight: 600;
        }
        
        table tr:hover {
            background: #f8f9fa;
        }
        
        .action-buttons {
            display: flex;
            gap: 5px;
        }
        
        .action-btn {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 12px;
        }
        
        /* Forms */
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }
        
        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }
        
        select.form-control {
            height: 40px;
        }
        
        /* Tabs */
        .tabs {
            display: flex;
            border-bottom: 1px solid #eee;
            margin-bottom: 20px;
        }
        
        .tab {
            padding: 10px 20px;
            cursor: pointer;
            border-bottom: 3px solid transparent;
        }
        
        .tab.active {
            border-bottom: 3px solid var(--admin);
            color: var(--admin);
            font-weight: 500;
        }
        
        .tab-content {
            display: none;
        }
        
        .tab-content.active {
            display: block;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 70px;
                text-align: center;
            }
            
            .sidebar-header h2, 
            .sidebar-menu li a span {
                display: none;
            }
            
            .sidebar-menu li a i {
                margin-right: 0;
                font-size: 20px;
            }
            
            .main-content {
                margin-left: 70px;
            }
            
            .stats-cards {
                grid-template-columns: 1fr;
            }
            
            .section-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="admin-dashboard">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <h2>Admin Panel</h2>
                <p>Travel Website</p>
            </div>
            <ul class="sidebar-menu">
                <li><a href="#" class="active"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a></li>
                <li><a href="#user-management"><i class="fas fa-users"></i> <span>User Management</span></a></li>
                <li><a href="#content-management"><i class="fas fa-map-marked-alt"></i> <span>Content Management</span></a></li>
                <li><a href="#system-settings"><i class="fas fa-cog"></i> <span>System Settings</span></a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a></li>
            </ul>
        </div>
        
        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <div>
                    <h1>Admin Dashboard</h1>
                    <p>Welcome back, <?php echo htmlspecialchars($_SESSION['username'] ?? 'Administrator'); ?>! Here's what's happening with your website today.</p>
                </div>
                <div class="user-info">
                    <div class="user-avatar"><?php echo strtoupper(substr($_SESSION['username'] ?? 'A', 0, 1)); ?></div>
                    <div>
                        <div><?php echo htmlspecialchars($_SESSION['username'] ?? 'Administrator'); ?></div>
                        <div style="font-size: 12px; color: var(--gray);"><?php echo htmlspecialchars($_SESSION['email'] ?? 'admin@travelsite.com'); ?></div>
                    </div>
                </div>
            </div>
            
            <!-- Stats Cards -->
            <div class="stats-cards">
                <div class="stat-card">
                    <div class="stat-icon users">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-info">
                        <h3>TOTAL USERS</h3>
                        <div class="stat-number"><?php echo $total_users; ?></div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon destinations">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="stat-info">
                        <h3>DESTINATIONS</h3>
                        <div class="stat-number"><?php echo $total_destinations; ?></div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon experiences">
                        <i class="fas fa-images"></i>
                    </div>
                    <div class="stat-info">
                        <h3>EXPERIENCES</h3>
                        <div class="stat-number"><?php echo $total_experiences; ?></div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon pending">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-info">
                        <h3>PENDING APPROVALS</h3>
                        <div class="stat-number"><?php echo $pending_users; ?></div>
                    </div>
                </div>
            </div>
            
            <!-- User Management Section -->
            <div class="content-section" id="user-management">
                <div class="section-header">
                    <h2><i class="fas fa-users"></i> User Management</h2>
                    <div class="section-actions">
                        <a href="add_user.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add User</a>
                    </div>
                </div>
                
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Name</th>
                                <th>Role</th>
                                <th>Joined</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($users)): ?>
                                <tr>
                                    <td colspan="7" style="text-align: center;">No users found</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?php echo $user['user_id']; ?></td>
                                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                                    <td><?php echo htmlspecialchars(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? '')); ?></td>
                                    <td>
                                        <form method="POST" style="display: inline;">
                                            <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                                            <select name="role" onchange="this.form.submit()" style="padding: 5px; border: 1px solid #ddd; border-radius: 5px;">
                                                <option value="visitor" <?php echo ($user['role'] ?? '') == 'visitor' ? 'selected' : ''; ?>>Visitor</option>
                                                <option value="contributor" <?php echo ($user['role'] ?? '') == 'contributor' ? 'selected' : ''; ?>>Contributor</option>
                                                <option value="admin" <?php echo ($user['role'] ?? '') == 'admin' ? 'selected' : ''; ?>>Admin</option>
                                            </select>
                                            <input type="hidden" name="update_role" value="1">
                                        </form>
                                    </td>
                                    <td><?php echo date('Y-m-d', strtotime($user['created_at'])); ?></td>
                                    <td>
                                        <div class="action-buttons">
                                            <form method="POST" style="display: inline;">
                                                <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                                                <button type="submit" name="delete_user" class="action-btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Content Management Section -->
            <div class="content-section" id="content-management">
                <div class="section-header">
                    <h2><i class="fas fa-map-marked-alt"></i> Content Management</h2>
                    <div class="section-actions">
                        <a href="add_destination.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add Destination</a>
                    </div>
                </div>
                
                <div class="tabs">
                    <div class="tab active" data-tab="destinations">Destinations</div>
                    <div class="tab" data-tab="experiences">Travel Experiences</div>
                </div>
                
                <div class="tab-content active" id="destinations">
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Destination Name</th>
                                    <th>Description</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($destinations)): ?>
                                    <tr>
                                        <td colspan="5" style="text-align: center;">No destinations found</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($destinations as $destination): ?>
                                    <tr>
                                        <td><?php echo $destination['destination_id']; ?></td>
                                        <td><?php echo htmlspecialchars($destination['name']); ?></td>
                                        <td><?php echo htmlspecialchars(substr($destination['description'] ?? '', 0, 100)) . '...'; ?></td>
                                        <td><?php echo date('Y-m-d', strtotime($destination['created_at'])); ?></td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="edit_destination.php?id=<?php echo $destination['destination_id']; ?>" class="action-btn btn-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form method="POST" style="display: inline;">
                                                    <input type="hidden" name="destination_id" value="<?php echo $destination['destination_id']; ?>">
                                                    <button type="submit" name="delete_destination" class="action-btn btn-danger" onclick="return confirm('Are you sure you want to delete this destination?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="tab-content" id="experiences">
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>First Name</th>
                                    <th>Email</th>
                                    <th>Destination</th>
                                    <th>Description</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($experiences)): ?>
                                    <tr>
                                        <td colspan="7" style="text-align: center;">No experiences found</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($experiences as $experience): ?>
                                    <tr>
                                        <td><?php echo $experience['experience_id']; ?></td>
                                        <td><?php echo htmlspecialchars($experience['first_name']); ?></td>
                                        <td><?php echo htmlspecialchars($experience['email']); ?></td>
                                        <td><?php echo htmlspecialchars($experience['destination']); ?></td>
                                        <td><?php echo htmlspecialchars(substr($experience['description'] ?? '', 0, 100)) . '...'; ?></td>
                                        <td><?php echo date('Y-m-d', strtotime($experience['created_at'])); ?></td>
                                        <td>
                                            <div class="action-buttons">
                                                <form method="POST" style="display: inline;">
                                                    <input type="hidden" name="experience_id" value="<?php echo $experience['experience_id']; ?>">
                                                    <button type="submit" name="delete_experience" class="action-btn btn-danger" onclick="return confirm('Are you sure you want to delete this experience?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- System Settings Section -->
            <div class="content-section" id="system-settings">
                <div class="section-header">
                    <h2><i class="fas fa-cog"></i> System Settings</h2>
                </div>
                
                <form method="POST" action="update_settings.php">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div>
                            <h3 style="margin-bottom: 15px;">General Settings</h3>
                            <div class="form-group">
                                <label>Site Name</label>
                                <input type="text" name="site_name" class="form-control" value="Travel Explorer">
                            </div>
                            <div class="form-group">
                                <label>Site Description</label>
                                <textarea name="site_description" class="form-control" style="height: 100px;">Share your travel experiences with the world</textarea>
                            </div>
                            <button type="submit" class="btn btn-success">Save Settings</button>
                        </div>
                        
                        <div>
                            <h3 style="margin-bottom: 15px;">User Registration</h3>
                            <div class="form-group">
                                <label style="display: flex; align-items: center; gap: 10px;">
                                    <input type="checkbox" name="allow_registration" checked>
                                    <span>Allow new user registrations</span>
                                </label>
                            </div>
                            <div class="form-group">
                                <label style="display: flex; align-items: center; gap: 10px;">
                                    <input type="checkbox" name="require_approval">
                                    <span>Require admin approval for new contributors</span>
                                </label>
                            </div>
                            <div class="form-group">
                                <label>Default User Role</label>
                                <select name="default_role" class="form-control">
                                    <option value="visitor">Visitor</option>
                                    <option value="contributor">Contributor</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Tab functionality
        document.querySelectorAll('.tab').forEach(tab => {
            tab.addEventListener('click', () => {
                // Remove active class from all tabs and contents
                document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
                
                // Add active class to clicked tab
                tab.classList.add('active');
                
                // Show corresponding content
                const tabId = tab.getAttribute('data-tab');
                document.getElementById(tabId).classList.add('active');
            });
        });
        
        // Smooth scrolling for sidebar links
        document.querySelectorAll('.sidebar-menu a').forEach(link => {
            link.addEventListener('click', function(e) {
                if (this.getAttribute('href').startsWith('#')) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href').substring(1);
                    const targetElement = document.getElementById(targetId);
                    if (targetElement) {
                        targetElement.scrollIntoView({ behavior: 'smooth' });
                    }
                }
            });
        });
    </script>
</body>
</html>