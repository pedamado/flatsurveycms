<?php
$survey = array_map('str_getcsv', file('survey.csv'));
$data = file_exists('data.csv') ? array_map('str_getcsv', file('data.csv')) : [];
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
    $answerIndex = 0;
    $questions = [];
    $answers = [];

    // Map questions to their answers
    foreach ($survey as $row) {
        $row = array_pad($row, 8, '');
        $type = trim($row[0]);
        $content = trim($row[1]);

        if ($type === 'Question') {
            $questions[] = $content;
        }
        if ($type === 'Answer') {
            $answers[$answerIndex] = ['question' => end($questions), 'answers' => []];
            $answerIndex++;
        }
    }

    // Collect all answers
    foreach ($data as $entry) {
        $answerIndex = 0;
        foreach (array_slice($entry, 2) as $i => $value) {
            if ($survey[$i][0] === 'Answer') {
                $answers[$answerIndex]['answers'][] = $value;
                $answerIndex++;
            }
        }
    }

    // Display results
    foreach ($answers as $answer) {
        echo '<div class="question-block">';
        echo '<h3>' . $answer['question'] . '</h3>';

        $counts = array_count_values($answer['answers']);
        $total = count($answer['answers']);

        foreach ($counts as $value => $count) {
            $width = ($count / $total) * 100;
            echo '<div>';
            echo '<span>' . $value . ' (' . $count . ')</span>';
            echo '<div class="result-bar" style="width: ' . $width . '%"></div>';
            echo '</div>';
        }

        echo '</div>';
    }
    ?>
</body>

</html>