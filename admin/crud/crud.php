<?php
session_start();
include('../database/config.php');

// Дефиниране на валидните таблици
$validTables = ['ear', 'theory', 'harmony', 'analisys', 'history'];

// Проверка за връзка с базата данни
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Избор на таблица - по подразбиране "Слухови задачи (1-4) /ear/"
$table = isset($_GET['table']) ? mysqli_real_escape_string($conn, $_GET['table']) : 'ear';

// Проверка за съществуването на таблицата "all"
if ($table === 'all') {
    $allTableExists = false;
    foreach ($validTables as $validTable) {
        if ($validTable !== 'all' && tableExists($conn, $validTable)) {
            $allTableExists = true;
            break;
        }
    }

    if (!$allTableExists) {
        die("Table 'all' does not exist and cannot be used.");
    }
}

// Брой въпроси на страница
$questionsPerPage = isset($_GET['questions_per_page']) ? (int)$_GET['questions_per_page'] : 10;

// Номер на текущата страница
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Изчисляване на офсета за заявката
$offset = ($currentPage - 1) * $questionsPerPage;

// Търсене
$searchCondition = '';
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    if ($table === 'all') {
        $searchCondition = "WHERE theme LIKE '%$search%' OR question LIKE '%$search%' OR answer1 LIKE '%$search%' OR answer2 LIKE '%$search%' OR answer3 LIKE '%$search%' OR answer4 LIKE '%$search%'";
    } else {
        $searchCondition = "WHERE theme LIKE '%$search%' OR question LIKE '%$search%' OR answer1 LIKE '%$search%' OR answer2 LIKE '%$search%' OR answer3 LIKE '%$search%' OR answer4 LIKE '%$search%' AND '$table'";
    }
}

// Извличане на таблиците за падащия списък
$tableOptions = ['ear', 'theory', 'harmony', 'analisys', 'history'];
array_unshift($tableOptions, 'all'); // Добавяме опцията "ВСИЧКИ РАЗДЕЛИ"

// Сортиране
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'id'; // Полето, по което се сортира (по подразбиране е 'id')
$order = isset($_GET['order']) && in_array($_GET['order'], ['asc', 'desc']) ? $_GET['order'] : 'asc'; // Посока на сортиране (по подразбиране е 'asc')
$orderByClause = "ORDER BY $sort $order";

// Извличане на съобщението за успешно добавяне от сесията
$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';

// Изчистване на сесията, за да не се показва съобщението повече от веднъж
unset($_SESSION['success_message']);

// SQL заявка за извличане на данните с пагинация
$sql = "";
$countSql = "";
if ($table === 'all' && $allTableExists) {
    $sql = "SELECT * FROM (
        SELECT * FROM `ear` $searchCondition
        UNION ALL
        SELECT * FROM `theory` $searchCondition
        UNION ALL
        SELECT * FROM `harmony` $searchCondition
        UNION ALL
        SELECT * FROM `analisys` $searchCondition
        UNION ALL
        SELECT * FROM `history` $searchCondition
    ) AS combined_data $orderByClause LIMIT $offset, $questionsPerPage";
    $countSql = "SELECT COUNT(*) as count FROM (
        SELECT * FROM `ear` $searchCondition
        UNION ALL
        SELECT * FROM `theory` $searchCondition
        UNION ALL
        SELECT * FROM `harmony` $searchCondition
        UNION ALL
        SELECT * FROM `analisys` $searchCondition
        UNION ALL
        SELECT * FROM `history` $searchCondition
    ) AS combined_data";
} else {
    $sql = "SELECT * FROM `$table` $searchCondition $orderByClause LIMIT $offset, $questionsPerPage";
    $countSql = "SELECT COUNT(*) as count FROM `$table` $searchCondition";
}

$result = mysqli_query($conn, $sql);

$countResult = mysqli_query($conn, $countSql);
$totalRecords = mysqli_fetch_assoc($countResult)['count'];

// Изчисляване на общия брой страници
$totalPages = ceil($totalRecords / $questionsPerPage);

// Линкове към следваща и предишна страница
$nextPage = $currentPage + 1;
$prevPage = $currentPage - 1;
$nextLink = "?table=$table&sort=$sort&order=$order&page=$nextPage&questions_per_page=$questionsPerPage";
$prevLink = "?table=$table&sort=$sort&order=$order&page=$prevPage&questions_per_page=$questionsPerPage";

// Функция за проверка на съществуването на таблица
function tableExists($conn, $table) {
    $result = $conn->query("SHOW TABLES LIKE '$table'");
    return $result->num_rows > 0;
}

?>
