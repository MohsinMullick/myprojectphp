<?php
require 'connect.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location:All_Php_Files/All_Customers_Display_Info.php .php");
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
