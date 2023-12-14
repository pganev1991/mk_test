<?php
session_start();
include('../database/config.php');

$id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;
$table = isset($_GET["table"]) ? $_GET["table"] : 'ear';

if ($id <= 0) {
    echo "Невалиден идентификатор на въпрос.";
    exit;
}

// Изтриване на записа от базата данни
$sql = "DELETE FROM `$table` WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);

if ($stmt === false) {
    die("Failed to prepare statement: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "i", $id);
$result = mysqli_stmt_execute($stmt);

if ($result) {
    $_SESSION["msg"] = "Въпросът е изтрит успешно!";
} else {
    $_SESSION["msg"] = "Неуспешно изтриване на въпрос: " . mysqli_error($conn);
}

header("Location: index.php?table=$table");
exit;
?>
