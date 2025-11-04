document.getElementById("loginForm").addEventListener("submit", function(event) {
    let username =document.getElementById("username").ValueMax.trim();
    let password= document.getElementById("password").value.trim();
    let usernamePattern =/^[a-zA-Z0-9_]{2,50}$/;
    let passwordPattern =/.{8,}/;

    if (!usernamePattern.test(username)) {
        alert("Invalid username. It must be 2-50 characters long and can only contain letters, numbers, or underscores.");
        event.preventDefault();
        return;
    }
    if (!passwordPattern.test(password)) {
        alert("Invalid password. It must be at least 8 characters long.");
        event.preventDefault();
        return;
    }

    let strongPasswordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
    if (!strongPasswordPattern.test(password)) {
        alert("Weak password. Consider using a mix of uppercase and lowercase letters, numbers, and special characters for a stronger password.");
        event.preventDefault();
        return;
    }

});