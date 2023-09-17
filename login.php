<?php
session_start();

include("connection.php");
include("functions.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    //something was posted
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];

    if (!empty($user_name) && !empty($password) && !is_numeric($user_name)) {
        //read from database
        $user_id = random_num(20);
        $query = "select * from users where user_name = '$user_name' limit 1";

        $result = mysqli_query($con, $query);
        if ($result) {
            if ($result && mysqli_num_rows($result) > 0) {
                $user_data = mysqli_fetch_assoc($result);

                if ($user_data['password'] === $password) {
                    $_SESSION['user_id'] = $user_data['user_id'];
                    header("Location: dash.php");
                    die;
                }
            }
        }
        $error_message = "Wrong username or password!";
    } else {
        $error_message = "Wrong username or password!";
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
    <title>Login</title>
</head>
<body>
<div class="container">
    <div class="form-box">
        <form method="post" name="formfill" onsubmit="return validation()">
            <h2>Login</h2>
            <?php
            if (isset($error_message)) {
                echo '<p style="color: red; font-weight: bold;">' . $error_message . '</p>';
            }
            ?>
            <div class="input-box">
                <i class='bx bxs-user'></i>
                <input type="text" name="user_name" placeholder="Username" required>
            </div>
            <div class="input-box">
                <i class='bx bxs-lock-alt'></i>
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <div class="button">
                <input type="submit" class="btn" value="Login">
            </div>
            <div class="group">
                <span><a href="forget.php">Forget-Password</a></span>
                <span><a href="signup.php">Register</a></span>
            </div>
        </form>
    </div>
</div>
</body>
</html>
