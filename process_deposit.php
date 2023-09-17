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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate the deposit amount (this step is optional here)
    $depositAmount = filter_var($_POST['deposit_amount'], FILTER_VALIDATE_FLOAT);
    if ($depositAmount === false || $depositAmount <= 0) {
        echo '<p>Invalid deposit amount. Please enter a valid amount.</p>';
        exit;
    }

    // Get the selected payment method from the form
    $paymentMethod = $_POST['payment_method'];

    // Generate a custom deposit ID
    $depositID = generateDepositID();

    // Example usage:
    $userId = $user_data['user_id']; // Replace 'id' with the correct user ID field in your database

    // Insert the deposit amount, deposit ID, and payment method into the 'deposit' table
    $sql = "INSERT INTO deposit (user_id, deposit_amount, deposit_id, payment_method) 
            VALUES ('$userId', '$depositAmount', '$depositID', '$paymentMethod')";

    if (mysqli_query($con, $sql)) {
        // Deposit was successfully inserted

        // Redirect to the confirmation page with the deposit amount as a query parameter
        header('Location: confirmation.php?amount=' . $depositAmount);
        exit;
    } else {
        echo '<p>Error: ' . mysqli_error($con) . '</p>';
    }
}
?>
<!-- Rest of your HTML code here -->


<!DOCTYPE html>
<html lang="en">
<head>
    <!-- ... Your HTML head content ... -->
</head>
<body>
    <!-- Your HTML content here -->
    
    <!-- JavaScript code should be placed within <script> tags -->
    <script>
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
