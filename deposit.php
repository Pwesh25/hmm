<?php
session_start();
include("connection.php");
include("functions.php");

// Function to generate a custom deposit ID
function generateDepositID() {
    // You can customize the format of the deposit ID here
    $prefix = 'dep'; // Prefix for the deposit ID
    $randomPart = substr(md5(uniqid(mt_rand(), true)), 0, 10); // Generate a random part
    return $prefix . $randomPart;
}

// Check if the user is logged in
$user_data = check_login($con);

// Check if the deposit amount form is submitted
if (isset($_POST['deposit_amount'])) {
    // Sanitize and validate the deposit amount
    $depositAmount = filter_var($_POST['deposit_amount'], FILTER_VALIDATE_FLOAT);
    if ($depositAmount === false || $depositAmount <= 0) {
        echo '<p>Invalid deposit amount. Please enter a valid amount.</p>';
        exit; // Exit the script if the amount is invalid
    }

    // Generate a custom deposit ID
    $depositID = generateDepositID();

    // Example usage:
    $userId = $user_data['user_id']; // Replace 'id' with the correct user ID field in your database

    // Insert the deposit amount and deposit ID into the 'deposit' table
    $sql = "INSERT INTO deposit (user_id, deposit_amount, deposit_id) 
            VALUES ('$userId', '$depositAmount', '$depositID')";

    if (mysqli_query($con, $sql)) {
        // Deposit was successfully inserted
        echo '<p>Deposit ID: ' . $depositID . '</p>';
        echo '<p>Deposit amount saved successfully!</p>';
    } else {
        echo '<p>Error: ' . mysqli_error($con) . '</p>';
    }
}
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="deposit.css">
   
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

    <div class="content">
        <h1>Fund Your Account</h1>
        <!-- Payment Button with a new class "payment-button" -->
        <button class="payment-button" onclick="openPaymentOptions()"><span id="paymentButtonText">Select Payment Option</span>
        </button>

        <!-- Payment options popup (moved after "Fund Your Account" heading) -->
        <div class="overlay" id="overlay"></div>
        <div class="payment-popup" id="paymentPopup">
            <h2>Select Payment Option</h2>
            <div class="payment-option">
                <input type="radio" id="paystack" name="payment" value="paystack">
                <label for="paystack">paystack</label>
            </div>
            <div class="payment-option">
                <input type="radio" id="flutterwave" name="payment" value="flutterwave">
                <label for="flutterwave">flutterwave</label>
            </div>
            <div class="payment-option">
                <input type="radio" id="bankTransfer" name="payment" value="bankTransfer">
                <label for="bankTransfer">Bank Transfer</label>
            </div>
            <button onclick="selectPayment()">Select</button>
</div>
             <!-- Hidden input box for deposit amount -->
             <form method="post" action="process_deposit.php" id="depositForm">
    <div class="deposit-amount" id="depositAmount">
        <label for="amount">Enter Deposit Amount:</label>
        <input type="text" id="amount" name="deposit_amount">
        
       <!-- Hidden input box for payment method -->
<input type="hidden" id="paymentMethod" name="payment_method" value=""> 
        <button type="submit" class="Proceed-button">Proceed</button>
    </div>
</form>
    <script src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script>
          const leftNavbar = document.querySelector('.left-navbar');
    const leftNavbarToggle = document.querySelector('#leftNavbarToggle');

    leftNavbarToggle.addEventListener('click', () => {
        leftNavbar.classList.toggle('left-navbar-minimized');
    });

    // Function to open the payment options popup
    function openPaymentOptions() {
        var overlay = document.getElementById('overlay');
        var paymentPopup = document.getElementById('paymentPopup');
        overlay.style.display = 'block';
        paymentPopup.style.display = 'block';
    }

    // Function to close the payment options popup
    function closePaymentOptions() {
        var overlay = document.getElementById('overlay');
        var paymentPopup = document.getElementById('paymentPopup');
        overlay.style.display = 'none';
        paymentPopup.style.display = 'none';
    }

   // Function to handle payment selection
function selectPayment() {
    var paymentOptions = document.getElementsByName('payment');
    var selectedPayment = "";

    for (var i = 0; i < paymentOptions.length; i++) {
        if (paymentOptions[i].checked) {
            selectedPayment = paymentOptions[i].value;
            break;
        }
    }

    if (selectedPayment !== "") {
        // Update the hidden input field with the selected payment option
        var paymentMethodInput = document.getElementById('paymentMethod');
        paymentMethodInput.value = selectedPayment;

        // Update the text of the span element with the selected payment option
        var paymentButtonText = document.getElementById('paymentButtonText');
        paymentButtonText.textContent = selectedPayment;

        // Show the additional input box for deposit amount
        var depositAmount = document.getElementById('depositAmount');
        depositAmount.style.display = 'block';

        closePaymentOptions();
    } else {
        alert("Please select a payment option.");
    }
}
    </script>
</body>
</html>
