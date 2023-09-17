<?php
session_start();
include("connection.php");
include("functions.php");
// Assume you have the necessary database connection and functions defined

// Fetch savings pools
$query = "SELECT * FROM savings_pools";
$savingsPools = mysqli_query($con, $query);

// Fetch pool participants
$query = "SELECT * FROM pool_participants";
$poolParticipants = mysqli_query($con, $query);

// Fetch contributions
$query = "SELECT * FROM contributions";
$contributions = mysqli_query($con, $query);

// Fetch withdrawals
$query = "SELECT * FROM withdrawals";
$withdrawals = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Savings Pool Dashboard</title>
    <link rel="stylesheet" href="dashboard.css"/>
</head>
<body>
    <div class="container">
        <h1>Savings Pool Dashboard</h1>
        
      <!-- Modify the section for Savings Pools -->
<div class="section">
    <h2>Savings Pools</h2>
    <table>
        <tr>
            <th>Pool ID</th>
            <th>Name</th>
            <th>Target Amount</th>
            <th>Current Balance</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($savingsPools)) { ?>
        <tr>
            <td><?php echo $row['pool_id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['target_amount']; ?></td>
            <td><?php echo $row['current_balance']; ?></td>
        </tr>
        <?php } ?>
    </table>
</div>

        
        <div class="section">
            <h2>Pool Participants</h2>
            <table>
                <tr>
                    <th>Participant ID</th>
                    <th>Participant Name</th>
                    <th>Pool ID</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($poolParticipants)) { ?>
                <tr>
                    <td><?php echo $row['participant_id']; ?></td>
                    <td><?php echo $row['participant_name']; ?></td>
                    <td><?php echo $row['pool_id']; ?></td>
                </tr>
                <?php } ?>
            </table>
        </div>
        
        <div class="section">
            <h2>Contributions</h2>
            <table>
                <tr>
                    <th>Contribution ID</th>
                    <th>Participant ID</th>
                    <th>Amount</th>
                    <th>Date/Time</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($contributions)) { ?>
                <tr>
                    <td><?php echo $row['contribution_id']; ?></td>
                    <td><?php echo $row['participant_id']; ?></td>
                    <td><?php echo $row['amount']; ?></td>
                    <td><?php echo $row['datetime']; ?></td>
                </tr>
                <?php } ?>
            </table>
        </div>
        
        <div class="section">
            <h2>Withdrawals</h2>
            <table>
                <tr>
                    <th>Withdrawal ID</th>
                    <th>Participant ID</th>
                    <th>Amount</th>
                    <th>Date/Time</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($withdrawals)) { ?>
                <tr>
                    <td><?php echo $row['withdrawal_id']; ?></td>
                    <td><?php echo $row['participant_id']; ?></td>
                    <td><?php echo $row['amount']; ?></td>
                    <td><?php echo $row['datetime']; ?></td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</body>
</html>
