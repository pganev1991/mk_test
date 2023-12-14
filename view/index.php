<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ДЗ по ТП: Първи модул</title>
    <!-- Включване на Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="styles/css/style.css">
</head>
<body>
    <center><img src="styles/img/logo_ministry.png" alt="Министерство на културата" style="max-height: 160px;"></center>
    <nav class="navbar navbar-light justify-content-center fs-3 mb-1"
    style="background-color: #CCCCCC;"><center><p><b>Държавен зрелостен изпит по Теория на професията</b></p></center></nav>
    <center>
        <p><b>Първи модул: въпроси със затворен отговор</b></p>
        <p><b>Тест №: <?= uniqid() ?></b></p>
    </center>
    <?php
    if (!isset($_GET['modal'])) {
        echo '<form method="post">';
        echo '<center><input type="submit" name="refresh" value="Генериране" class="refresh-button"></center>';
        echo '</form><br>';
    } else {
        echo '<center><button id="refreshButton" class="btn btn-dark">Генериране</button></center>';
    }
    ?>
    <div class="container mt-4">
        <?php
            include('../database/config.php');
            include('../view/questions.php');
            include('../view/additional_f.php');
        ?>
        <center><button class="btn btn-dark" data-export="exclude" onclick="exportToDoc()">Изтегли</button></center>
        <!-- <button class="btn btn-dark" data-export="exclude" onclick="topFunction()" id="topBtn" title="Нагоре">↑</button> -->
        <!-- Добавяне на таблица с номерата на въпросите и отговорите -->
<div class="container mt-4">
    <!-- Код за въпросите и отговорите, който вече имате -->

    <!-- Таблица с номерата на въпросите и отговорите -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">Въпрос №</th>
                <th scope="col">Верен отговор</th>
                <th scope="col">Брой точки</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if (isset($finalQuestions) && is_array($finalQuestions)) {
            foreach ($finalQuestions as $index => $question) {
                echo '<tr>';
                echo '<td>' . ($index + 1) . '</td>';  // Номер на въпроса
                echo '<td>' . $question['correct_answer'] . '</td>';  // Буквен отговор
                echo '<td>' . '1' . '</td>'; // Точки
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="3">Невъзможно извличане на данните.</td></tr>';
        }
        ?>
        </tbody>
    </table>
</div>

    </div>

    <!-- Включване на Bootstrap JS и Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

    <!-- Включване на jQuery 3.6.4 -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    
    <!-- Включване на необходимите скриптове -->
    <script src="../view/styles/js/html-docx.js"></script>
    <script src="../view/styles/js/export.js"></script>
    <!-- <script src="../view/styles/js/top.js"></script> -->
</body>
</html>