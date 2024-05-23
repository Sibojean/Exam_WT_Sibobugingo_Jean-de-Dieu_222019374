 <?php
    // Connection details
    include('database_connection.php');

    // Check if activity_id is set
    if(isset($_REQUEST['activity_id'])) {
        $aid = $_REQUEST['activity_id'];

        // Prepare and execute the DELETE statement
        $stmt = $connection->prepare("DELETE FROM activities WHERE activity_id=?");
        $stmt->bind_param("i", $aid);

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
                <input type="hidden" name="activity_id" value="<?php echo $aid; ?>">
                <input type="submit" value="Delete">
            </form>

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if ($stmt->execute()) {
                    echo "Record deleted successfully.<br><br>";
                    echo "<a href='activities.php'>OK</a>";
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
        echo "activity_id is not set.";
    }

    $connection->close();
?>
