<?php
include('../database/config.php');
include('../view/functions.php');

$db = new mysqli($servername, $username, $password, $dbname);

if ($db->connect_error) {
    die('Грешка при свързване с базата данни: ' . $db->connect_error);
}

// Проверете дали бутона за обновление е бил натиснат
if (isset($_POST['refresh'])) {
    // Редиректнете към същата страница за обновление
    header('Location: ' . $_SERVER['PHP_SELF'] . (isset($_GET['modal']) ? '?modal=1' : ''));
    exit();
}

// // Проверка за параметъра modal - ако е включен, не показваме бутона
// if (!isset($_GET['modal'])) {
//     // Добавете бутона за обновление на страницата
//     echo '<form method="post">';
//     echo '<center><input type="submit" name="refresh" value="Генериране на нов тест" class="refresh-button"></center>';
//     echo '</form><br>';
// }

// Теми за таблица 'ear'
$themesEar = ['Интервали', 'Ладове', 'Акорди', 'Размери'];
$questionsEar = getQuestions($db, 'ear');
displayQuestions($questionsEar, $themesEar, 1);

// Теми за останалите таблици
$themesOther = getUniqueThemes($db, ['theory', 'harmony', 'analisys', 'history']);
displayQuestionsForTables($db, 'theory', $themesOther, 5);
displayQuestionsForTables($db, 'harmony', $themesOther, 11);
displayQuestionsForTables($db, 'analisys', $themesOther, 18);
displayQuestionsForTables($db, 'history', $themesOther, 24);

$db->close();

function getUniqueThemes($db, $tables) {
    $themes = [];
    foreach ($tables as $table) {
        $questions = getQuestions($db, $table);
        foreach ($questions as $question) {
            $themes[] = $question['theme'];
        }
    }
    return array_unique($themes);
}

function displayQuestionsForTables($db, $table, $themes, $startNumber) {
    $questions = getQuestions($db, $table);
    displayQuestions($questions, $themes, $startNumber);
}
?>