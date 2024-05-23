<?php
// Connection details
$host = "localhost";
$user = "sibojean"; 
$pass = "222019374"; 
$database = "virtual _occupational_therapy_sessions_platform";
// Creating connection
$connection = new mysqli($host, $user, $pass, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Check if payment_id is set
if (isset($_REQUEST['payment_id'])) {
    $payment_id = $_REQUEST['payment_id'];

    // Use prepared statement
    $stmt = $connection->prepare("SELECT * FROM payments WHERE payment_id = ?");
    $stmt->bind_param("i", $payment_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $client_id = htmlspecialchars($row['client_id'], ENT_QUOTES);
        $amount = htmlspecialchars($row['amount'], ENT_QUOTES);
        $payment_date = htmlspecialchars($row['payment_date'], ENT_QUOTES);
    } else {
        echo "Page not found.";
        exit();
    }

    // Close statement
    $stmt->close();
}

// Check if client_id exists in clients table
function isValidClient($client_id, $connection) {
    $stmt = $connection->prepare("SELECT * FROM client WHERE client_id = ?");
    $stmt->bind_param("i", $client_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Payment</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <center>
        <!-- Update payment form -->
        <h2><u>Update Payment Form</u></h2>
        <form method="POST" onsubmit="return confirmUpdate();">
            <input type="hidden" name="payment_id" value="<?php echo isset($payment_id) ? $payment_id : ''; ?>">
            
            <label for="client_id">Client ID:</label>
            <input type="text" name="client_id" value="<?php echo isset($client_id) ? $client_id : ''; ?>" required>
            <br><br>

            <label for="amount">Amount:</label>
            <input type="text" name="amount" value="<?php echo isset($amount) ? $amount : ''; ?>" required>
            <br><br>

            <label for="payment_date">Payment Date:</label>
            <input type="datetime-local" name="payment_date" value="<?php echo isset($payment_date) ? $payment_date : ''; ?>" required>
            <br><br>

            <input type="submit" name="up" value="Update">
        </form>
    </center>
</body>
</html>

<?php
// Handle form submission
if (isset($_POST['up'])) {
    // Retrieve updated values from the form
    $client_id = htmlspecialchars($_POST['client_id'], ENT_QUOTES);
    $amount = htmlspecialchars($_POST['amount'], ENT_QUOTES);
    $payment_date = htmlspecialchars($_POST['payment_date'], ENT_QUOTES);
    $payment_id = htmlspecialchars($_POST['payment_id'], ENT_QUOTES); // Retrieve payment_id from the form

    // Validate client_id
    if (!isValidClient($client_id, $connection)) {
        echo "Invalid client ID";
        exit();
    }

    // Use prepared statement for update
    $stmt = $connection->prepare("UPDATE payments SET client_id = ?, amount = ?, payment_date = ? WHERE payment_id = ?");
    $stmt->bind_param("idis", $client_id, $amount, $payment_date, $payment_id);

    if ($stmt->execute()) {
        // Redirect to payments.php on successful update
        header('Location: payments.php');
        exit(); // Ensure that no other content is sent after the header redirection
    } else {
        // Handle error (e.g., display an error message)
        echo "Failed to update. Please try again.";
    }

    // Close statement
    $stmt->close();
}

// Close connection
$connection->close();
?>
