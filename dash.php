<?php
session_start();
include("connection.php");
include("functions.php");

// Check if the user is logged in
$user_data = check_login($con);

// Fetch the total deposit balance for the logged-in user
$userId = $user_data['user_id'];
$query = "SELECT SUM(deposit_amount) AS total_deposit FROM deposit WHERE user_id = '$userId'";
$result = mysqli_query($con, $query);

// Initialize the total deposit balance
$totalDeposit = 0;

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $totalDeposit = $row['total_deposit'];
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="css/bootstrap.min.css" rel="stylesheet"/>
    <script src="js/bootstrap.bundle.js"></script>
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <style>
        
    </style>
</head>
<body>
    <nav class="top-navbar">
        <div class="center-image">
            <ul>
            <img src="2.png" alt="Bootstrap" width="50" height="40">
                <li><a href="home page.html"><ion-icon name="home-sharp"></ion-icon>Home</a></li>
                <li><a href="#"><ion-icon name="cash-sharp"></ion-icon>Withdrawals</a></li>
                <li><a href="#"><ion-icon name="receipt-sharp"></ion-icon>History/Transactions</a></li>
                <li><a href="#"><ion-icon name="notifications-sharp"></ion-icon></a></li>
            <li><a href="#"><ion-icon name="headset-sharp"></ion-icon></a></li>
            </ul>
        </div>
    </nav>

    <nav class="left-navbar">
       
        <ul>
        <img src="main logo.png" alt="Bootstrap" width="180" height="50">
        <h2>Welcome, <?php echo $user_data['user_name']; ?></h2>
            <li><a href="dash.php"><ion-icon name="desktop-sharp"></ion-icon>Dashboard</a></li>
            <li><a href="account.php"><ion-icon name="person-sharp"></ion-icon>my account</a></li>
            <li><a href="#"><ion-icon name="trending-up-sharp"></ion-icon>invest</a></li>
            <li><a href="deposit.php"><ion-icon name="card-sharp"></ion-icon>Deposit</a></li>
            <li><a href="profile.php"><ion-icon name="person-sharp"></ion-icon>Profile</a></li>
            <li><a href="login.php"><ion-icon name="log-out-sharp"></ion-icon>Logout</a></li>
        </ul>
        <button class="left-navbar-toggle" id="leftNavbarToggle">
        <ion-icon name="menu-outline"></ion-icon>
        </button>
    </nav>
<section>
    <div class="content">
    <div class="card" style="width: 20rem; height: 10rem;">
  <div class="card-body">
  <a class="btn btn-primary" style="width: 15rem; height: 5rem;">
  <h5><ion-icon name="card-sharp"></ion-icon> Balance</h5>
<div class="balance">₦<?php echo number_format($totalDeposit, 2); ?></div>
        </a>
</div>
</div>
    <div class="card" style="width: 20rem; height: 10rem;">
  <div class="card-body">
  <a class="btn btn-secondary" style="width: 15rem; height: 5rem;">
         <h4><ion-icon name="trending-up-sharp"></ion-icon> Total Investment</h4>
            <div class="savings_amount">$1,000</div>
        </a>
    </div>
    
</section>
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
