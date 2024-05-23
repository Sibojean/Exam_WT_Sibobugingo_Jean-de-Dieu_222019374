<?php
    // Connection details
    include('database_connection.php');

    // Check if form_id is set
    if(isset($_REQUEST['form_id'])) {
        $form_id = $_REQUEST['form_id'];
        
        $stmt = $connection->prepare("SELECT * FROM assessmentforms WHERE form_id=?");
        $stmt->bind_param("i", $form_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $form_name = $row['form_name'];
            $description = $row['description'];
            $created_date = $row['created_date'];
            $client_id = $row['client_id'];
            $session_id = $row['session_id']; // Fetch session_id from database
        } else {
            echo "Form not found.";
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Assessment Form</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <center>
        <!-- Update Assessment Form -->
        <h2><u>Update Form of Assessment</u></h2>
        <form method="POST" onsubmit="return confirmUpdate();">
            <input type="hidden" name="form_id" value="<?php echo $form_id; ?>">
            
            <label for="form_name">Form Name:</label>
            <input type="text" name="form_name" value="<?php echo $form_name; ?>">
            <br><br>

            <label for="description">Description:</label>
            <textarea name="description"><?php echo $description; ?></textarea>
            <br><br>

            <label for="created_date">Created Date:</label>
            <input type="date" name="created_date" value="<?php echo $created_date; ?>">
            <br><br>

            <label for="client_id">Client ID:</label>
            <input type="number" name="client_id" value="<?php echo $client_id; ?>">
            <?php
                // Check if client_id exists in the client table
                $check_client_stmt = $connection->prepare("SELECT * FROM client WHERE client_id=?");
                $check_client_stmt->bind_param("i", $client_id);
                $check_client_stmt->execute();
                $check_client_result = $check_client_stmt->get_result();
                
                if($check_client_result->num_rows == 0) {
                    echo "<span style='color:red;'> Unknown client ID</span>";
                }
            ?>
            <br><br>

            <label for="session_id">Session ID:</label>
            <input type="text" name="session_id" value="<?php echo $session_id; ?>">
            <?php
                // Check if session_id exists in the session table
                $check_session_stmt = $connection->prepare("SELECT * FROM sessions WHERE session_id=?");
                $check_session_stmt->bind_param("s", $session_id);
                $check_session_stmt->execute();
                $check_session_result = $check_session_stmt->get_result();
                
                if($check_session_result->num_rows == 0) {
                    echo "<span style='color:red;'> Unknown session ID</span>";
                }
            ?>
            <br><br>

            <input type="submit" name="up" value="Update">
        </form>
    </center>
</body>
</html>

<?php
if(isset($_POST['up'])) {
    // Retrieve updated values from form
    $form_id = $_POST['form_id'];
    $form_name = $_POST['form_name'];
    $description = $_POST['description'];
    $created_date = $_POST['created_date'];
    $client_id = $_POST['client_id'];
    $session_id = $_POST['session_id']; // Fetch session_id from form
    
    // Check if client_id exists in the client table
    $check_client_stmt = $connection->prepare("SELECT * FROM client WHERE client_id=?");
    $check_client_stmt->bind_param("i", $client_id);
    $check_client_stmt->execute();
    $check_client_result = $check_client_stmt->get_result();
    
    // Check if session_id exists in the session table
    $check_session_stmt = $connection->prepare("SELECT * FROM sessions WHERE session_id=?");
    $check_session_stmt->bind_param("s", $session_id);
    $check_session_stmt->execute();
    $check_session_result = $check_session_stmt->get_result();
    
    if($check_client_result->num_rows == 0 || $check_session_result->num_rows == 0) {
        echo "<p style='color:red;'>Unknown client ID or session ID</p>";
    } else {
        // Update the form record in the database
        $stmt = $connection->prepare("UPDATE assessmentforms SET form_name=?, description=?, created_date=?, client_id=?, session_id=? WHERE form_id=?");
        $stmt->bind_param("sssiis", $form_name, $description, $created_date, $client_id, $session_id, $form_id);
        $stmt->execute();
        
        // Redirect to assessmentforms.php or any other page displaying assessment forms records
        header('Location: assessmentforms.php');
        exit(); // Ensure that no other content is sent after the header redirection
    }
}
?>
