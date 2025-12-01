document.getElementById("login-form").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent form submission

    // Get form values
    const username = document.getElementById("username").value.trim();
    const password = document.getElementById("password").value.trim();

    const stored_user =JSON.parse(localStorage.getItem("user"));

    if(!stored_user){
        alert("No registered user found. Please sign up first.");
        return;
    }

    
    if(username !== stored_user.username || password !== stored_user.password){
            alert("Invalid username or password.");
            return;
    }
    

    const usernamePattern = /^[a-zA-Z0-9._]+$/; 
    

    if(username === "" || password === "") {
        alert("Please fill in all fields.");
        return;
    }

    if(!usernamePattern.test(username)) {
        alert("Username must be 4-30 characters long and can only contain letters, numbers, dots, and underscores.");
        return;     
    }

    if(username.length < 4 || username.length > 30) {
        alert("Username must be between 4 and 30 characters long.");
        return;
    }
    

    if(password.length < 8) {
        alert("Password must be at least 8 characters long.");
        return;
    }


    alert("Login successful!");
        window.location.href = "index.html";
    
   

   
});



