<?php
session_start();
include('../database/config.php');

// Дефиниране на валидните таблици
$validTables = ['ear', 'theory', 'harmony', 'analisys', 'history'];

// Проверка за връзка с базата данни
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Проверка дали е предоставен идентификатор на запис
if (isset($_GET["id"]) && isset($_GET["table"])) {
    $id = intval($_GET["id"]);
    $table = isset($_GET["table"]) ? mysqli_real_escape_string($conn, $_GET["table"]) : '';

    if ($id > 0 && in_array($table, $validTables)) {
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
    }
}

// Проверка за изтриване на отбелязани въпроси от текущата таблица
if (isset($_GET['ids']) && isset($_GET['table'])) {
    $questionIds = explode(',', $_GET['ids']);
    $table = mysqli_real_escape_string($conn, $_GET['table']);

    if ($table === 'all') {
        // Използвайте delete_all.php за изтриване от всички таблици
        header("Location: delete_all.php?ids=" . $_GET['ids']);
        exit();
    } elseif (in_array($table, $validTables)) {
        // Използвайте текущия код за изтриване от конкретната таблица
        $placeholders = implode(',', array_fill(0, count($questionIds), '?'));
        $sql = "DELETE FROM `$table` WHERE id IN ($placeholders)";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt === false) {
            die("Failed to prepare statement: " . mysqli_error($conn));
        }

        $questionIds = array_map('intval', $questionIds);
        mysqli_stmt_bind_param($stmt, str_repeat('i', count($questionIds)), ...$questionIds);

        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            $_SESSION["msg"] = "Избраните въпроси са изтрити успешно!";
        } else {
            $_SESSION["msg"] = "Неуспешно изтриване на въпросите: " . mysqli_error($conn);
        }

        header("Location: index.php?table=$table");
        exit();
    }
}

// Ако няма предоставени идентификатори за изтриване или не сме в подходяща таблица, пренасочваме към индекс страницата
header("Location: index.php");
exit();
?>