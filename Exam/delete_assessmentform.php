<?php
    // Connection details
    include('database_connection.php');

    // Check if form_id is set
    if(isset($_REQUEST['form_id'])) {
        $form_id = $_REQUEST['form_id'];

        // Prepare and execute the DELETE statement for the assessmentforms table
        $stmt = $connection->prepare("DELETE FROM assessmentforms WHERE form_id=?");
        $stmt->bind_param("i", $form_id);

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
                <input type="hidden" name="form_id" value="<?php echo $form_id; ?>">
                <input type="submit" value="Delete">
            </form>

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if ($stmt->execute()) {
                    echo "Record deleted successfully.<br><br>";
                    echo "<a href='assessmentforms.php'>OK</a>"; // Assuming assessmentforms.php is the page displaying assessment form records
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
        echo "form_id is not set.";
    }

    $connection->close();
?>
