<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en-US">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale = 1.0">
        <link rel="stylesheet" href="styles.css">
        <title>SignUp page</title>
    </head>
        <body class="signup-page">
            <h2>Sign Up </h2>
            <div class ="signup-container">
   
                <?php if (isset($_SESSION['signup_success'])): ?>
                    <div style='color: green; margin-bottom: 15px;'>
                        <?php 
                        echo $_SESSION['signup_success'];
                        unset($_SESSION['signup_success']);
                        ?>
                    </div>

                <?php endif; ?>

                <?php if (isset($_SESSION['signup_error'])): ?>
                    <div style='color: red; margin-bottom: 15px;'>
                        <?php 
                        echo $_SESSION['signup_error'];
                        unset($_SESSION['signup_error']);
                        ?>
                    </div>

                <?php endif; ?>



                <form action="process_signup.php" method="POST">


                    <!--username-->

                   <label for="username"> Username: </label>
                   <input type="text" id ="username" name="username" placeholder="Enter Username" required>

                    <!--email-->
                    <label for="email">Email: </label>
                    <input type="email" id="email" name="email"  placeholder="Enter your eamil" required>
                    <!--password-->
                     <label for="password">Password: </label>
                    <input type="password" id="password" name="password" 
                    pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&.])[A-Za-z\d@$!%*?&.]{8,}$"
                    title="Password must be at least 8 characters long and include uppercase, lowercase, a number, and a special character."
                    placeholder="Enter your password" required>
                    <!--confirm password-->
                    <label for="confirm-password">confirm Password: </label>
                    <input type="password" id="confirm-password" name="confirm-password" placeholder="confirm password" required>
                    <!--first_name and last_name-->

                    <label for="first_name">First Name</label>
                    <input type="text" name="first_name"  id="first_name"  placeholder="First Name" required>

                    <label for="last_name">Last Name</label>
                    <input type="text" name="last_name"  id="last_name"  placeholder="Last Name" required>

                
                    <button type ="submit">Sign up</button>

                    <p style="color:white; font-weight: bold;">
                        Already have an account? <a href="login.php">Login here</a>
                    </p>

                </form>
            </div>

           


                    

        </body>

</html>


