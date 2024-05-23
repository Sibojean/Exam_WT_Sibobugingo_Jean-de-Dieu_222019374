<?php
    // Connection details
    include('database_connection.php');

    // Check if message_id is set
    if(isset($_REQUEST['message_id'])) {
        $message_id = $_REQUEST['message_id'];

        // Prepare and execute the DELETE statement for the chathistory table
        $stmt = $connection->prepare("DELETE FROM chathistory WHERE message_id=?");
        $stmt->bind_param("i", $message_id);

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
                <input type="hidden" name="message_id" value="<?php echo $message_id; ?>">
                <input type="submit" value="Delete">
            </form>

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if ($stmt->execute()) {
                    echo "Record deleted successfully.<br><br>";
                    echo "<a href='chathistory.php'>OK</a>"; // Assuming charthistoys.php is the page displaying chathistory records
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
        echo "message_id is not set.";
    }

    $connection->close();
?>
