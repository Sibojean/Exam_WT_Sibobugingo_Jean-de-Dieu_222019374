<?php
    // Connection details
    include('database_connection.php');

    // Check if therapist_id is set
    if(isset($_REQUEST['therapist_id'])) {
        $therapist_id = $_REQUEST['therapist_id'];

        // Prepare and execute the DELETE statement for the therapists table
        $stmt = $connection->prepare("DELETE FROM therapists WHERE therapist_id=?");
        $stmt->bind_param("i", $therapist_id);

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
                <input type="hidden" name="therapist_id" value="<?php echo $therapist_id; ?>">
                <input type="submit" value="Delete">
            </form>

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if ($stmt->execute()) {
                    echo "Record deleted successfully.<br><br>";
                    echo "<a href='therapists.php'>OK</a>"; // Assuming therapists.php is the page displaying client records
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
        echo "therapist_id is not set.";
    }

    $connection->close();
?>
 