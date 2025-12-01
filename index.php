<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
    href="https://cdn.jsdelivr.net/npm/remixicon@4.7.0/fonts/remixicon.css"
    rel="stylesheet"/>
    <link rel="stylesheet" href="style.css?v=123">
    <title>TheTraveler.Abroad Home Page</title>
    
   
</head>
<body>
<?php session_start(); ?>
    <nav>
        
        <ul class="nav_links">
            <li class="link"><a href="index.php">Home</a></li>
            <li class="link"><a href="about_project.html">About</a></li>
            <li class="link"><a href="Architecture.html">Architechture</a></li>
            <li class="link"><a href="login.php">Login</a></li>
            <li class="link"><a href="signup.php">Sign Up</a></li> 
            <li class="link"><a href="upload.php">Upload</a></li>
            <li class="link"><a href="Members.html">Members</a></li>
            <li class="link"><a href="functionality.html">RemainingFunctionalitis</a></li>
			

			<?php if (isset($_SESSION['user_id'])): ?>
            	<?php
                	include 'config.php';
                	$stmt = $pdo->prepare("SELECT first_name FROM users WHERE user_id = ?");
                	$stmt->execute([$_SESSION['user_id']]);
                	$user = $stmt->fetch();
            	?>
            	<li class="link"><a href="profile.php"><?= htmlspecialchars($user['first_name']) ?>'s Profile</a></li>
            	<li class="link"><a href="logout.php">Logout</a></li>
        	<?php else: ?>
            	<li class="link"><a href="login.php">Login</a></li>
            	<li class="link"><a href="signup.php">Sign Up</a></li>
        	<?php endif; ?>  

        </ul>
    </nav>
    <header>
        <div class="section_container">
            <div class="header_content">
                <h1>TheTraveler.Abroad</h1>
                <p>Ambark on a journey of lifetime and explore the Africa's 
                most breathtaking destinations and have the chance to share 
                your souvenirs with us..
                </p>
                
                </div>
        </div>
    
    
    </header>
    <div class="journey_container">
       <div class="section_container"></div>
         <h2 class="section_title">Start exploring</h2>
         <p class="section_subtitle">Some destinations shared by the site owners</p>
        <div class="journey_g">
         <div class="destination-wrapper">
            <a href="morondava.php" class="country_card">
              <img src="assets/Morondava2.png" alt="country">
              <div class="country_name">
                <i class="ri-map-pin-fill"></i>
                <span> Morondava, Madagascar</span>
              </div>
            </a>
		 </div>
       
            
          
            
          
          
          <div class="destination-wrapper">
            <a href="Agadez.php" class="country_card">
              <img src="assets/7301697.jpg" alt="country">
              <div class="country_name">
                <i class="ri-map-pin-fill"></i>
                <span> Agadez, Niger</span>
              </div>
            </a>
          </div>
        
          <div class="destination-wrapper">
            <a href="Grandpopo.php" class="country_card">
              <img src="assets/BENIN-shutterstock1254490039.avif" alt="country">
              <div class="country_name">
                <i class="ri-map-pin-fill"></i>
                <span> Grand Popo, Benin</span>
              </div>
            </a>
          </div>
            
        

          <div class="destination-wrapper">
            <a href="Gizeh.php" class="country_card"> 
              <img src="assets/visiter-egypte-800-01-696x377.jpg" alt="country">
              <div class="country_name">
                <i class="ri-map-pin-fill"></i>
                <span> Gizeh, Egypt</span>
              </div>
            </a>
          </div>
        
          
          <div class="destination-wrapper">
            <a href="algiers.php" class="country_card">
              <img src="assets/The-Capital-of-Algeria-Algiers.avif" alt="country">
              <div class="country_name">
                <i class="ri-map-pin-fill"></i>
                <span> Algiers, Algeria</span>
              </div>
            </a>
          </div>  


          <div class="destination-wrapper">
            <a href="Ethiopia.php" class="country_card">
              <img src="assets/Ethiopia.jpeg" alt="country">
              <div class="country_name">
                <i class="ri-map-pin-fill"></i>
                <span> Jinka, Ethiopia</span>
              </div> 
			</a>
          </div>
      
        </div>


      

    </div>
    <section id='shared_experiences' style="margin-top: 50px;">
    <h2 class="section_title">Shared Experiences by Users</h2>
    <p class="section_subtitle">See recent travel stories submitted by our community</p>

    <?php if (isset($_GET['success']) && $_GET['success'] == '1'): ?>
        <div style="background-color: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin: 20px 0; text-align: center;">
            Your travel story has been shared successfully!
        </div>
    <?php endif; ?>

    <div class='journey_g' id='user-experiences'>
        <?php
        include 'config.php';
        
        try {
            $stmt = $pdo->query("
   				SELECT e.experience_id, e.user_id, e.first_name, e.email, 
          		e.destination, e.description, ei.image_url
    			FROM experiences e
    			LEFT JOIN experience_images ei 
    			ON e.experience_id = ei.experience_id
    			ORDER BY e.experience_id DESC
			");

            $experiences = $stmt->fetchAll();

            if (count($experiences) > 0) {
                foreach ($experiences as $exp) {
                    echo "
                    <div class='destination-wrapper'>
                        <div class='country_card'>
                            <img src='{$exp['image_url']}' alt='{$exp['destination']}'>
                            <div class='country_name'>
                                <i class='ri-map-pin-fill'></i>
                                <span>{$exp['destination']}</span>
                            </div>
                            <div style='padding: 1rem;'>
                                <p><strong>Shared by:</strong> {$exp['first_name']} ({$exp['email']})</p>
                                <p>{$exp['description']}</p>
                      ";

                if (isset($_SESSION['user_id']) && $exp['user_id'] == $_SESSION['user_id']) {
                    echo "
                    <form action='delete_story.php' method='POST'>
                        <input type='hidden' name='experience_id' value='{$exp['experience_id']}'>
                        <button type='submit' class='delete-btn'>Delete</button>
                    </form>";
                }

                
                      
                
			}
            } else {
    			echo '<p style="text-align: center; margin-left: 350px; margin-top: 0px; font-weight: bold; color: black; width:100%">No experiences shared yet.</p>';
			}

                
        	} catch (PDOException $e) {
    		echo "<p>Error: " . $e->getMessage() . "</p>";
			}

          
    	

        
        ?>
    </div>
</section>
</body>
</html>

