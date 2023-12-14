<?php
    require_once("create_control.php");
    include_once("header.php");
?>

<div class="container">
    <div class="text-center mb-4">
        <h4>Добавяне на нов въпрос</h4>
    </div>

    <div class="container d-flex justify-content-center">
        <form action="" method="post" enctype="multipart/form-data" style="width:50vw; min-width:300px;">
            <div class="row mb-3">
                <div class="mb-4">
                    <label class="form-label" for="table">Избери раздел:</label>
                    <select class="form-select" name="table" id="table" required>
                        <option value="">< ----------- ИЗБЕРИ РАЗДЕЛ ----------- ></option>
                        <option value="ear">Слухови задачи (1-4)</option>
                        <option value="theory">Теория на музикалните елементи (5-10)</option>
                        <option value="harmony">Хармония (11-17)</option>
                        <option value="analisys">Музикални форми (18-23)</option>
                        <option value="history">История на музиката (24-30)</option>
                    </select>
                    <input type="hidden" name="table" value="<?= $table ?>">
                </div>
                <div class="col">
                    <label class="form-label" for="theme">Тема:</label>
                    <?php if ($table === 'ear'): ?>
                        <!-- Падащо меню с определени теми за таблицата 'ear' -->
                        <select class="form-select" name="theme" id="theme" required>
                            <option value="Интервали">Интервали</option>
                            <option value="Ладове">Ладове</option>
                            <option value="Акорди">Акорди</option>
                            <option value="Размери">Размери</option>
                            <!-- Добавете още теми, ако е необходимо -->
                        </select>
                    <?php else: ?>
                        <!-- Свободно текстово поле за тема за други таблици -->
                        <input type="text" class="form-control" name="theme" id="theme" required>
                    <?php endif; ?>
                </div>
                <div class="col">
                    <label class="form-label" for="difficulty">Трудност (1-10):</label>
                    <input type="number" class="form-control" name="difficulty" id="difficulty" min="1" max="10" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label" for="question">Въпрос:</label>
                <input type="text" class="form-control" name="question" id="question" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="question_img">Снимка за въпроса:</label>
                <input type="file" class="form-control" name="question_img" id="question_img">
            </div>
            <div class="mb-3">
                <label class="form-label" for="answer1">Отговор 1:</label>
                <input type="radio" id="answer1" name="correct_answer" value="0" required>
                <input type="text" class="form-control" name="answer1" required>
                <label class="form-label" for="answer1_img">Снимка за отговор 1:</label>
                <input type="file" class="form-control" name="answer1_img" id="answer1_img">
            </div>

            <div class="mb-3">
                <label class="form-label" for="answer2">Отговор 2:</label>
                <input type="radio" id="answer2" name="correct_answer" value="1" required>
                <input type="text" class="form-control" name="answer2" required>
                <label class="form-label" for="answer2_img">Снимка за отговор 2:</label>
                <input type="file" class="form-control" name="answer2_img" id="answer2_img">
            </div>

            <div class="mb-3">
                <label class="form-label" for="answer3">Отговор 3:</label>
                <input type="radio" id="answer3" name="correct_answer" value="2" required>
                <input type="text" class="form-control" name="answer3" required>
                <label class="form-label" for="answer3_img">Снимка за отговор 3:</label>
                <input type="file" class="form-control" name="answer3_img" id="answer3_img">
            </div>

            <div class="mb-3">
                <label class="form-label" for="answer4">Отговор 4:</label>
                <input type="radio" id="answer4" name="correct_answer" value="3" required>
                <input type="text" class="form-control" name="answer4" required>
                <label class="form-label" for="answer4_img">Снимка за отговор 4:</label>
                <input type="file" class="form-control" name="answer4_img" id="answer4_img">
            </div>
            <div>
                <button type="submit" class="btn btn-success" name="submit">Добави</button>
                <a href="index.php?table=<?= empty($table) ? 'all' : htmlspecialchars($table) ?>" class="btn btn-danger">Отказ</a>
                <!-- <button type="button" class="btn btn-danger" onclick="goBack()">Отказ</button>
                <script src="styles/js/goBack.js"></script> -->
            </div>
        </form>
    </div>
</div>

<!-- Примерен елемент с id "success-alert" -->
<input type="hidden" name="table" id="success-alert">

<!-- Добавете следния код след формата във файла create.php -->
<?php include("create_js.php"); ?>
