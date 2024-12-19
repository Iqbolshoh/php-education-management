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
        <link rel="stylesheet" href="./style.css">
    </head>

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