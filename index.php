<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $survey = array_map('str_getcsv', file('survey.csv'));
    $lineData = [
        date('Y-m-d'),  // Date column
        date('H-i-s')   // Time column
    ];
    $answerIndex = 0;

    // Process each survey element
    foreach ($survey as $row) {
        $row = array_pad($row, 8, '');
        $type = trim($row[0]);
        $content = trim($row[1]);

        if ($type === 'Answer') {
            // Get user's answer
            $answer = $_POST['answer_' . $answerIndex] ?? 'N.A.';
            $lineData[] = $answer;
            $answerIndex++;
        } else {
            // Store static content
            $lineData[] = $content;
        }
    }

    // Save to data.csv
    $fp = fopen('data.csv', 'a');
    fputcsv($fp, $lineData);
    fclose($fp);

    // After saving data, find confirmation message
    $survey = array_map('str_getcsv', file('survey.csv'));
    $confirmationMessage = '';

    foreach ($survey as $row) {
        $row = array_pad($row, 8, '');
        if (trim($row[0]) === 'Confirm') {
            $confirmationMessage = trim($row[1]);
            break;
        }
    }

    $_SESSION['confirmation'] = $confirmationMessage;

    header('Location: index.php');
    exit;
}

$survey = array_map('str_getcsv', file('survey.csv'));
?>
<!DOCTYPE html>
<html>

<head>
    <title>Survey</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <form method="POST">
        <?php
        $answerIndex = 0;
        foreach ($survey as $row) {
            // Skip invalid/empty rows
            if (!is_array($row) || empty($row[0])) continue;

            // Pad row to 8 columns based on the screenshot structure
            $padded_row = array_pad($row, 8, '');

            // Extract values with proper validation
            $type = trim($padded_row[0]);
            $content = trim($padded_row[1]);
            $required = trim($padded_row[2] ?? '');
            $noAnswer = trim($padded_row[3] ?? '');
            $before = trim($padded_row[4] ?? '');
            $after = trim($padded_row[5] ?? '');
            $min = trim($padded_row[6] ?? '');
            $max = trim($padded_row[7] ?? '');

            $required_attr = ($required === 'Yes') ? 'required' : '';

            switch ($type) {
                case 'Title':
                    echo "<h1>$content</h1>";
                    break;

                case 'Description':
                    echo "<p>$content</p>";
                    break;

                case 'Question':
                    echo "<h2>$content</h2>";
                    break;

                case 'Answer':
                    // Handle different answer types
                    if (str_contains($content, '-Option-Scale')) {
                        preg_match('/(\d+)/', $content, $matches);
                        $options = (int)($matches[0] ?? 5);
                        $scale_min = is_numeric($min) ? (int)$min : 1;
                        $scale_max = is_numeric($max) ? (int)$max : $options;

                        echo "<div class='scale-container'>";
                        echo "<div class='scale-labels before'><span>$before</span></div>";
                        echo "<div class='scale-options'>";


                        for ($i = $scale_min; $i <= $scale_max; $i++) {
                            echo "<label class='scale-option'>";
                            echo "<input type='radio' name='answer_$answerIndex' value='$i' $required_attr> $i";
                            echo "</label>";
                        }

                        if ($noAnswer === 'Yes') {
                            echo "<label class='scale-option'>";
                            echo "<input type='radio' name='answer_$answerIndex' value='N.A.'> N.A.";
                            echo "</label>";
                        }

                        echo "<div class='scale-labels after'><span>$after</span></div>";

                        echo "</div></div>";
                    } elseif ($content === 'Checkbox') {
                        echo "<label><input type='checkbox' name='answer_$answerIndex' value='Yes' $required_attr> $before </label>";
                    } elseif ($content === 'Two-Options') {
                        echo "<div class='options-container'>";
                        echo "<label><input type='radio' name='answer_$answerIndex' value='$before' $required_attr> $before</label>";
                        echo "<label><input type='radio' name='answer_$answerIndex' value='$after' $required_attr> $after</label>";
                        echo "</div>";
                    } else { // Text input
                        echo "<input type='text' name='answer_$answerIndex' $required_attr>";
                    }
                    $answerIndex++;
                    break;

                case 'Separator':
                    echo "<hr>";
                    break;

                case 'Submit':
                    echo "<button type='submit'>$content</button>";
                    break;
            }
        }
        ?>
    </form>

    <div id="confirmationModal" class="modal">
        <div class="modal-content">
            <p id="confirmationMessage"></p>
            <button onclick="hideModal()">OK</button>
        </div>
    </div>

    <?php if (isset($_SESSION['confirmation']) && !empty($_SESSION['confirmation'])): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const modal = document.getElementById('confirmationModal');
                const message = document.getElementById('confirmationMessage');
                message.textContent = <?= json_encode($_SESSION['confirmation']) ?>;
                modal.style.display = 'flex';

                function hideModal() {
                    modal.style.display = 'none';
                }
                window.hideModal = hideModal;
            });
        </script>
    <?php
        unset($_SESSION['confirmation']);
    endif;
    ?>

</body>

</html>