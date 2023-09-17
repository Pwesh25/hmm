<?php
    session_start();
    include("connection.php");
    include("functions.php");

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $user_name = $_POST['user_name'];
        $query = "SELECT * FROM users WHERE user_name = '$user_name' LIMIT 1";
        $result = mysqli_query($con, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);
            $password = $user_data['password'];
            // Send the password to the user's email
            // You can use a library like PHPMailer to send emails

            // Example using PHP's built-in mail function (requires a configured mail server):
            $to = $user_data['email'];
            $subject = "Password Recovery";
            $message = "Your password is: $password";
            $headers = "From: your_email@example.com";
            mail($to, $subject, $message, $headers);

            // Display success message
            $error_message = '<p style="color: green;">Your password has been sent to your email address.</p>';
        } else {
            // User not found
            $error_message = '<p style="color: red;">User not found. Please check your username.</p>';
        }
    }
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="signup.css"/>
    <link href="css/bootstrap.min.css" rel="stylesheet"/>
    <script src="js/bootstrap.bundle.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <title>Forget Password</title>
</head>
<body>
<div class="container">
    <div class="form-box">
        <form method="post" name="formfill" onsubmit="return validation()">
        <?php
            if (isset($error_message)) {
                echo '<p style="color: red; font-weight: bold;">' . $error_message . '</p>';
            }
            ?>
        <h2>Forgot Password</h2>
    <form method="post">
    <label for="user_name" style="font-weight: bold; color:white;">Username:</label>
<input type="text" name="user_name" id="user_name" required style="padding: 5px; border: 1px solid #ccc; border-radius: 4px;">
        <br>
        <input type="submit" value="Submit">
        <br>
        <span style="display: block; text-align: center; margin-top: 10px;">
    <a href="login.php" style="color: yellow; text-decoration: none; font-weight: bold;">Back to login</a>
</span>
    </form>
</body>
</html>
