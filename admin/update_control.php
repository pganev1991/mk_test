<?php
session_start();
require_once('../database/config.php');

$id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;
$table = isset($_GET["table"]) ? $_GET["table"] : 'ear';

// Дефиниране на темите за падащия списък
$allowedThemes = ['Интервали', 'Ладове', 'Акорди', 'Размери'];

if ($id <= 0) {
    echo "Invalid question identifier.";
    exit;
}

if ($table !== 'all') {
    $sql = "SELECT * FROM $table WHERE id = ? LIMIT 1";
    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        die("Failed to prepare statement: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "i", $id);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        $result_set = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result_set);
    } else {
        echo "Failed: " . mysqli_error($conn);
        exit;
    }
} else {
    $sql = "SELECT * FROM ear WHERE id = ? 
            UNION ALL 
            SELECT * FROM theory WHERE id = ? 
            UNION ALL 
            SELECT * FROM harmony WHERE id = ? 
            UNION ALL 
            SELECT * FROM analisys WHERE id = ? 
            UNION ALL 
            SELECT * FROM history WHERE id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        die("Failed to prepare statement: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "iiiii", $id, $id, $id, $id, $id);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        $result_set = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result_set);
    } else {
        echo "Failed: " . mysqli_error($conn);
        exit;
    }
}

if (isset($_POST["submit"])) {
    $theme = $_POST['theme'];

    if ($table === 'ear' && !in_array($theme, $allowedThemes)) {
        echo "Невалидна тема. Моля, изберете от списъка.";
        exit;
    }

    $difficulty = $_POST['difficulty'];

    if (!is_numeric($difficulty) || $difficulty < 1 || $difficulty > 10) {
        echo "Невалидна стойност за трудност. Моля, въведете число от 1 до 10.";
        exit;
    }

    $question = $_POST['question'];
    $correct_answer = isset($_POST['correct_answer']) ? intval($_POST['correct_answer']) : 0;

    if (!is_numeric($correct_answer) || $correct_answer < 0 || $correct_answer > 3) {
        echo "Невалиден коректен отговор. Моля, изберете отговор от 0 до 3.";
        exit;
    }

    $answer1 = $_POST['answer1'];
    $answer2 = $_POST['answer2'];
    $answer3 = $_POST['answer3'];
    $answer4 = $_POST['answer4'];

    function generateUniqueFilename($prefix, $extension) {
        $timestamp = time();
        $random_hash = md5(uniqid(rand(), true));
        return "{$prefix}_{$timestamp}_{$random_hash}.{$extension}";
    }

    $question_img = $row['question_img'];
    $answer1_img = $row['answer1_img'];
    $answer2_img = $row['answer2_img'];
    $answer3_img = $row['answer3_img'];
    $answer4_img = $row['answer4_img'];

    $allowed_image_types = ['image/jpeg', 'image/png', 'image/gif'];
    foreach (['question_img', 'answer1_img', 'answer2_img', 'answer3_img', 'answer4_img'] as $imgField) {
        if (!empty($_FILES[$imgField]['type']) && in_array($_FILES[$imgField]['type'], $allowed_image_types)) {
            // Проверка дали файлът е изображение
            $image_info = getimagesize($_FILES[$imgField]['tmp_name']);
            if ($image_info === false) {
                echo "Невалиден файл за $imgField. Моля, качете валидно изображение.";
                exit;
            }
    
            $imgExtension = pathinfo($_FILES[$imgField]['name'], PATHINFO_EXTENSION);
            $imgName = generateUniqueFilename($imgField, $imgExtension);
            move_uploaded_file($_FILES[$imgField]['tmp_name'], 'examp/' . $imgName);
            ${$imgField} = $imgName;
        }
    }    

    $sql = "UPDATE $table SET `theme`=?, `difficulty`=?, `question`=?, `question_img`=?, `correct_answer`=?, `answer1`=?, `answer1_img`=?, `answer2`=?, `answer2_img`=?, `answer3`=?, `answer3_img`=?, `answer4`=?, `answer4_img`=? WHERE id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        die("Failed to prepare statement: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param(
        $stmt,
        "sssssssssssssi",
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
        $answer4_img,
        $id
    );

    $result = mysqli_stmt_execute($stmt);
    mysqli_begin_transaction($conn);

    if ($result) {
        $_SESSION["msg"] = "Въпросът е редактиран успешно!";
        header("Location: index.php?table=$table");
        exit;
    } else {
        mysqli_rollback($conn);
        echo "Failed: " . mysqli_error($conn);
    }    
}

if (isset($_SESSION["msg"])) :
    ?>
    <div id="success-alert" class="alert alert-success alert-dismissible fade show" role="alert">
        <?= $_SESSION["msg"] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php
unset($_SESSION["msg"]);
endif;
?>