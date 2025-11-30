<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
    href="https://cdn.jsdelivr.net/npm/remixicon@4.7.0/fonts/remixicon.css"
    rel="stylesheet"/>
    <link rel="stylesheet" href="style.css">
    <title>TheTraveler.Abroad Home Page</title>
    
   
</head>
<body>
    <nav>
        
        <ul class="nav_links">
            <li class="link"><a href="index.html">Home</a></li>
            <li class="link"><a href="about_project.html">About</a></li>
            <li class="link"><a href="architecture.html">Architechture</a></li>
            <li class="link"><a href="login.php">Login</a></li>
            <li class="link"><a href="signup.php">Sign Up</a></li> 
            <li class="link"><a href="upload.php">Upload</a></li>
            <li class="link"><a href="Members.html">Members</a></li>
            <li class="link"><a href="functionality.html">RemainingFunctionalitis</a></li>
         

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
            <a href="morondava.html" class="country_card">
              <img src="assets/Morondava2.png" alt="country">
              <div class="country_name">
                <i class="ri-map-pin-fill"></i>
                <span> Morondava, Madagascar</span>
              </div>
            </a>
              <div class="comment">
                <h4 class="comment-section-title">Leave a comment</h4>
                <form onsubmit="handleCommentSubmit(event)">
                  <input type="hidden" name="destination_id" value="1">
                  <input type="hidden" name="type" value="featured">

                  <div class="form-group">
                    <input type="text" name="author" required placeholder="Your name" class="comment-input">
                  </div>
                  <div class="form-group">
                    <input type="email" name="email" required placeholder="Your Email" class="comment-input">
                  </div> 

                  <div class="form-group">
                    <textarea name="content" rows="2" required placeholder="Share your thoughts..." class="comment-input"></textarea>
                  </div>

                  <button type="submit" class="submit-btn">Post Comment</button>
                  
          
                </form>
              </div>
         </div>
            
          
            
          
          
          <div class="destination-wrapper">
            <a href="Agadez.html" class="country_card">
              <img src="assets/7301697.jpg" alt="country">
              <div class="country_name">
                <i class="ri-map-pin-fill"></i>
                <span> Agadez, Niger</span>
               </div>
            </a>
            <div class="comment">
                <h4 class="comment-section-title">Leave a comment</h4>
                <form onsubmit="handleCommentSubmit(event)">
                  <input type="hidden" name="destination_id" value="1">
                  <input type="hidden" name="type" value="featured">

                  <div class="form-group">
                    <input type="text" name="author" required placeholder="Your name" class="comment-input">
                  </div>
                  <div class="form-group">
                    <input type="email" name="email" required placeholder="Your Email" class="comment-input">
                  </div> 

                  <div class="form-group">
                    <textarea name="content" rows="2" required placeholder="Share your thoughts..." class="comment-input"></textarea>
                  </div>

                  <button type="submit" class="submit-btn">Post Comment</button>
          
                </form>
              </div>
          </div>
        
          <div class="destination-wrapper">
            <a href="grandpopo.html" class="country_card">
              <img src="assets/BENIN-shutterstock1254490039.avif" alt="country">
              <div class="country_name">
                <i class="ri-map-pin-fill"></i>
                <span> Grand Popo, Benin</span>
              </div>
            </a>
            <div class="comment">
                <h4 class="comment-section-title">Leave a comment</h4>
                <form onsubmit="handleCommentSubmit(event)">
                  <input type="hidden" name="destination_id" value="1">
                  <input type="hidden" name="type" value="featured">

                  <div class="form-group">
                    <input type="text" name="author" required placeholder="Your name" class="comment-input">
                  </div>
                  <div class="form-group">
                    <input type="email" name="email" required placeholder="Your Email" class="comment-input">
                  </div> 

                  <div class="form-group">
                    <textarea name="content" rows="2" required placeholder="Share your thoughts..." class="comment-input"></textarea>
                  </div>

                  <button type="submit" class="submit-btn">Post Comment</button>
                  
          
                </form>
              </div>
            
          </div>

          <div class="destination-wrapper">
            <a href="gizeh.html" class="country_card"> 
              <img src="assets/visiter-egypte-800-01-696x377.jpg" alt="country">
              <div class="country_name">
                <i class="ri-map-pin-fill"></i>
                <span> Gizeh, Egypt</span>
              </div>
            </a>
            <div class="comment">
                <h4 class="comment-section-title">Leave a comment</h4>
                <form onsubmit="handleCommentSubmit(event)">
                  <input type="hidden" name="destination_id" value="1">
                  <input type="hidden" name="type" value="featured">

                  <div class="form-group">
                    <input type="text" name="author" required placeholder="Your name" class="comment-input">
                  </div>
                  <div class="form-group">
                    <input type="email" name="email" required placeholder="Your Email" class="comment-input">
                  </div> 

                  <div class="form-group">
                    <textarea name="content" rows="2" required placeholder="Share your thoughts..." class="comment-input"></textarea>
                  </div>

                  <button type="submit" class="submit-btn">Post Comment</button>
                  
          
                </form>
              </div>
          </div> 
          
          <div class="destination-wrapper">
            <a href="algiers.html" class="country_card">
              <img src="assets/The-Capital-of-Algeria-Algiers.avif" alt="country">
              <div class="country_name">
                <i class="ri-map-pin-fill"></i>
                <span> Algiers, Algeria</span>
              </div>
            </a>
            <div class="comment">
                <h4 class="comment-section-title">Leave a comment</h4>
                <form onsubmit="handleCommentSubmit(event)">
                  <input type="hidden" name="destination_id" value="1">
                  <input type="hidden" name="type" value="featured">

                  <div class="form-group">
                    <input type="text" name="author" required placeholder="Your name" class="comment-input">
                  </div>
                  <div class="form-group">
                    <input type="email" name="email" required placeholder="Your Email" class="comment-input">
                  </div> 

                  <div class="form-group">
                    <textarea name="content" rows="2" required placeholder="Share your thoughts..." class="comment-input"></textarea>
                  </div>

                  <button type="submit" class="submit-btn">Post Comment</button>
                  
          
                </form>
              </div>
          </div>  


          <div class="destination-wrapper">
            <a href="Ethiopia.html" class="country_card">
              <img src="assets/Ethiopia.jpeg" alt="country">
              <div class="country_name">
                <i class="ri-map-pin-fill"></i>
                <span> Jinka, Ethiopia</span>
              </div> 
            </a>
            <div class="comment">
                <h4 class="comment-section-title">Leave a comment</h4>
                <form onsubmit="handleCommentSubmit(event)">
                  <input type="hidden" name="destination_id" value="1">
                  <input type="hidden" name="type" value="featured">

                  <div class="form-group">
                    <input type="text" name="author" required placeholder="Your name" class="comment-input">
                  </div>
                  <div class="form-group">
                    <input type="email" name="email" required placeholder="Your Email" class="comment-input">
                  </div> 

                  <div class="form-group">
                    <textarea name="content" rows="2" required placeholder="Share your thoughts..." class="comment-input"></textarea>
                  </div>

                  <button type="submit" class="submit-btn">Post Comment</button>
                 
          
                </form>
              </div>
           
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
                SELECT e.first_name, e.email, e.destination, e.description, ei.image_url
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
                    <form action='delete_story.php' method='POST' style='margin-top:10px;'>
                        <input type='hidden' name='experience_id' value='{$exp['experience_id']}'>
                        <button type='submit' class='delete-btn'>Delete</button>
                    </form>";
                }

                echo "
                        </div>
                    </div>
                </div>";
                }
            } else {
                echo "<p style='text-align:center;width:100%;'>No travel experiences yet. <a href='upload.php'>Share yours!</a></p>";
            }
        } catch (PDOException $e) {
            echo "<p style='color:red;text-align:center;'>Error loading experiences: " . $e->getMessage() . "</p>";
        }
        ?>
    </div>
</section>
</body>
</html>











