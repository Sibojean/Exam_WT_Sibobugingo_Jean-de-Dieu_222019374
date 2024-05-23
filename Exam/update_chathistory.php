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

// Check if message_id is set
if (isset($_REQUEST['message_id'])) {
    $message_id = $_REQUEST['message_id'];

    // Use prepared statement
    $stmt = $connection->prepare("SELECT * FROM chathistory WHERE message_id = ?");
    $stmt->bind_param("i", $message_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $sender_id = htmlspecialchars($row['sender_id'], ENT_QUOTES);
        $receiver_id = htmlspecialchars($row['receiver_id'], ENT_QUOTES);
        $message = htmlspecialchars($row['message'], ENT_QUOTES);
        $timestamp = htmlspecialchars($row['timestamp'], ENT_QUOTES);
    } else {
        echo "Page not found.";
        exit();
    }

    // Close statement
    $stmt->close();
}

// Check if sender_id or receiver_id exists in client table
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
    <title>Update Chat History</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <center>
        <!-- Update chat history form -->
        <h2><u>Update Chat History</u></h2>
        <form method="POST" onsubmit="return confirmUpdate();">
            <input type="hidden" name="message_id" value="<?php echo isset($message_id) ? $message_id : ''; ?>">
            
            <label for="sender_id">Sender ID:</label>
            <input type="text" name="sender_id" value="<?php echo isset($sender_id) ? $sender_id : ''; ?>" required>
            <br><br>

            <label for="receiver_id">Receiver ID:</label>
            <input type="text" name="receiver_id" value="<?php echo isset($receiver_id) ? $receiver_id : ''; ?>" required>
            <br><br>

            <label for="message">Message:</label>
            <input type="text" name="message" value="<?php echo isset($message) ? $message : ''; ?>" required>
            <br><br>

            <label for="timestamp">Timestamp:</label>
            <input type="datetime-local" name="timestamp" value="<?php echo isset($timestamp) ? $timestamp : ''; ?>" required>
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
    $sender_id = htmlspecialchars($_POST['sender_id'], ENT_QUOTES);
    $receiver_id = htmlspecialchars($_POST['receiver_id'], ENT_QUOTES);
    $message = htmlspecialchars($_POST['message'], ENT_QUOTES);
    $timestamp = htmlspecialchars($_POST['timestamp'], ENT_QUOTES);
    $message_id = htmlspecialchars($_POST['message_id'], ENT_QUOTES); // Retrieve message_id from the form

    // Validate sender_id and receiver_id
    if (!isValidClient($sender_id, $connection) || !isValidClient($receiver_id, $connection)) {
        echo "Invalid sender or receiver ID";
        exit();
    }

    // Use prepared statement for update
    $stmt = $connection->prepare("UPDATE chathistory SET sender_id = ?, receiver_id = ?, message = ?, timestamp = ? WHERE message_id = ?");
    $stmt->bind_param("iissi", $sender_id, $receiver_id, $message, $timestamp, $message_id);

    if ($stmt->execute()) {
        // Redirect to chathistory.php on successful update
        header('Location: chathistory.php');
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
