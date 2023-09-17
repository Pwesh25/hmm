<?php
//Define an associative array mapping payment methods to payment links
$paymentLinks = array(
    "paystack" => "https://paystack.com/pay/ia7e9iqm-9", // Replace with the actual Paystack payment link
    "flutterwave" => "https://flutterwave.com/pay/your-flutterwave-link", // Replace with the actual Flutterwave payment link
    "bankTransfer" => "https://your-bank-transfer-link.com" // Replace with the actual bank transfer link
);
session_start();
include("connection.php");
include("functions.php");

// Check if the user is logged in
$user_data = check_login($con);

// Fetch the deposit ID, deposit amount, and payment method from the database
$userId = $user_data['user_id'];
$sql = "SELECT deposit_id, deposit_amount, payment_method FROM deposit WHERE user_id = '$userId' ORDER BY deposit_date DESC LIMIT 1"; // Assuming you have a 'deposit_date' column to determine the latest deposit
$result = mysqli_query($con, $sql);

$depositID = "";
$depositAmount = "";
$paymentMethod = ""; // Variable to store the payment method

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $depositID = $row['deposit_id'];
    $depositAmount = $row['deposit_amount'];
    $paymentMethod = $row['payment_method']; // Fetch the payment method from the database
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <!-- ... Your HTML head content ... -->
</head>
<body>
    <div class="confirmation-container">
        <h1>Confirmation Details</h1>
        <!-- Full Name (Read-only) -->
        <div class="form-group">
            <label for="full_Name">Full Name:</label>
            <input type="text" id="full_Name" name="full_Name" value="<?php echo $user_data['full_name']; ?>" readonly>
        </div>

        <!-- Phone Number (Read-only) -->
        <div class="form-group">
            <label for="phoneNumber">Phone Number:</label>
            <input type="text" id="phone" name="phone" value="<?php echo $user_data['phone']; ?>" readonly>
        </div>

        <!-- Email (Read-only) -->
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $user_data['email']; ?>" readonly>
        </div>

        <!-- Reference Number (Read-only) -->
        <div class="form-group">
            <label for="deposit_id">Reference Number:</label>
            <input type="text" id="deposit_id" name="deposit_id" value="<?php echo $depositID; ?>" readonly>
        </div>

        <!-- Deposit Amount (Read-only) -->
        <div class="form-group">
            <label for="deposit_Amount">Deposit Amount:</label>
            <input type="text" id="amount" name="deposit_Amount" value="<?php echo $depositAmount; ?>" readonly>
        </div>
        
        <!-- Payment Method (Read-only) -->
        <div class="form-group">
            <label for="payment_method">Payment Method:</label>
            <input type="text" id="payment_method" name="payment_method" value="<?php echo $paymentMethod; ?>" readonly>
        </div>
   <!-- Proceed to Payment Button -->
   <button id="proceedToPaymentButton">Proceed to Payment</button>
    </div>

    <script>
          // Get a reference to the "Proceed to Payment" button
          const proceedToPaymentButton = document.getElementById('proceedToPaymentButton');

// Add a click event listener to the button
proceedToPaymentButton.addEventListener('click', function() {
    // Get the selected payment method
    const selectedPaymentMethod = document.getElementById('payment_method').value;

    // Define the payment links in a PHP associative array
    const paymentLinks = <?php echo json_encode($paymentLinks); ?>;

    // Use the selected payment method to fetch the payment link from the PHP array
    const paymentLink = paymentLinks[selectedPaymentMethod];

    // Redirect to the appropriate payment link
    if (paymentLink) {
        window.location.href = paymentLink;
    } else {
        alert("Invalid payment method.");
    }
});
    </script>
</body>
</html>
</body>
</html>
