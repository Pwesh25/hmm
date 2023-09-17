<?php
session_start();
include("connection.php");
include("functions.php");

// Check if the user is logged in
$user_data = check_login($con);

// Fetch deposit history for the logged-in user
$userId = $user_data['user_id'];
$sql = "SELECT deposit_id, deposit_amount, deposit_date FROM deposit WHERE user_id = '$userId'";
$result = mysqli_query($con, $sql);

// Initialize total deposit amount
$totalDeposit = 0;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- ... Your HTML head content ... -->
</head>
<body>
    <div class="deposit-history-container">
        <h1>Deposit History</h1>

        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Deposit ID</th>
                    <th>Deposit Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    $totalDeposit += $row['deposit_amount'];
                ?>
                <tr>
                    <td><?php echo $row['deposit_date']; ?></td>
                    <td><?php echo $row['deposit_id']; ?></td>
                    <td><?php echo $row['deposit_amount']; ?></td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>

        <p>Total Amount Deposited: <?php echo $totalDeposit; ?></p>
    </div>
</body>
</html>
