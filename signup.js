function validation() {
    var username = document.forms["formfill"]["user_name"].value;
    var password = document.forms["formfill"]["password"].value;
    var confirm = document.forms["formfill"]["confirm"].value;
    var resultElement = document.getElementById("result");
    
    if (username === "") {
        resultElement.innerHTML = "Enter your Username";
        return false;
    } else if (username.length < 6) {
        resultElement.innerHTML = "Enter at least 6 letters for the username";
        return false;
    } else if (password === "") {
        resultElement.innerHTML = "Enter password";
        return false;
    } else if (password.length < 6) {
        resultElement.innerHTML = "Password must be at least 6 characters long";
        return false;
    } else if (password !== confirm) {
        resultElement.innerHTML = "Passwords do not match";
        return false;
    }
}