document.getElementById("signup-form").addEventListener("submit", function(event) {
    event.preventDefault();

    const username = document.getElementById("username").value.trim();
    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value.trim();
    const confirmPassword = document.getElementById("confirm-password").value.trim();
    const first_name =document.getElementById("first_name").value.trim();
    const last_name =document.getElementById("last_name").value.trim();

    const usernamePattern = /^[a-zA-Z0-9._]+$/;

    //validation

    if(username === "" || email === "" || password === "" || confirmPassword === ""  || first_name ==="" || last_name==="") {
        alert("Please fill in all fields.");
        return;
    }
    
    if(username.length < 4 || username.length >30){
        alert("Username must be between 4 and 30 characters long.");
        return;
    }

    if(!usernamePattern.test(username)) {
        alert("Username can only contain letters, numbers,dots,  and underscores.");
        return;     
    }

    if(password.length < 8) {
        alert("Password must be at least 8 characters long.");
        return;
    }

    if(password !== confirmPassword) {
        alert("Password and confirm password must match.");
        return;
    }

    //save user to localStorage

    const user = { username, email, password, role };
    localStorage.setItem("user", JSON.stringify(user));

    alert("Signup successful!");
    window.location.href = "login.html";

    
});