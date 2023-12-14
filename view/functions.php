<?php
if (!function_exists('getQuestions')) {
    function getQuestions($db, $table) {
        $query = "SELECT * FROM $table";
        $result = $db->query($query);

        if (!$result) {
            die('Грешка при изпълнение на заявката: ' . $db->error);
        }

        $questions = [];

        while ($row = $result->fetch_assoc()) {
            $questions[] = $row;
        }

        return $questions;
    }
}

function displayQuestions($questions, $desiredOrder, $startNumber) {
    shuffle($questions);

    $groupedQuestions = [];

    foreach ($questions as $question) {
        $theme = $question['theme'];
        if (!isset($groupedQuestions[$theme])) {
            $groupedQuestions[$theme] = [];
        }
        $groupedQuestions[$theme][] = $question;
    }

    $finalQuestions = [];

    if ($desiredOrder !== null) {
        foreach ($desiredOrder as $theme) {
            if (isset($groupedQuestions[$theme])) {
                $finalQuestions[] = array_shift($groupedQuestions[$theme]);
            }
        }
    } else {
        // Ако не е зададен списък с теми, вземаме всички въпроси
        foreach ($groupedQuestions as $themeQuestions) {
            $finalQuestions = array_merge($finalQuestions, $themeQuestions);
        }
    }

    foreach ($finalQuestions as $index => $question) {
        $questionNumber = $startNumber + $index;

        // Започваме контейнера за въпроса
        echo '<div class="question-container">';

        // echo '<p>' . $questionNumber . '. Въпрос. Тема: ' . $question['theme'] . ', Трудност: ' . $question['difficulty'] . '</p>';
        // echo '<p>Въпрос: <strong>' . $question['question'] . '</strong></p>';
        echo '<p><strong>' . $questionNumber . '. ' . $question['question'] . '</strong></p>';

        if (!empty($question['question_img'])) {
            $imagePath = '/mk_test/admin/examp/' . $question['question_img'];
            echo '<img src="' . $imagePath . '" alt="Снимка на въпроса" style="max-width: 400px; height: auto;">';
        }        

        $letters = ['А)', 'Б)', 'В)', 'Г)'];
        $answers = [
            ['text' => $question['answer1'], 'img' => $question['answer1_img']],
            ['text' => $question['answer2'], 'img' => $question['answer2_img']],
            ['text' => $question['answer3'], 'img' => $question['answer3_img']],
            ['text' => $question['answer4'], 'img' => $question['answer4_img']],
        ];

        $correctAnswer = $answers[$question['correct_answer']];
        $correctAnswerText = $correctAnswer['text'];
        unset($answers[$question['correct_answer']]);

        shuffle($answers);

        $correctIndex = rand(0, count($answers));
        array_splice($answers, $correctIndex, 0, [$correctAnswer]);

        foreach ($letters as $i => $letter) {
            echo '<p>';
            if ($answers[$i]['text'] == $correctAnswerText) {
                echo $letter . ' <strong>' . $answers[$i]['text'] . '</strong>';
            } else {
                echo $letter . ' ' . $answers[$i]['text'];
            }

            if (!empty($answers[$i]['img'])) {
                $imgPath = '/mk_test/admin/examp/' . $answers[$i]['img'];
                echo '<img src="' . $imgPath . '" alt="Снимка на отговор ' . $i . '" style="max-width: 200px; height: auto;">';
            }

            echo '</p>';
        }

        // Затваряме контейнера за въпроса
        echo '</div>';
    }
}
?>