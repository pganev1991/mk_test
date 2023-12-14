<?php
require_once("../database/config.php");

$realTable = isset($_GET["table"]) ? $_GET["table"] : '';

if ($realTable === 'all' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Проверка на съответната таблица по id и редирекция
    $tables = ['ear', 'theory', 'harmony', 'analisys', 'history'];

    foreach ($tables as $table) {
        $sql = "SELECT COUNT(*) as count FROM $table WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $id);
            $result = mysqli_stmt_execute($stmt);

            if ($result) {
                $result_set = mysqli_stmt_get_result($stmt);
                $row = mysqli_fetch_assoc($result_set);

                if ($row['count'] > 0) {
                    // Пренасочване към реалната таблица с параметри за редакция
                    header("Location: update.php?id=$id&table=$table");
                    exit;
                }
            }
        }
    }

    // Ако не е намерена подходяща таблица, може да изведете съобщение за грешка
    echo "Грешка: Въпросът не беше намерен в нито една от реалните таблиците.";
    exit;
}
?>
