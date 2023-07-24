<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
</head>
<style>
    .swal2-container.swal2-center>.swal2-popup{
        font-family: 'Poppins', sans-serif !important;
    }

    .swal2-styled.swal2-confirm{
        background: #ff9100 !important;
    }
</style>
<body>
  <!-- Your HTML content here -->

  <?php
session_start();
include('./db_connect.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Retrieve form data
  $plan = $_POST['plan'];
  $paymentMethod = $_POST['payment_method'];
  $email = $_POST['email'];

  // Assign the correct account number based on the payment method
  if ($paymentMethod === 'gcash') {
    $accountNumber = $_POST['account_number'];
  } elseif ($paymentMethod === 'paypal') {
    $accountNumber = $_POST['account_number2'];
  } else {
    // Handle any other payment methods if needed
    $accountNumber = '';
  }

  // Insert data into payments table
  $query = "INSERT INTO payments (user_id, subscription_id, plan, payment_method, account_number, email)
            VALUES (?, ?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($query);
  $stmt->bind_param('iissss', $_SESSION['login_id'], $_SESSION['login_subscription_id'], $plan, $paymentMethod, $accountNumber, $email);

  if ($stmt->execute()) {
    // Payment successfully stored in the database

    // Update subscription details in the users table
    $updateQuery = "UPDATE users SET subscription_id = ? WHERE id = ?";
    $updateStmt = $conn->prepare($updateQuery);

    // Calculate the new subscription_id based on the current subscription_id and the plan
    $newSubscriptionId = $_SESSION['login_subscription_id'];
    if ($plan === 'basic') {
    $newSubscriptionId = 2;
    } elseif ($plan === 'pro') {
    $newSubscriptionId = 3;
    }

    $updateStmt->bind_param('ii', $newSubscriptionId, $_SESSION['login_id']);
    $updateStmt->execute();

    // Update the session variable with the new subscription_id
    $_SESSION['login_subscription_id'] = $newSubscriptionId;

    // Display SweetAlert success message
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.js"></script>';
    echo '
      <script>
        Swal.fire({
          icon: "success",
          title: "Success!",
          text: "Your subscription has been successfully upgraded.",
        }).then(function() {
          window.location.href = "./index.php?page=home"; // Replace with your payment.php page URL
        });
      </script>
    ';
  } else {
    // Failed to store payment in the database
    echo "Payment processing failed.";
    // Add any error handling or redirect the user to an error page
  }
}
?>

  <!-- Your HTML content continues here -->
  <script>
    // Add this script at the bottom of the page
    document.addEventListener("DOMContentLoaded", function() {
      // Add an event listener to the form submit button
      document.querySelector("form").addEventListener("submit", function(event) {
        event.preventDefault(); // Prevent the form from submitting

        // Show the SweetAlert message
        Swal.fire({
          icon: "success",
          title: "Success!",
          text: "Your subscription has been successfully upgraded.",
        }).then(function() {
          window.location.href = "./index.php?page=home"; // Replace with your payment.php page URL
        });
      });
    });
  </script>
</body>
</html>
