<?php
require_once("crud/crud.php");
include_once("header.php");
include_once("crud/index/alerts.php");
?>

<div class="row mb-3">
    <div class="col-lg-6">
        <form method="get">
            <label for="tableSelect" class="form-label">Избиране на раздел:</label>
            <select class="form-select" name="table" id="tableSelect" onchange="this.form.submit()">
                <?php
                $categories = [
                    'all' => 'Всички раздели (1-30)',
                    'ear' => 'Слухови задачи (1-4) <по подразбиране>',
                    'theory' => 'Теория на музикалните елементи (5-10)',
                    'harmony' => 'Хармония (11-17)',
                    'analisys' => 'Музикални форми (18-23)',
                    'history' => 'История на музиката (24-30)'
                ];
                foreach ($categories as $key => $value) : ?>
                    <option value="<?= $key ?>" <?= $table === $key ? 'selected' : '' ?>><?= $value ?></option>
                <?php endforeach; ?>
            </select>

            <label for="questionsPerPage" class="form-label mt-2">Брой въпроси на страница:</label>
            <select class="form-select" name="questionsPerPage" id="questionsPerPage" onchange="updateQuestionsPerPage()">
                <option value="10" <?= $questionsPerPage == 10 ? 'selected' : '' ?>>10</option>
                <option value="20" <?= $questionsPerPage == 20 ? 'selected' : '' ?>>20</option>
                <option value="50" <?= $questionsPerPage == 50 ? 'selected' : '' ?>>50</option>
            </select>

            <input type="hidden" name="questions_per_page" value="<?= $questionsPerPage ?>">

            <button id="deleteBtn" onclick="deleteSelectedQuestions()" class="btn btn-dark mt-2" name="deleteBtn">Изтрий<br>избраните</button>
            <button id="refreshBtn" onclick="refreshPage()" class="btn btn-dark mt-2" name="refreshBtn">Изчисти<br>избраните</button>
            <a href="create.php?table=<?= $table ?>" class="btn btn-dark mt-2">Създай<br>въпрос</a>
            <a href="javascript:void(0);" onclick="openTestGenerationModal()" class="btn btn-dark mt-2">Генерирай<br>тест</a>
            <a href="/mk_test/admin/" class="btn btn-dark mt-2">Обнови<br>страницата</a>
        </form>
    </div>

    <div class="col-lg-6">
        <form method="get" id="searchForm">
            <label for="searchInput" class="form-label">Търсене:</label>
            <input type="text" class="form-control" name="search" id="searchInput"
                value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search'], ENT_QUOTES, 'UTF-8') : '' ?>">

            <input type="hidden" name="table" value="<?= $table ?>">
            <input type="hidden" name="questions_per_page" value="<?= $questionsPerPage ?>">

            <button type="submit" class="btn btn-dark mt-2" name="searchBtn">Търси</button>
            <button type="button" class="btn btn-dark mt-2" onclick="clearSearchForm()">Изчисти</button>
        </form>
    </div>
</div>

<table class="table table-hover text-center">
    <thead class="table-dark">
    <tr>
        <th scope="col">
            <input type="checkbox" id="selectAll" onchange="selectAllQuestions()">
        </th>
        <th scope="col">
            <a href="?table=<?= $table ?>&sort=theme&order=<?= isset($_GET['order']) && $_GET['order'] === 'asc' ? 'desc' : 'asc' ?>">
                Тема <?= $sort === 'theme' ? ($order === 'asc' ? '▲' : '▼') : '' ?>
            </a>
        </th>
        <th scope="col">
            <a href="?table=<?= $table ?>&sort=difficulty&order=<?= isset($_GET['order']) && $_GET['order'] === 'asc' ? 'desc' : 'asc' ?>">
                Трудност <?= $sort === 'difficulty' ? ($order === 'asc' ? '▲' : '▼') : '' ?>
            </a>
        </th>
        <th scope="col">Въпрос</th>
        <th scope="col">Пример</th>
        <?php for ($i = 1; $i <= 4; $i++) : ?>
            <th scope="col">Отговор <?= $i ?></th>
            <th scope="col">Пример <?= $i ?></th>
        <?php endfor; ?>
        <th scope="col">Действия</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if (mysqli_num_rows($result) == 0) : ?>
        <tr>
            <td colspan="13" class="text-center">Няма налични данни. <a href="#" onclick="clearSearch()"
                                                                        title="Обнови">
                    <i class="fas fa-sync-alt fa-2x" style="color: black;"></i></a>
            </td>
        </tr>
    <?php else :
        while ($row = mysqli_fetch_assoc($result)) : ?>
            <tr>
                <td><input type="checkbox" name="checkbox" class="question-checkbox" data-question-id="<?= $row["id"] ?>"></td>
                <td><?= htmlspecialchars($row["theme"], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($row["difficulty"], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($row["question"], ENT_QUOTES, 'UTF-8') ?></td>
                <td>
                    <?php if (!empty($row["question_img"])) : ?>
                        <br>
                        <img src="examp/<?= htmlspecialchars($row["question_img"], ENT_QUOTES, 'UTF-8'); ?>"
                             alt="Нотен пример:" style="max-width: 100px; max-height: 100px;">
                    <?php endif; ?>
                </td>
                <?php for ($i = 1; $i <= 4; $i++) : ?>
                    <td>
                        <?php
                        if ($i - 1 == $row["correct_answer"]) {
                            echo '<b>' . htmlspecialchars($row["answer$i"], ENT_QUOTES, 'UTF-8') . '</b>';
                        } else {
                            echo htmlspecialchars($row["answer$i"], ENT_QUOTES, 'UTF-8');
                        }
                        ?>
                    </td>
                    <td>
                        <?php if (!empty($row["answer{$i}_img"])) : ?>
                            <br>
                            <img src="examp/<?= htmlspecialchars($row["answer{$i}_img"], ENT_QUOTES, 'UTF-8'); ?>"
                                 alt="Answer <?= $i ?> Image" style="max-width: 100px; max-height: 100px;">
                        <?php endif; ?>
                    </td>
                <?php endfor; ?>
                <td>
                    <a href="create.php?id=<?= $row["id"] ?>&table=<?= $table ?>" class="link-dark"><i
                                class="fa-solid fa-square-plus fa-beat fs-5 me-1"></i></a>
                    <a href="javascript:void(0);" onclick="openUpdateModal(<?= $row["id"] ?>, '<?= $table ?>')"
                       class="link-dark"><i class="fa-solid fa-pen-to-square fa-beat fs-5 me-1"></i></a>
                    <a href="#" onclick="confirmDelete(<?= $row["id"] ?>, '<?= $table ?>');"
                       class="link-dark"><i class="fa-solid fa-trash fa-shake fs-5"></i></a>
                </td>
            </tr>
        <?php endwhile;
    endif; ?>
    </tbody>
</table>

<!-- HTML за модалния прозорец -->
<div class="modal" id="updateModal">
    <div class="container">
        <button onclick="closeUpdateModal()"
                class="close-button"><i class="fa-solid fa-square-xmark fa-beat fa-2xl"></i></button>
        <!-- Елемент за съдържанието от update.php -->
        <div id="updateModalContent"></div>
    </div>
</div>

<?php
include_once("crud/index/paginations.php");
include_once("index_js.php");
?>
