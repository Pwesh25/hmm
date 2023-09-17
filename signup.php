<?php
session_start();

include("connection.php");
include("functions.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Something was posted
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    if (!empty($user_name) && !empty($password) && !is_numeric($user_name)) {

        // Check if the username already exists
        $query = "SELECT * FROM users WHERE user_name = '$user_name' LIMIT 1";
        $result = mysqli_query($con, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $error_message = "Username already exists.choose a different one.";
        } else {
            // Save the user to the database
            $user_id = random_num(20);
            $query = "INSERT INTO users (user_id, user_name, password, email, phone) VALUES ('$user_id', '$user_name', '$password', '$email', '$phone')";

            mysqli_query($con, $query);

            header("Location: login.php");
            die;
        }
    } else {
        $error_message = "Please enter valid information.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>signup</title>
    <link rel="stylesheet" href="signup.css"/>
    <link href="css/bootstrap.min.css" rel="stylesheet"/>
    <script src="js/bootstrap.bundle.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <style>
        /* CSS styles for the signup page */
        .error-message {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-box">
            <form method="post" name="formfill" onsubmit="return validation()">
                <h2>Register</h2>
                <?php
                if (isset($error_message)) {
                    echo '<p class="error-message">' . $error_message . '</p>';
                }
                ?>
                <!-- Add the following element to display error messages -->
                <p id="result"></p>
                <div class="input-box">
                    <i class='bx bxs-user'></i>
                    <input type="text" name="user_name" placeholder="Username" required>
                </div>
                <div class="input-box">
                    <i class='bx bx-envelope'></i>
                    <input type="email" name="email" placeholder="Email" required>
                </div>
                <div class="input-box">
                    <i class='bx bxs-contact' ></i>
                    <input type="text" name="phone" placeholder="Phone number" required>
                </div>
                <div class="input-box">
                    <i class='bx bxs-lock-alt' ></i>
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <div class="input-box">
                    <i class='bx bxs-lock-alt' ></i>
                    <input type="password" name="confirm" placeholder="Confirm password" required>
                </div>
                <div class="button">
                    <input type="submit" class="btn" value="Register">
                </div>   
                <div class="group">
                    <span><a href="forget.php">Forget-Password</a></span>
                    <span><a href="login.php">Login</a></span>
                </div>
            </form>
        </div>
    </div>
    <script src="signup.js"></script> 
</body>
</html>
