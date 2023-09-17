<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Account</title>
    <link rel="stylesheet" href="accoun.css">
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
    <section>
        <main>
            <div class="content">
                <div class="right-list">
                    <ul>
                        <li><button id="account-settings-button">My Account Settings</button></li>
                        <li><button id="verify-email-button">Verify Your Email</button></li>
                        <li><button id="add-bvn-nin-button">Add BVN or NIN</button></li>
                        <li><button id="refer-earn-button">Refer and Earn</button></li>
                    </ul>
                </div>
                <div id="account-settings-popup" class="popup">
                    <div class="popup-content">
               <button id="profile-settings-button">profile Settings</button>
                    <br>
                <button id="FA-update-security-questions-button">2FA update security questions</button>
                    <br>
                <button id="notification-settings-button">notification settings </button>
                <br>
                <button id="password-settings-button">password settings</button>
                <br>
                <button id="next-of-kin-button">next of kin</button>
                <br>
               <button id="bvn-settings-button">bvn settings</button>
               <br>
            <button id="close-popup">Close</button>
        </div>
    </div>
                        <h2>Account Settings</h2>
                        <div id="profile-settings-content" style="display: none;">
        <div class="content">
        <form action="profile.php" method="post" >
        <div class="cards-container">
            <div class="card profile-card">
                            <h3>Profile Settings</h3>
                            <div class="profile-image" style="background-image: url('<?php echo $profile_image_url; ?>');">
                <div class="profile-image-edit">
            </div>
</div>
    
                    <fieldset>
                        <legend>Personal Information</legend>
                        <form>
                            <label for="full_name">Full Name:</label>
                            <input type="text" id="full-name" name="full-name" value="<?php echo $user_data['full_name']; ?>" readonly>
                            <br>
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" value="<?php echo $user_data['email']; ?>" readonly>
                            <br>
                            <label for="contact-number">Contact Number:</label>
                            <input type="tel" id="contact-number" name="contact-number" value="<?php echo $user_data['phone']; ?>" readonly>
                            <br>
                            <label for="bv-number">Bank verification number:</label>
                            <input type="tel" id="bv-number" name="bv-number" value="<?php echo $user_data['bv_Number']; ?>"readonly>
                            <br>
    <select id="identification-type" name="identification-type">
        <option value="passport">Passport</option>
        <option value="driver-license">Driver's License</option>
        <option value="id-card">ID Card</option>
                        </div>
                        <div id="FA-update-security-questions-content" style="display:;">
                            <!-- 2FA Update Security Questions content goes here -->
                            <h3>2FA Update Security Questions</h3>
                            <!-- Add your 2FA settings form or details here -->
                        </div>
                        <!-- Add similar containers for other settings -->

                        <!-- Close button -->
                        <button id="close-popup">Close</button>
                    </div>
                </div>
            </div>
        </main>
    </section>

    <script>
        const leftNavbar = document.querySelector('.left-navbar');
        const leftNavbarToggle = document.querySelector('#leftNavbarToggle');

        leftNavbarToggle.addEventListener('click', () => {
            leftNavbar.classList.toggle('left-navbar-minimized');
        });

        const accountSettingsLink = document.getElementById('account-settings-button');
        const accountSettingsPopup = document.getElementById('account-settings-popup');
        const closePopupButton = document.getElementById('close-popup');
        const profileSettingsButton = document.getElementById('profile-settings-button');
        const profileSettingsContent = document.getElementById('profile-settings-content');

        accountSettingsLink.addEventListener('click', (event) => {
            event.preventDefault();
            accountSettingsPopup.classList.add('active');
        });

        profileSettingsButton.addEventListener('click', () => {
            profileSettingsContent.style.display = 'block';
        });

        closePopupButton.addEventListener('click', () => {
            accountSettingsPopup.classList.remove('active');
            profileSettingsContent.style.display = 'none'; // Hide the profile settings content when closing
        });
    </script>
</body>
</html>
