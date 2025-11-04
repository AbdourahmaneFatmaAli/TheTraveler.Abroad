document.getElementById("signupForm").addEventListener("submit", function(event) {
    event.preventDefault();
    let firstName = document.getElementById("firstName").value.trim();
    let lastName = document.getElementById("lastName").value.trim();
    let email = document.getElementById("email").value.trim();
    let username = document.getElementById("userName").value.trim();
    let password = document.getElementById("password").value.trim();
    let confirmPassword = document.getElementById("confirmpassword").value.trim();
    let role = document.getElementById("role").value.trim();
    let emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    let usernamePattern=/^[a-zA-Z0-9_]{4,30}$/;

    if(firstName==="" || lastName===""){
        alert("First Name and Last Name cannot be empty.");
        return;
    }
    if(!emailPattern.test(email)){
        alert("you entered an invalid email address.");
        return;
    }
    if(!usernamePattern.test(username)){
        alert("Invalid username. It must be 4-30 characters long and can only contain letters, numbers, or underscores.");
        return;
    }

    if(password.length<8){
        alert("Invalid password. It must be at least 8 characters long.");
        return;
    }

    if(role===""){
        alert("Please select your role.");
        return;
    }
    if(password !== confirmPassword){
        alert("Passwords do not match.");
        return;
    }

    alert("Signup successful!");
    this.submit();
});