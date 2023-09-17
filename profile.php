<?php
session_start();
include("connection.php");
include("functions.php");

// Check if the user is logged in
$user_data = check_login($con);

// Initialize edit status variables for full name and BVN
$full_name_edited = false;
$bvn_edited = false;

// Fetch the user's edit status for full name and BVN from the database
$query = "SELECT full_name_edited, bvn_edited FROM users WHERE user_id = ?";
$stmt = mysqli_prepare($con, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $user_data['user_id']);
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        $edit_status = mysqli_fetch_assoc($result);
        
        if ($edit_status) {
            $full_name_edited = ($edit_status['full_name_edited'] == 1);
            $bvn_edited = ($edit_status['bvn_edited'] == 1);
        }
    } else {
        echo "Error fetching edit status: " . mysqli_stmt_error($stmt);
    }
    mysqli_stmt_close($stmt);
} else {
    echo "Error preparing statement: " . mysqli_error($con);
}

// Process the profile update form submission
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['update-profile'])) {
    // Retrieve the form data
    $full_name = $_POST['full-name'];
    $bv_number = $_POST['bv-number'];

    // Check if the fields can be edited
    if (!$full_name_edited) {
        $full_name_edited = true; // Set to edited
    } else {
        $full_name = $user_data['full_name']; // Prevent editing again
    }

    if (!$bvn_edited) {
        $bvn_edited = true; // Set to edited
    } else {
        $bv_number = $user_data['bv_Number']; // Prevent editing again
    }

    // Update the user's information in the database
    $query = "UPDATE users SET full_name = ?, bv_number = ?, full_name_edited = ?, bvn_edited = ? WHERE user_id = ?";
    $stmt = mysqli_prepare($con, $query);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssiii", $full_name, $bv_number, $full_name_edited, $bvn_edited, $user_data['user_id']);
        if (mysqli_stmt_execute($stmt)) {
            
        } else {
            echo "Error updating profile: " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($con);
    }
}
// Fetch the user's profile image URL from the "image" field in the database based on their ID
$user_id = $user_data['id'];
$select_profile_image_query = "SELECT profile_image_url FROM users WHERE id = $user_id";
$result = mysqli_query($con, $select_profile_image_query);
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $profile_image_url = $row['profile_image_url'];
} else {
    $profile_image_url = 'default_profile_image.jpg';
}
// Fetch deposit history for the logged-in user
$userId = $user_data['user_id'];
$sql = "SELECT deposit_id, deposit_amount, deposit_date FROM deposit WHERE user_id = '$userId'";
$result = mysqli_query($con, $sql);

// Initialize total deposit amount
$totalDeposit = 0;
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
    <link rel="stylesheet" href="stylepr.css">
    
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

    <section class="content-wrapper">
        <div class="content">
        <form action="profile.php" method="post" >
        <div class="cards-container">
            <div class="card profile-card">
                <h1>User Profile</h1>
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
    </select>

    <div class="identification-upload">
    <label for="upload-identification-image" id="upload-identification-label" class="file-label">Upload Identification Image</label>
    <input type="file" id="upload-identification-image" name="upload-identification-image" accept="image/*" style="display: none;">
<div id="identification-image-container">
    <img id="identification-image-preview" src="" alt="Identification Image">
 <input type="submit" name="update-profile" value="Update Profile"class="update-profile-button">
 </form>
 </fieldset>                
</div>
<div class="card-container">
<div class="card contribution-card">
    <h2>Deposit History</h2>
    <table class="contribution-table">
        <thead>
            <tr>
                <th>Deposit ID</th>
                <th>Date</th>
                <th>Deposit Amount</th>
                <th><ion-icon name="print-outline"></ion-icon></th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <tr>
                <td><?php echo $row['deposit_id']; ?></td>
                <td><?php echo $row['deposit_date']; ?></td>
                <td><?php echo $row['deposit_amount']; ?></td>
                <td><button class="print-receipt-button">Print Receipt</button></td>
            </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>
<div class="card privacy-card">
<div class="privacy-settings">
        <h2>withdrwal history</h2>
        <table class="contribution-table">
        <thead>
            <tr>
                <th>Receipt No</th>
                <th>Transaction Time</th>
                <th>Amount</th>
                <th><ion-icon name="print-outline"></ion-icon></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>12345</td>
                <td>2023-07-15</td>
                <td>$100</td>
                <td><button class="print-receipt-button">Print Receipt</button></td>
            </tr>
            <tr>
                <td>12346</td>
                <td>2023-07-30</td>
                <td>$50</td>
                <td><button class="print-receipt-button">Print Receipt</button></td>
            </tr>
            <tr>
                <td>12347</td>
                <td>2023-07-30</td>
                <td>$30</td>
                <td><button class="print-receipt-button">Print Receipt</button></td>
            </tr>
            <tr>
                <td>12348</td>
                <td>2023-07-30</td>
                <td>$70</td>
                <td><button class="print-receipt-button">Print Receipt</button></td>
            </tr>
            <tr>
                <td>12348</td>
                <td>2023-07-30</td>
                <td>$70</td>
                <td><button class="print-receipt-button">Print Receipt</button></td>
            </tr>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
<script src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script>
         const leftNavbar = document.querySelector('.left-navbar');
    const leftNavbarToggle = document.querySelector('#leftNavbarToggle');

    leftNavbarToggle.addEventListener('click', () => {
        leftNavbar.classList.toggle('left-navbar-minimized');
    });
    const printButtons = document.querySelectorAll(".print-receipt-button");

printButtons.forEach((button, index) => {
    button.addEventListener("click", function () {
        printReceipt(this.parentElement.parentElement.cells[0].textContent);
    });
});
    function printReceipt(receiptNumber) {
        alert("Printing Receipt for Receipt No: " + receiptNumber);
    };
    

    const uploadIdentificationLabel = document.getElementById('upload-identification-label');
    const identificationImageInput = document.getElementById('upload-identification-image');
    const identificationImagePreview = document.getElementById('identification-image-preview');
    const identificationImageContainer = document.getElementById('identification-image-container');

    uploadIdentificationLabel.addEventListener('click', function() {
        identificationImageInput.click();
    });
    identificationImageInput.addEventListener('change', function(event) {
        const selectedFile = event.target.files[0];
        if (selectedFile) {
            const objectURL = URL.createObjectURL(selectedFile);
            identificationImagePreview.src = objectURL;
            identificationImageContainer.style.display = 'block';
        }
    });
    const editProfileImage = document.getElementById('edit-profile-image');
    const profileImageInput = document.getElementById('profile-image-input');
    const profileImage = document.getElementById('profile-image');

    editProfileImage.addEventListener('click', function() {
        profileImageInput.click();
    });

    profileImageInput.addEventListener('change', function(event) {
        const selectedFile = event.target.files[0];
        if (selectedFile) {
            const objectURL = URL.createObjectURL(selectedFile);
            profileImage.src = objectURL + '?rand=' + Math.random(); // Adding random query parameter
        }
    });
    
</script>

</body>
</html>
