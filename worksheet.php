<?php
include 'config.php';
$query = new Database();

if (isset($_GET['lessonid'])) {
    $lessonid = intval($_GET['lessonid']);

    if (!$lessonid) {
        include '404.php';
        exit;
    }

    $lesson = $query->select('lessons', '*', "id = $lessonid");

    if (empty($lesson)) {
        include '404.php';
        exit;
    }

    $tests = $query->select('test', '*', "lesson_id = $lessonid");
    $tru_falses = $query->select('tru_false', '*', "lesson_id = $lessonid");
    $dropdowns = $query->select('dropdown', '*', "lesson_id = $lessonid");
    $fill_in_the_blanks = $query->select('fill_in_the_blank', '*', "lesson_id = $lessonid");
    $matchings = $query->select('matching', '*', "lesson_id = $lessonid");

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $correctAnswersCount = 0;

        foreach ($tests as $test) {
            $testid = $test['id'];
            $correctOption = $query->select('test_options', 'id', "test_id = $testid AND is_correct = 1");

            $correctAnswerId = $correctOption[0]['id'];

            if (isset($_POST["test_answer_$testid"]) && $_POST["test_answer_$testid"] == $correctAnswerId) {
                $correctAnswersCount++;
            }
        }

        foreach ($tru_falses as $tru_false) {
            $correctAnswer = $tru_false['is_true'];
            if (isset($_POST["tru_false_answer_{$tru_false['id']}"]) && $_POST["tru_false_answer_{$tru_false['id']}"] == $correctAnswer) {
                $correctAnswersCount++;
            }
        }

        foreach ($dropdowns as $dropdown) {
            $correctAnswer = $dropdown['correct_answer'];
            if (isset($_POST["dropdown_answer_{$dropdown['id']}"]) && $_POST["dropdown_answer_{$dropdown['id']}"] == $correctAnswer) {
                $correctAnswersCount++;
            }
        }

        foreach ($fill_in_the_blanks as $blank) {
            $correctAnswer = $blank['correct_answer'];
            if (isset($_POST["fill_in_the_blank_answer_{$blank['id']}"]) && strtolower(trim($_POST["fill_in_the_blank_answer_{$blank['id']}"])) == strtolower(trim($correctAnswer))) {
                $correctAnswersCount++;
            }
        }

        foreach ($matchings as $matching) {
            $correctAnswer = $matching['right_side'];
            if (isset($_POST["matching_answer_{$matching['id']}"]) && $_POST["matching_answer_{$matching['id']}"] == $correctAnswer) {
                $correctAnswersCount++;
            }
        }

        $totalQuestions = count($tests) + count($tru_falses) + count($dropdowns) + count($fill_in_the_blanks) + count($matchings);
        echo "<h2 class='result'>Result: You answered $correctAnswersCount questions correctly out of $totalQuestions questions</h2>";
    }
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Task for: <?= $lesson[0]['title'] ?></title>
    </head>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 20px;
            background-color: #f9fafb;
            color: #333;
            line-height: 1.6;
        }

        h1 {
            color: #6c5ce7;
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 30px;
            letter-spacing: 2px;
        }

        form {
            margin: 0 auto;
            max-width: 900px;
            padding: 25px;
            border-radius: 8px;
            background-color: #ffffff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h3 {
            color: #ff6b81;
            text-align: center;
            font-size: 1.5rem;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .task_item {
            border: 1px solid #e0e0e0;
            padding: 20px;
            margin-bottom: 25px;
            border-radius: 8px;
            background-color: #fafafa;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .task_item label {
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 15px;
            display: block;
        }

        .task_item input[type="radio"],
        .task_item select,
        .task_item input[type="text"] {
            width: 90%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
            margin-top: 8px;
            box-sizing: border-box;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .task_item input[type="radio"]:hover,
        .task_item select:hover,
        .task_item input[type="text"]:hover {
            border-color: #007bff;
        }

        .task_item input[type="radio"]:checked,
        .task_item select:focus,
        .task_item input[type="text"]:focus {
            border-color: #6c5ce7;
            outline: none;
        }

        .task_item .question-number {
            font-size: 1.2rem;
            font-weight: bold;
            color: #6c5ce7;
            margin-right: 10px;
        }

        .task_item .options {
            display: flex;
            flex-direction: column;
        }

        .task_item .options input[type="radio"] {
            margin-right: 10px;
            width: auto;
        }

        .task_item .options label,
        .task_item .options p {
            display: inline-block;
            margin-bottom: 8px;
        }

        .submit-btn {
            padding: 14px 30px;
            font-size: 1.2em;
            background-color: #6c5ce7;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .submit-btn:hover {
            background-color: #5a48c8;
        }

        hr {
            border: none;
            border-top: 2px solid #ddd;
            margin: 30px 0;
        }

        @media screen and (max-width: 768px) {
            h1 {
                font-size: 2rem;
            }

            .submit-btn {
                font-size: 1.1em;
            }

            .task_item {
                padding: 15px;
            }

            .task_item label {
                font-size: 1rem;
            }

            .task_item input[type="radio"],
            .task_item select,
            .task_item input[type="text"] {
                width: 100%;
            }
        }

        .words {
            margin-bottom: 15px;
        }

        .word {
            display: inline-block;
            padding: 5px 10px;
            margin: 5px;
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            border-radius: 5px;
            cursor: pointer;
        }

        .result {
            font-size: 24px;
            font-weight: bold;
            color: #4CAF50;
            text-align: center;
            margin-top: 20px;
            margin: 20px 30px;
            background-color: #f0f8ff;
            padding: 10px;
            border-radius: 8px;
            border: 2px solid #4CAF50;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
        }

        .result:hover {
            transform: scale(1.05);
        }
    </style>

    <body>

        <h1>Task for: <?= $lesson[0]['title'] ?></h1>

        <?php if (!empty($tests) || !empty($tru_falses) || !empty($dropdowns) || !empty($fill_in_the_blanks) || !empty($matchings)) : ?>
            <form method="post">

                <?php if (!empty($tests)) : ?>
                    <h3>Test Questions</h3>
                    <div class="task_item">
                        <?php foreach ($tests as $index => $test) :
                            $testid = $test['id'];
                            $options = $query->select('test_options', '*', "test_id = $testid");
                        ?>
                            <label for="test_question_<?= $testid; ?>">
                                <?= ($index + 1) . '. ' . htmlspecialchars($test['question']); ?>
                            </label><br>

                            <div class="options">
                                <?php foreach ($options as $option) : ?>
                                    <label>
                                        <input type="radio" name="test_answer_<?= $testid; ?>" id="test_answer_<?= $option['id']; ?>" value="<?= htmlspecialchars($option['id']); ?>"><?= htmlspecialchars($option['option_text']); ?>
                                    </label><br>
                                <?php endforeach; ?>
                            </div>
                            <hr>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($tru_falses)) : ?>
                    <h3>True/False Questions</h3>
                    <div class="task_item">
                        <?php foreach ($tru_falses as $index => $tru_false) : ?>
                            <label for="tru_false_statement_<?= $tru_false['id']; ?>">
                                <?= ($index + 1) . '. ' . htmlspecialchars($tru_false['statement']); ?>
                            </label><br>
                            <div class="options">
                                <label for="tru_false_answer_<?= $tru_false['id']; ?>_true">
                                    <input type="radio" id="tru_false_answer_<?= $tru_false['id']; ?>_true" name="tru_false_answer_<?= $tru_false['id']; ?>" value="1"> True
                                </label><br>
                                <label for="tru_false_answer_<?= $tru_false['id']; ?>_false">
                                    <input type="radio" id="tru_false_answer_<?= $tru_false['id']; ?>_false" name="tru_false_answer_<?= $tru_false['id']; ?>" value="0"> False
                                </label><br>
                            </div>
                            <hr>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($dropdowns)) : ?>
                    <h3>Dropdown Question</h3>
                    <div class="task_item">
                        <?php foreach ($dropdowns as $index => $dropdown) : ?>
                            <?php $dropdownOptions[$index] = $dropdown['correct_answer']; ?>
                        <?php endforeach; ?>

                        <?php foreach ($dropdowns as $index => $dropdown) : ?>
                            <?php shuffle($dropdownOptions); ?>
                            <label for="dropdown_question_<?= $dropdown['id']; ?>"><?= ($index + 1) . '. ' . htmlspecialchars($dropdown['question']); ?></label><br>
                            <select name="dropdown_answer_<?= $dropdown['id']; ?>" id="dropdown_question_<?= $dropdown['id']; ?>" class="dropdown">
                                <option value="" disabled selected>-- Select Section --</option>
                                <?php foreach ($dropdownOptions as $dropdownOption): ?>
                                    <option value="<?= $dropdownOption ?>"><?= $dropdownOption ?></option>
                                <?php endforeach; ?>
                            </select><br>
                            <hr>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($fill_in_the_blanks)) : ?>
                    <h3>Fill in the Blank Questions</h3>
                    <div class="task_item">
                        <div id="words-container" class="words"></div>
                        <?php foreach ($fill_in_the_blanks as $index => $blank) : ?>
                            <label for="fill_in_the_blank_<?= $blank['id']; ?>">
                                <?= ($index + 1) . '. ' . htmlspecialchars($blank['sentence']); ?>
                            </label><br>
                            <input type="text" name="fill_in_the_blank_answer_<?= $blank['id']; ?>" placeholder="Enter your answer"><br>
                            <hr>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($matchings)) : ?>
                    <?php foreach ($matchings as $index => $matching) : ?>
                        <?php $matchingOptions[$index] = $matching['right_side']; ?>
                    <?php endforeach; ?>

                    <h3>Matching Questions</h3>
                    <div class="task_item">
                        <?php foreach ($matchings as $index => $matching) : ?>
                            <?php shuffle($matchingOptions); ?>
                            <div class="matching-question">
                                <div class="left-side">
                                    <label for="matching_<?= $matching['id']; ?>"><?= ($index + 1) . '. ' . htmlspecialchars($matching['left_side']); ?></label>
                                </div>

                                <div class="right-side">
                                    <select name="matching_answer_<?= $matching['id']; ?>" id="matching_<?= $matching['id']; ?>" class="matching-dropdown">
                                        <option value="" disabled selected>-- Select Section --</option>
                                        <?php foreach ($matchingOptions as $matchingOption): ?>
                                            <option value="<?= htmlspecialchars($matchingOption); ?>"><?= htmlspecialchars($matchingOption); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <hr>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>


                <input type="submit" value="Submit" class="submit-btn">
            </form>
        <?php endif; ?>

    </body>

    <script>
        function shuffleArray(array) {
            for (let i = array.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [array[i], array[j]] = [array[j], array[i]];
            }
            return array;
        }

        function renderWords(correctAnswersCount) {
            const wordsContainer = document.getElementById('words-container');
            const shuffledWords = shuffleArray([...correctAnswersCount]);
            wordsContainer.innerHTML = shuffledWords
                .map(word => `<span class="word">${word}</span>`)
                .join('');
        }

        document.addEventListener('DOMContentLoaded', () => {
            const correctAnswersCount = <?= json_encode(array_column($fill_in_the_blanks, 'correct_answer')); ?>;
            renderWords(correctAnswersCount);
        });
    </script>

    </html>
<?php
} else {
    header('Location: lessons.php');
    exit();
}
?>