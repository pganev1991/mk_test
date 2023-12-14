<?php
function displayQuestion($questionNumber, $question) {
    // echo '<p>' . $questionNumber . '. Въпрос. Тема: ' . $question['theme'] . ', Трудност: ' . $question['difficulty'] . '</p>';
    // echo '<p>Въпрос: <strong>' . $question['question'] . '</strong></p>';
    echo '<p><strong>' . $questionNumber . '. ' . $question['question'] . '</strong></p>';
    
    if (!empty($question['question_img'])) {
        echo '<img src="examp/' . $question['question_img'] . '" alt="Снимка на въпроса" style="max-width: 400px; height: auto;">';
    }

    $letters = ['А)', 'Б)', 'В)', 'Г)'];
    $answers = [
        $question['answer1'],
        $question['answer2'],
        $question['answer3'],
        $question['answer4']
    ];

    $correctAnswerText = $answers[$question['correct_answer'] - 1];
    unset($answers[$question['correct_answer'] - 1]);

    shuffle($answers);

    $correctIndex = rand(0, count($answers));
    array_splice($answers, $correctIndex, 0, $correctAnswerText);

    foreach ($letters as $i => $letter) {
        echo '<p>';
        if ($answers[$i] == $correctAnswerText) {
            echo $letter . ' <strong>' . $answers[$i] . '</strong>';
        } else {
            echo $letter . ' ' . $answers[$i];
        }

        echo '</p>';
    }
    echo '</div>';
}

function calculateTotalDifficulty($themes, $db) {
    $totalDifficulty = 0;

    foreach ($themes as $theme) {
        $query = "SELECT * FROM history WHERE theme = '$theme'";
        $result = $db->query($query);

        if (!$result) {
            die('Грешка при изпълнение на заявката: ' . $db->error);
        }

        while ($row = $result->fetch_assoc()) {
            $totalDifficulty += $row['difficulty'];
        }
    }

    return $totalDifficulty;
}

function getFinalQuestionsHistory($themes, $totalDifficulty, $db) {
    $finalQuestionsHistory = [];

    foreach ($themes as $theme) {
        $query = "SELECT * FROM history WHERE theme = '$theme'";
        $result = $db->query($query);

        if (!$result) {
            die('Грешка при изпълнение на заявката: ' . $db->error);
        }

        $themeDifficulty = 0;

        while ($row = $result->fetch_assoc()) {
            $themeDifficulty += $row['difficulty'];
        }

        $percentage = ($themeDifficulty / $totalDifficulty) * 100;

        $query = "SELECT * FROM history WHERE theme = '$theme' ORDER BY RAND() LIMIT 1";
        $result = $db->query($query);

        if (!$result) {
            die('Грешка при изпълнение на заявката: ' . $db->error);
        }

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $finalQuestionsHistory[] = $row;
            }
        } else {
            continue;
        }
    }

    return $finalQuestionsHistory;
}
?>