<?php
session_start();
include("connection.php");
include("functions.php");

// Check if the user is logged in
$user_data = check_login($con);

// Handle User Profile Settings
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Handle Profile Settings
    if (isset($_POST['profile-settings'])) {
        $full_name = $_POST['full-name'];
        $email = $_POST['email'];
        $contact_number = $_POST['contact-number'];
        $bv_number = $_POST['bv-number'];
        
        // Update profile settings in the database
        $update_profile_query = "UPDATE users SET full_name = '$full_name', email = '$email', phone = '$contact_number', bv_Number = '$bv_number' WHERE id = {$user_data['id']}";
        mysqli_query($con, $update_profile_query);
        
        // Redirect back to settings page with a success message
        header("Location: settings.php?success=1");
        exit;
    }
    ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

  // Handle Security Settings
if (isset($_POST['security-settings'])) {
    $old_password = $_POST['old-password'];

    // Retrieve the user's hashed password from the database
    $user_id = $user_data['id'];
    $select_password_query = "SELECT password FROM users WHERE id = $user_id";
    $result = mysqli_query($con, $select_password_query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $hashed_password = $row['password'];

        // Verify the old password
        if (password_verify($old_password, $hashed_password)) {
            $new_password = $_POST['new-password'];

            // Hash the new password
            $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Update the new password in the database
            $update_password_query = "UPDATE users SET password = '$hashed_new_password' WHERE id = $user_id";
            mysqli_query($con, $update_password_query);

            // Redirect back to settings page with a success message
            header("Location: settings.php?success=1");
            exit;
        } else {
            // Old password doesn't match, redirect with an error message
            header("Location: settings.php?error=1&message=Old password doesn't match");
            exit;
        }
    } else {
        // Error fetching password from database
        header("Location: settings.php?error=1");
        exit;
    }
}

    
    // Handle Notification Settings
    if (isset($_POST['notification-settings'])) {
        $email_notifications = isset($_POST['email-notifications']) ? 1 : 0;
        
        // Update email_notifications in the database
        $update_notifications_query = "UPDATE users SET email_notifications = '$email_notifications' WHERE id = {$user_data['id']}";
        mysqli_query($con, $update_notifications_query);
        
        // Redirect back to settings page with a success message
        header("Location: settings.php?success=1");
        exit;
    }
}  
?>

<!-- Rest of your HTML code -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="css/bootstrap.min.css" rel="stylesheet"/>
    <script src="js/bootstrap.bundle.js"></script>
    <title>profile</title>
    <link rel="stylesheet" href="styleset.css">
    
</head>
<body>
    
    <nav class="left-navbar">
       
        <ul>
        <img src="main logo.png" alt="Bootstrap" width="180" height="50">
            <li><a href="dash.php"><ion-icon name="desktop-sharp"></ion-icon>Dashboard</a></li>
            <li><a href="profile.php"><ion-icon name="person-sharp"></ion-icon>Profile</a></li>
            <li><a href="settings.php"><ion-icon name="settings-sharp"></ion-icon>Settings</a></li>
           
            <li><a href="login.php"><ion-icon name="log-out-sharp"></ion-icon>Logout</a></li>
        </ul>
        <button class="left-navbar-toggle" id="leftNavbarToggle">
        <ion-icon name="menu-outline"></ion-icon>
        </button>
    </nav>
    <main>
    <div class="content">
        <div class="settings-card">
        <form action="settings.php" method="post">
            <!-- User Profile Settings -->
            <div class="settings-section">
            <h2>User Profile Settings</h2>
            <label for="full-name">Full Name:</label>
            <input type="text" id="full-name" name="full-name" value="<?php echo $user_data['full_name']; ?>" required>
            <br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $user_data['email']; ?>" required>
            <br>
            <label for="contact-number">Contact Number:</label>
           <input type="tel" id="contact-number" name="contact-number" value="<?php echo $user_data['phone']; ?>" required>
            <br>
           <label for="bv-number">Bank Verification Number:</label>
            <input type="text" id="bv-number" name="bv-number" value="<?php echo $user_data['bv_Number']; ?>" required>
            <br>
            <label for="profile-image">Profile Picture:</label>
            <input type="file" id="profile-image" name="profile-image">
            <button type="submit" name="profile-settings">Save Profile Settings</button>
</div>
            
            <!-- Security Settings -->
            <div class="settings-section">
            <h2>Security Settings</h2>
            <label for="old-password">Old Password:</label>
            <input type="password" id="old-password" name="old-password">
            <label for="new-password">New Password:</label>
            <input type="password" id="new-password" name="new-password">
            <button type="submit" name="security-settings">Save Security Settings</button>
</div>
            
            <!-- Notification Settings -->
            <div class="settings-section">
            <h2>Notification Settings</h2>
            <label for="email-notifications">Email Notifications:</label>
            <input type="checkbox" id="email-notifications" name="email-notifications" <?php echo ($user_data['email'] ? 'checked' : ''); ?>>
            
            <button type="submit" name="notification-settings">Save Notification Settings</button>
                    </div>
        </form>
    </main>
    <script src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script>
        const leftNavbar = document.querySelector('.left-navbar');
        const leftNavbarToggle = document.querySelector('#leftNavbarToggle');

        leftNavbarToggle.addEventListener('click', () => {
            leftNavbar.classList.toggle('left-navbar-minimized');
        });
    </script>    
</body>
</html>