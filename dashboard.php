<?php
session_start();
include("connection.php");
include("functions.php");

// Check if the user is logged in
$user_data = check_login($con);

// Process the savings pool form submission
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Check if the savings amount is provided
    if (!empty($_POST['savings_amount'])) {
        $savings_amount = $_POST['savings_amount'];
        
        // Save the savings amount to the database
        $query = "INSERT INTO savings_pool (user_id, savings_amount) VALUES ('".$user_data['user_id']."', '$savings_amount')";
        mysqli_query($con, $query);
    }
}

?>

    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dashboard.css">
    <link href="css/bootstrap.min.css" rel="stylesheet"/>
    <script src="js/bootstrap.bundle.js"></script>
    <title>Dashboard</title>
</head>
<body>
    <div class="container">
        <header>
            <h1>Dashboard</h1>
        </header>
        <nav>
            <ul>
            <nav class="navbar navbar-expand-lg bg-body-tertiary"data-bs-theme="dark">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">
              <img src="logo.png" alt="Bootstrap" width="120" height="150">
            </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <!--dropdownt-->
                
              <li class="about-us dropdown">
                  <ul class="nav nav-tabs">
                  <li class="nav-item dropdown">
                  <li class="nav-item">
                <a class="nav-link active" href="home page.html">Home</a
                </li>
</li>
                      <a class="nav-link active dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        About us
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="what we offer.html">Business info</a></li>
                            <li><a class="dropdown-item" href="securtiy.html">Security and Privacy info</a></li>
                          </ul>
                </ul>
            </ul>
            <li class="settings">
                <ul class="nav nav-tabs">
                <a class="nav-link active" href="main login.html">Settings</a>
            </li>
            <li class="logout">
                <ul class="nav nav-tabs">
                <ion-icon name="log-out-outline"></ion-icon>
                <a class="nav-link active" href="logout.php">logout</a>
            </li>
            <form class="d-flex" role="search">
              <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
          </div>
        </div>
      </nav>
      <h2>Welcome, <?php echo $user_data['user_name']; ?></h2>
      <main>
        <section>
        <a class="btn btn-primary" href="#" role="button">
            <h2>Total Savings</h2>
            <div class="total-savings">$0,000</div>
        </a>
        <a class="btn btn-secondary" href="#" role="button">
            <h2>Total Investment</h2>
            <div class="total-investment">$0,000</div>
            </a>  
        </section>
    </main>
        <div class="savings-form">
            <h3>Contribute to the Savings Pool</h3>
            <form method="post">
                <div class="form-group">
                    <label for="savings_amount">Enter Savings Amount:</label>
                    <input type="number" name="savings_amount" id="savings_amount" required>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Contribute">
                </div>
            </form>
        </div>
        <div class="savings-pool">
            <h3>Savings Pool Balance</h3>
            <?php
            // Retrieve the total savings amount from the database
            $query = "SELECT SUM(savings_amount) AS total_savings FROM savings_pool";
            $result = mysqli_query($con, $query);
            $row = mysqli_fetch_assoc($result);
            $total_savings = $row['total_savings'];

            echo '<p>Total Savings: $'.$total_savings.'</p>';
            ?>
        </div>
               
        <section>
            <h2>Main Content</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam convallis metus eget erat blandit, eget tristique velit ultrices. Vestibulum eleifend lorem et lectus eleifend hendrerit. Aliquam non eros finibus, feugiat mauris non, finibus justo. Donec eget felis id sem tincidunt dignissim. In hac habitasse platea dictumst. Nulla nec finibus velit. Fusce a efficitur mi. Nullam lacinia neque sed scelerisque aliquet. Nulla facilisi. Nulla facilisi. Aliquam eget ex et leo scelerisque accumsan. Nullam aliquam magna vitae est accumsan, ut pellentesque odio luctus. Nullam nec ultricies risus, id viverra nisi. Proin eget dapibus dolor, a ullamcorper quam.</p>
        </section>
        <footer>
            <p>&copy; 2023 Your Company. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>

        
        