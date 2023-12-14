<?php
session_start();
include('../database/config.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Проверка дали параметърите "image_name", "id", "table", и "field" са предоставени
    if (!isset($_POST["image_name"]) || !isset($_POST["id"]) || !isset($_POST["table"]) || !isset($_POST["field"])) {
        die("Missing parameters");
    }

    $image_name = $_POST["image_name"];
    $id = intval($_POST["id"]);
    $table = $_POST["table"];
    $field = $_POST["field"];

    // Изтриване на снимката от папката
    $image_path = 'examp/' . $image_name;
    if (file_exists($image_path) && unlink($image_path)) {
        // Нулиране на съответната колона в базата данни
        $sql = "UPDATE `$table` SET `$field` = NULL WHERE `id` = ?";
        $stmt = mysqli_prepare($conn, $sql);
        
        if (!$stmt) {
            die("Failed to prepare statement: " . mysqli_error($conn));
        }
        
        mysqli_stmt_bind_param($stmt, "i", $id);
        $result = mysqli_stmt_execute($stmt);
        
        if (!$result) {
            die("Failed to update database: " . mysqli_error($conn));
        }
        
        echo "Снимката е изтрита успешно!";

        // Затваряне на prepared statement
        mysqli_stmt_close($stmt);
    } else {
        echo "Failed to delete image file or file does not exist. Path: $image_path";
    }
} else {
    die("Invalid request method");
}
?>
