<?php
// Стартиране на сесията
session_start();

// Включване на конфигурационния файл
include('../database/config.php');

// Проверка и валидация на параметъра "table"
$table = isset($_GET["table"]) ? $_GET["table"] : 'questions';

// Проверка за POST заявка
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Събиране и валидация на въведените данни
    $theme = htmlspecialchars($_POST['theme'], ENT_QUOTES, 'UTF-8');
    $difficulty = filter_var($_POST['difficulty'], FILTER_VALIDATE_INT);

    // Проверка за валидна трудност в скалата от 1 до 10
    if ($difficulty === false || $difficulty < 1 || $difficulty > 10) {
        echo "Невалидна стойност за трудност. Моля, въведете число от 1 до 10.";
        exit;
    }

    // Събиране на данни за въпрос и отговори
    $question = htmlspecialchars($_POST['question'], ENT_QUOTES, 'UTF-8');
    $correct_answer = filter_var($_POST['correct_answer'], FILTER_VALIDATE_INT);
    $answer1 = htmlspecialchars($_POST['answer1'], ENT_QUOTES, 'UTF-8');
    $answer2 = htmlspecialchars($_POST['answer2'], ENT_QUOTES, 'UTF-8');
    $answer3 = htmlspecialchars($_POST['answer3'], ENT_QUOTES, 'UTF-8');
    $answer4 = htmlspecialchars($_POST['answer4'], ENT_QUOTES, 'UTF-8');

    // Събиране на имената на файловете за снимките
    $question_img = $_FILES['question_img']['name'] ?? '';
    $answer1_img = $_FILES['answer1_img']['name'] ?? '';
    $answer2_img = $_FILES['answer2_img']['name'] ?? '';
    $answer3_img = $_FILES['answer3_img']['name'] ?? '';
    $answer4_img = $_FILES['answer4_img']['name'] ?? '';

    // Папка за качване на снимките
    $target_dir = "examp/";

    // SQL заявка за вмъкване на данните в базата данни
    $sql = "INSERT INTO `$table` 
            (`theme`, `difficulty`, `question`, `question_img`, `correct_answer`, 
            `answer1`, `answer1_img`, `answer2`, `answer2_img`, 
            `answer3`, `answer3_img`, `answer4`, `answer4_img`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    // Проверка за грешки при подготовката на заявката
    if ($stmt === false) {
        die("Failed to prepare statement: " . mysqli_error($conn));
    }

    // Привързване на параметрите към заявката
    mysqli_stmt_bind_param(
        $stmt,
        "sssssssssssss",
        $theme,
        $difficulty,
        $question,
        $question_img,
        $correct_answer,
        $answer1,
        $answer1_img,
        $answer2,
        $answer2_img,
        $answer3,
        $answer3_img,
        $answer4,
        $answer4_img
    );

    // Изпълнение на заявката
    $result = mysqli_stmt_execute($stmt);

    // Проверка за грешки при изпълнение на заявката
    if ($result) {
        // Качване на снимките
        uploadImage('question_img', $target_dir, $table);
        uploadImage('answer1_img', $target_dir, $table);
        uploadImage('answer2_img', $target_dir, $table);
        uploadImage('answer3_img', $target_dir, $table);
        uploadImage('answer4_img', $target_dir, $table);

        // Сесия за успешно добавяне на въпрос
        $_SESSION["msg"] = "Въпросът е добавен успешно!";

        // Пренасочване към индекс страницата с параметър "table"
        header("Location: index.php?table=$table");
        exit;
    } else {
        // Извеждане на грешка при неуспешно изпълнение на заявката
        $error_message = "Failed: " . mysqli_error($conn);
        error_log($error_message);
        trigger_error($error_message, E_USER_ERROR);
    }
}

// Функция за генериране на уникални имена на файлове
function generateUniqueFilename($prefix, $extension, $table) {
    $timestamp = time();
    $random_hash = md5(uniqid(rand(), true));
    return "{$prefix}_{$timestamp}_{$random_hash}.{$extension}";
}

// Функция за качване на снимка и актуализация на името в базата данни
function uploadImage($inputName, $targetDir, $table) {
    global $upload_errors, $conn;
    $upload_errors = [];

    // Проверка дали е предоставен файл за качване
    if (!empty($_FILES[$inputName]['name'])) {
        // Извличане на разширението на файла
        $imgExtension = pathinfo($_FILES[$inputName]['name'], PATHINFO_EXTENSION);

        // Генериране на уникално име за файла
        $imgName = generateUniqueFilename($inputName, $imgExtension, $table);
        
        // Път до целевата директория за записване на файловете
        $targetPath = $targetDir . $imgName;

        // Качване на файла
        if (!move_uploaded_file($_FILES[$inputName]['tmp_name'], $targetPath)) {
            // Обработка на грешка при качване на снимка
            $upload_errors[] = "Грешка при качването на снимка за отговор: Файлът не беше качен успешно.";
        }

        // SQL заявка за актуализиране на името на снимката в базата данни
        $sql = "UPDATE `$table` SET `$inputName` = ? WHERE `id` = LAST_INSERT_ID()";
        $stmt = mysqli_prepare($conn, $sql);

        // Проверка за грешки при подготовката на заявката
        if ($stmt === false) {
            die("Failed to prepare statement: " . mysqli_error($conn));
        }

        // Привързване на параметъра към заявката
        mysqli_stmt_bind_param($stmt, "s", $imgName);

        // Изпълнение на заявката
        mysqli_stmt_execute($stmt);
    }
}
?>