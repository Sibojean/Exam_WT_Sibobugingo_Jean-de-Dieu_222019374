<?php
    // Connection details
    include('database_connection.php');

    // Check if session_id is set
    if(isset($_REQUEST['session_id'])) {
        $session_id = $_REQUEST['session_id'];

        // Prepare and execute the DELETE statement for the sessions table
        $stmt = $connection->prepare("DELETE FROM sessions WHERE session_id=?");
        $stmt->bind_param("i", $session_id);

        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Delete Record</title>
            <script>
                function confirmDelete() {
                    return confirm("Are you sure you want to delete this record?");
                }
            </script>
        </head>
        <body>
            <form method="post" onsubmit="return confirmDelete();">
                <input type="hidden" name="session_id" value="<?php echo $session_id; ?>">
                <input type="submit" value="Delete">
            </form>

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if ($stmt->execute()) {
                    echo "Record deleted successfully.<br><br>";
                    echo "<a href='sessions.php'>OK</a>"; // Assuming sessions.php is the page displaying session records
                } else {
                    echo "Error deleting data: " . $stmt->error;
                }
            }
            ?>
        </body>
        </html>
        <?php

        $stmt->close();
    } else {
        echo "session_id is not set.";
    }

    $connection->close();
?>
