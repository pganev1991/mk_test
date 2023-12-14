<?php
require_once("check_tables.php");
require_once("update_control.php");
require_once("header.php");
?>
<div class="container">
    <div class="text-center mb-4">
        <h4>Редактиране на въпрос от раздел
            <?php
            $tableLabels = [
                'ear' => 'Слухови задачи',
                'theory' => 'Теория на музикалните елементи',
                'harmony' => 'Хармония',
                'analisys' => 'Музикални форми',
            ];

            $defaultLabel = 'История на музиката';

            echo '<b>' . ($tableLabels[$table] ?? $defaultLabel) . '</b>';
            ?>
        </h4>
    </div>
    <div class="container d-flex justify-content-center">
        <form action="update.php?id=<?= $id ?>&table=<?= $table ?>" method="post" enctype="multipart/form-data" style="width:50vw; min-width:300px;">
            <div class="row mb-3">
                <div class="col">
                    <label class="form-label" for="theme">Тема:</label>
                    <?php if ($table === 'ear') : ?>
                        <select id="theme" class="form-select" name="theme" required>
                            <?php foreach ($allowedThemes as $allowedTheme) : ?>
                                <option value="<?= $allowedTheme ?>" <?= ($row['theme'] === $allowedTheme) ? 'selected' : '' ?>><?= $allowedTheme ?></option>
                            <?php endforeach; ?>
                        </select>
                    <?php else : ?>
                        <input type="text" id="theme" class="form-control" name="theme" value="<?= htmlspecialchars($row['theme']) ?>" required>
                    <?php endif; ?>
                </div>
                <div class="col">
                    <label class="form-label" for="difficulty">Трудност (1-10):</label>
                    <input type="number" id="difficulty" class="form-control" name="difficulty" min="1" max="10" value="<?= htmlspecialchars($row['difficulty']) ?>" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label" for="question">Въпрос:</label>
                <input type="text" id="question" class="form-control" name="question" value="<?= htmlspecialchars($row['question']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label" for="question_img">Снимка за въпроса:</label>
                <input type="file" id="question_img" class="form-control" name="question_img">
                <?php
                $question_img_path = 'examp/' . htmlspecialchars($row['question_img']);
                if (!empty($row['question_img']) && file_exists($question_img_path)) :
                    ?>
                    <br>
                    <a href="<?= $question_img_path ?>" target="_blank">
                        <img src="<?= $question_img_path ?>" alt="Нотен пример: " id="questionImage" style="max-width: 200px; max-height: 200px;">
                    </a>
                    <button type="button" class="btn" id="deleteImageButton" onclick="deleteImage('<?= $row['id'] ?>', '<?= $row['question_img'] ?>', '<?= $table ?>', 'question_img', 'questionImage', 'deleteImageButton')"><i class="fa-solid fa-trash fs-5"></i></button>
                <?php endif; ?>
            </div>

            <!-- Отговор 1 -->
            <div class="mb-3">
                <label class="form-label" for="answer1">Отговор 1:</label>
                <input type="radio" id="answer1" name="correct_answer" value="0" <?= ($row["correct_answer"] == '0') ? "checked" : ""; ?> required>
                <input type="text" class="form-control" name="answer1" value="<?= htmlspecialchars($row['answer1']) ?>" required>
                <label class="form-label" for="answer1_img">Снимка за отговор 1:</label>
                <input type="file" id="answer1_img" class="form-control" name="answer1_img">
                <?php displayDeleteButton($row, $table, 'answer1_img', 'deleteAnswer1Button', 'answer1Image', 'deleteAnswer1Image'); ?>
            </div>

            <!-- Отговор 2 -->
            <div class="mb-3">
                <label class="form-label" for="answer2">Отговор 2:</label>
                <input type="radio" id="answer2" name="correct_answer" value="1" <?= ($row["correct_answer"] == '1') ? "checked" : ""; ?> required>
                <input type="text" class="form-control" name="answer2" value="<?= htmlspecialchars($row['answer2']) ?>" required>
                <label class="form-label" for="answer2_img">Снимка за отговор 2:</label>
                <input type="file" id="answer2_img" class="form-control" name="answer2_img">
                <?php displayDeleteButton($row, $table, 'answer2_img', 'deleteAnswer2Button', 'answer2Image', 'deleteAnswer2Image'); ?>
            </div>

            <!-- Отговор 3 -->
            <div class="mb-3">
                <label class="form-label" for="answer3">Отговор 3:</label>
                <input type="radio" id="answer3" name="correct_answer" value="2" <?= ($row["correct_answer"] == '2') ? "checked" : ""; ?> required>
                <input type="text" class="form-control" name="answer3" value="<?= htmlspecialchars($row['answer3']) ?>" required>
                <label class="form-label" for="answer3_img">Снимка за отговор 3:</label>
                <input type="file" id="answer3_img" class="form-control" name="answer3_img">
                <?php displayDeleteButton($row, $table, 'answer3_img', 'deleteAnswer3Button', 'answer3Image', 'deleteAnswer3Image'); ?>
            </div>

            <!-- Отговор 4 -->
            <div class="mb-3">
                <label class="form-label" for="answer4">Отговор 4:</label>
                <input type="radio" id="answer4" name="correct_answer" value="3" <?= ($row["correct_answer"] == '3') ? "checked" : ""; ?> required>
                <input type="text" class="form-control" name="answer4" value="<?= htmlspecialchars($row['answer4']) ?>" required>
                <label class="form-label" for="answer4_img">Снимка за отговор 4:</label>
                <input type="file" id="answer4_img" class="form-control" name="answer4_img">
                <?php displayDeleteButton($row, $table, 'answer4_img', 'deleteAnswer4Button', 'answer4Image', 'deleteAnswer4Image'); ?>
            </div>

            <?php
            function displayDeleteButton($row, $table, $field, $deleteButtonId, $imageElementId, $deleteImageButtonId)
            {
                $img_path = 'examp/' . htmlspecialchars($row[$field]);
                if (!empty($row[$field]) && file_exists($img_path)) :
                    ?>
                    <br>
                    <a href="<?= $img_path ?>" target="_blank">
                        <img src="<?= $img_path ?>" alt="Нотен пример: " style="max-width: 200px; max-height: 200px;" id="<?= $imageElementId ?>">
                    </a>
                    <button type="button" class="btn" onclick="deleteImage('<?= $row['id'] ?>', '<?= $row[$field] ?>', '<?= $table ?>', '<?= $field ?>', '<?= $imageElementId ?>', '<?= $deleteButtonId ?>')" id="<?= $deleteButtonId ?>"><i class="fa-solid fa-trash fs-5"></i></button>
                <?php endif; ?>
                <?php if (empty($row[$field]) || !file_exists($img_path)) : ?>
                    <button type="button" class="btn" onclick="deleteImage('<?= $row['id'] ?>', '', '<?= $table ?>', '<?= $field ?>', '<?= $imageElementId ?>', '<?= $deleteButtonId ?>')" style="display: none;" id="<?= $deleteButtonId ?>"><i class="fa-solid fa-trash fs-5"></i></button>
                <?php endif;
            } ?>

            <div>
                <button type="submit" class="btn btn-success" name="submit">Запомни</button>
            </div>
        </form>
    </div>
</div>
<!-- Примерен елемент с id "success-alert" -->
<input type="hidden" name="update" id="success-alert">
<input type="hidden" name="delete" id="success-alert">
<?php include("update_js.php"); ?>
