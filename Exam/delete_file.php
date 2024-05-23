<?php
    // Connection details
    include('database_connection.php');

    // Check if file_id is set
    if(isset($_REQUEST['file_id'])) {
        $file_id = $_REQUEST['file_id'];

        // Prepare and execute the DELETE statement for the files table
        $stmt = $connection->prepare("DELETE FROM files WHERE file_id=?");
        $stmt->bind_param("i", $file_id);

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
                <input type="hidden" name="file_id" value="<?php echo $file_id; ?>">
                <input type="submit" value="Delete">
            </form>

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if ($stmt->execute()) {
                    echo "Record deleted successfully.<br><br>";
                    echo "<a href='files.php'>OK</a>"; // Assuming files.php is the page displaying file records
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
        echo "file_id is not set.";
    }

    $connection->close();
?>
