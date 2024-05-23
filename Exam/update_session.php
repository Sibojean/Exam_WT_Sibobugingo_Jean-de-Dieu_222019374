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

// Check if session_id is set
if (isset($_REQUEST['session_id'])) {
    $session_id = $_REQUEST['session_id'];

    // Use prepared statement
    $stmt = $connection->prepare("SELECT * FROM sessions WHERE session_id = ?");
    $stmt->bind_param("i", $session_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $start_time = htmlspecialchars($row['start_time'], ENT_QUOTES);
        $end_time = htmlspecialchars($row['end_time'], ENT_QUOTES);
        $location = htmlspecialchars($row['location'], ENT_QUOTES);
        $client_id = htmlspecialchars($row['client_id'], ENT_QUOTES);
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
    <title>Update Session</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <center>
        <!-- Update session form -->
        <h2><u>Update Session Form</u></h2>
        <form method="POST" onsubmit="return confirmUpdate();">
            <input type="hidden" name="session_id" value="<?php echo isset($session_id) ? $session_id : ''; ?>">
            
            <label for="start_time">Start Time:</label>
            <input type="datetime-local" name="start_time" value="<?php echo isset($start_time) ? $start_time : ''; ?>" required>
            <br><br>

            <label for="end_time">End Time:</label>
            <input type="datetime-local" name="end_time" value="<?php echo isset($end_time) ? $end_time : ''; ?>" required>
            <br><br>

            <label for="location">Location:</label>
            <input type="text" name="location" value="<?php echo isset($location) ? $location : ''; ?>" required>
            <br><br>

            <label for="client_id">Client ID:</label>
            <input type="text" name="client_id" value="<?php echo isset($client_id) ? $client_id : ''; ?>" required>
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
    $start_time = htmlspecialchars($_POST['start_time'], ENT_QUOTES);
    $end_time = htmlspecialchars($_POST['end_time'], ENT_QUOTES);
    $location = htmlspecialchars($_POST['location'], ENT_QUOTES);
    $client_id = htmlspecialchars($_POST['client_id'], ENT_QUOTES);
    $session_id = htmlspecialchars($_POST['session_id'], ENT_QUOTES); // Retrieve session_id from the form

    // Validate client_id
    if (!isValidClient($client_id, $connection)) {
        echo "unkown client_id!";
        exit();
    }

    // Use prepared statement for update
    $stmt = $connection->prepare("UPDATE sessions SET start_time = ?, end_time = ?, location = ?, client_id = ? WHERE session_id = ?");
    $stmt->bind_param("ssssi", $start_time, $end_time, $location, $client_id, $session_id);

    if ($stmt->execute()) {
        // Redirect to sessions.php on successful update
        header('Location: sessions.php');
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
