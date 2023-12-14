<?php
session_start();
include('../database/config.php');

// Дефиниране на валидните таблици
$validTables = ['ear', 'theory', 'harmony', 'analisys', 'history'];

// Проверка за връзка с базата данни
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Проверка за изтриване на отбелязани въпроси от всички таблици
if (isset($_GET['ids'])) {
    $questionIds = explode(',', $_GET['ids']);

    // Преобразуване на индексите на масива с въпроси в числа
    $questionIds = array_map('intval', $questionIds);

    // Подготовка на подготвената заявка за всяка таблица
    foreach ($validTables as $table) {
        $deleteQuery = "DELETE FROM `$table` WHERE id IN (" . implode(',', array_fill(0, count($questionIds), '?')) . ")";
        $stmt = mysqli_prepare($conn, $deleteQuery);

        if ($stmt === false) {
            die("Failed to prepare statement: " . mysqli_error($conn));
        }

        // Свързване на параметрите
        mysqli_stmt_bind_param($stmt, str_repeat('i', count($questionIds)), ...$questionIds);

        $result = mysqli_stmt_execute($stmt);

        if (!$result) {
            $_SESSION["msg"] = "Неуспешно изтриване на въпросите от таблица $table: " . mysqli_error($conn);
            header("Location: index.php");
            exit();
        }
    }

    $_SESSION["msg"] = "Избраните въпроси са изтрити успешно!";
    header("Location: index.php?table=all");
    exit();
}

// Ако няма предоставени идентификатори за изтриване, пренасочваме към индекс страницата
header("Location: index.php");
exit();
?>
