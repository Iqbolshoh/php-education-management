<?php
include 'config.php';
$query = new Database();


if (isset($_GET['lessonid'])) {
    $lessonid = intval($_GET['lessonid']);
    $participant_name = $_GET['participant_name'] ?? null;

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

    $text_questions = $query->select('questions', '*', "lesson_id = $lessonid");
    if (isset($text_questions)) {
        $text_questionid = $text_questions[0]['id'];
    }
    $text_options = $query->select('answers', '*', "question_id = '$text_questionid'");
    $text_optionsSelecs = $text_options;

    shuffle($tests);
    shuffle($tru_falses);
    shuffle($dropdowns);
    shuffle($fill_in_the_blanks);
    shuffle($matchings);

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

        $text_correctAnswers = [];
        foreach ($text_options as $text_option) {
            $text_correctAnswers[] = $text_option['answer_text'];
        }

        $text_submittedAnswers = $_POST['answers'] ?? [];

        foreach ($text_submittedAnswers as $text_index => $text_answer) {
            if ($text_answer === $text_correctAnswers[$text_index]) {
                $correctAnswersCount++;
            }
        }

        $totalQuestions = count($tests) + count($tru_falses) + count($dropdowns) + count($fill_in_the_blanks) + count($matchings) + count($text_correctAnswers);
        $percentage = ($correctAnswersCount / $totalQuestions) * 100;

        $query->insert('results', [
            'lesson_id' => $lessonid,
            'participant_name' => $participant_name,
            'answered_questions' => $correctAnswersCount,
            'total_questions' => $totalQuestions
        ]);
?>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var correctAnswersCount = <?php echo $correctAnswersCount; ?>;
                var totalQuestions = <?php echo $totalQuestions; ?>;
                var percentage = <?php echo $percentage; ?>;

                Swal.fire({
                    title: "Quiz Result",
                    text: "You answered " + correctAnswersCount + " out of " + totalQuestions + " questions correctly. Your score is " + percentage.toFixed(2) + "%",
                    icon: "success",
                    confirmButtonText: "OK",
                    allowOutsideClick: false,
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = document.referrer;
                    }
                });
            });
        </script>
    <?php
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./style.css">
        <title>WorkSheet | Task for: <?= $lesson[0]['title'] ?></title>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>

    <style>
        .container {
            transform: translateY(0);
            opacity: 0;
            animation: fadeInUp 1s ease-out forwards;
        }

        .title {
            color: #6c5ce7;
            text-align: center;
            font-size: 3rem;
            margin-bottom: 30px;
            letter-spacing: 2px;
            transform: translateY(0);
            opacity: 0;
            animation: fadeInUp 1s ease-out forwards;
        }

        form {
            margin: 0 auto;
            width: calc(100% - 40px);
            max-width: 900px;
            padding: 20px;
            border-radius: 8px;
            background-color: #ffffff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .title_h3 {
            color: #ff6b81;
            text-align: center;
            font-size: 2.2rem;
            margin-top: 17px;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
            transform: translateY(0);
            opacity: 0;
            animation: fadeInUp 1s ease-out forwards;
        }

        .task_item {
            border: 1px solid #e0e0e0;
            padding: 20px;
            margin-bottom: 25px;
            border-radius: 8px;
            background-color: #fafafa;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transform: translateY(0);
            opacity: 0;
            animation: fadeInUp 1s ease-out forwards;
        }

        .task_item label {
            font-weight: 600;
            font-size: 1.5rem;
            margin-bottom: 15px;
            display: block;
        }

        .task_item input[type="radio"],
        .task_item select,
        .task_item input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1.5rem;
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
            font-size: 1.5rem;
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
            font-size: 1.5rem;
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
            .title {
                font-size: 2rem;
            }

            .submit-btn {
                font-size: 1.5rem;
            }

            .task_item {
                padding: 15px;
            }

            .task_item label {
                font-size: 1.5rem;
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
            font-size: 1.5rem;
            display: inline-block;
            padding: 5px 10px;
            margin: 5px;
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            border-radius: 5px;
            cursor: pointer;
        }


        .question-text {
            font-size: 1.7rem;
            margin-bottom: 20px;
            text-align: justify;
            line-height: 1.6;
        }

        .answer-option {
            font-size: 1.7rem;
            text-align: justify;
            line-height: 1.6;
            margin-bottom: 9px;
        }

        .answer-select {
            padding: 7px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1.5rem;
            box-sizing: border-box;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .answer-select:hover {
            border-color: #007bff;
        }

        .answer-select:focus {
            border-color: #6c5ce7;
            outline: none;
        }

        #delay-animation {
            transform: translateY(0);
            opacity: 0;
            animation: fadeInUp 1s ease-out forwards;
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(50px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <body>
        <?php include 'includes/header.php' ?>
        <div class="container">

            <?php $delay = 0 ?>

            <h1 class="title">Task for: <?= $lesson[0]['title'] ?></h1>

            <?php if ($participant_name) : ?>

                <?php if (!empty($tests) || !empty($tru_falses) || !empty($dropdowns) || !empty($fill_in_the_blanks) || !empty($matchings) || !empty($text_questions)) : ?>
                    <form method="post">

                        <div id="delay-animation" style="animation-delay: <?= $delay += 0.2 ?>s">
                            <?php if (!empty($tests)) : ?>
                                <h3 class="title_h3" style="animation-delay: <?= $delay += 0.1 ?>s">Test Questions</h3>
                                <div class="task_item" style="animation-delay: <?= $delay += 0.1 ?>s">
                                    <?php foreach ($tests as $index => $test) :
                                        $testid = $test['id'];
                                        $options = $query->select('test_options', '*', "test_id = $testid");
                                        shuffle($options);
                                    ?>
                                        <div id="delay-animation" style="animation-delay: <?= $delay += 0.1 ?>s">
                                            <label for="test_question_<?= $testid; ?>">
                                                <p style="white-space: pre-wrap;"><?= ($index + 1) . ')   ' . $test['question'] ?></p>
                                            </label><br>

                                            <div class="options">
                                                <?php foreach ($options as $option) : ?>
                                                    <label>
                                                        <input type="radio" name="test_answer_<?= $testid; ?>" id="test_answer_<?= $option['id']; ?>" value="<?= $option['id'] ?>"><?= $option['option_text'] ?>
                                                    </label><br>
                                                <?php endforeach; ?>
                                            </div>
                                            <hr>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div id="delay-animation" style="animation-delay: <?= $delay += 0.1 ?>s">
                            <?php if (!empty($tru_falses)) : ?>
                                <h3 class="title_h3">True/False Questions</h3>
                                <div class="task_item">
                                    <?php foreach ($tru_falses as $index => $tru_false) : ?>
                                        <div id="delay-animation" style="animation-delay: <?= $delay += 0.1 ?>s">
                                            <label for="tru_false_statement_<?= $tru_false['id']; ?>">
                                                <p style="white-space: pre-wrap;"> <?= ($index + 1) . ')   ' . $tru_false['statement'] ?></p>
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
                                        </div>

                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div id="delay-animation" style="animation-delay: <?= $delay += 0.1 ?>s">
                            <?php if (!empty($dropdowns)) : ?>
                                <h3 class="title_h3">Dropdown Question</h3>
                                <div class="task_item">
                                    <?php foreach ($dropdowns as $index => $dropdown) : ?>
                                        <?php $dropdownOptions[$index] = $dropdown['correct_answer']; ?>
                                    <?php endforeach; ?>

                                    <?php foreach ($dropdowns as $index => $dropdown) : ?>
                                        <div id="delay-animation" style="animation-delay: <?= $delay += 0.1 ?>s">
                                            <?php shuffle($dropdownOptions); ?>
                                            <label for="dropdown_question_<?= $dropdown['id']; ?>">
                                                <p style="white-space: pre-wrap;"><?= ($index + 1) . ')   ' . $dropdown['question'] ?></p>
                                            </label><br>
                                            <select name="dropdown_answer_<?= $dropdown['id']; ?>" id="dropdown_question_<?= $dropdown['id']; ?>" class="dropdown">
                                                <option value="" disabled selected>-- Select Section --</option>
                                                <?php foreach ($dropdownOptions as $dropdownOption): ?>
                                                    <option value="<?= $dropdownOption ?>"><?= $dropdownOption ?></option>
                                                <?php endforeach; ?>
                                            </select><br>
                                            <hr>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div id="delay-animation" style="animation-delay: <?= $delay += 0.1 ?>s">
                            <?php if (!empty($fill_in_the_blanks)) : ?>
                                <h3 class="title_h3">Fill in the Blank Questions</h3>
                                <div class="task_item">
                                    <?php foreach ($fill_in_the_blanks as $index => $blank) : ?>
                                        <div id="delay-animation" style="animation-delay: <?= $delay += 0.1 ?>s">
                                            <label for="fill_in_the_blank_<?= $blank['id']; ?>">
                                                <p style="white-space: pre-wrap;"><?= ($index + 1) . ')   ' . $blank['sentence'] ?> </p>
                                            </label><br>
                                            <input type="text" name="fill_in_the_blank_answer_<?= $blank['id']; ?>" placeholder="Enter your answer"><br>
                                            <hr>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div id="delay-animation" style="animation-delay: <?= $delay += 0.1 ?>s">
                            <?php if (!empty($matchings)) : ?>
                                <?php foreach ($matchings as $index => $matching) : ?>
                                    <?php $matchingOptions[$index] = $matching['right_side']; ?>
                                <?php endforeach; ?>

                                <h3 class="title_h3">Matching Questions</h3>
                                <div class="task_item">
                                    <?php foreach ($matchings as $index => $matching) : ?>
                                        <div id="delay-animation" style="animation-delay: <?= $delay += 0.1 ?>s">
                                            <?php shuffle($matchingOptions); ?>
                                            <div class="matching-question">
                                                <div class="left-side">
                                                    <label for="matching_<?= $matching['id']; ?>">
                                                        <p style="white-space: pre-wrap;"><?= ($index + 1) . ')   '  . $matching['left_side'] ?></p>
                                                    </label>
                                                </div>

                                                <div class="right-side">
                                                    <select name="matching_answer_<?= $matching['id']; ?>" id="matching_<?= $matching['id']; ?>" class="matching-dropdown">
                                                        <option value="" disabled selected>-- Select Section --</option>
                                                        <?php foreach ($matchingOptions as $matchingOption): ?>
                                                            <option value="<?= $matchingOption ?>"><?= $matchingOption ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <hr>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div id="delay-animation" style="animation-delay: <?= $delay += 0.1 ?>s">
                            <?php if (!empty($text_questions)) : ?>
                                <h3 class="title_h3">Question:</h3>
                                <p style="white-space: pre-wrap;" class="question-text"><?= $text_questions[0]['question_text'] ?></p>
                                <div class="answers-container">
                                    <?php foreach ($text_options as $text_index => $text_option) { ?>
                                        <div id="delay-animation" style="animation-delay: <?= $delay += 0.1 ?>s">

                                            <?php shuffle($text_optionsSelecs); ?>

                                            <div class="answer-option">
                                                <label for="answer-<?= $text_index ?>" class="answer-label"><?= $text_index + 1 . ") " ?></label>
                                                <select name="answers[<?= $text_index ?>]" id="answer-<?= $text_index ?>" class="answer-select">
                                                    <option value="" disabled selected>-- Select Section --</option>
                                                    <?php foreach ($text_optionsSelecs as $text_optionsSelec) { ?>
                                                        <option value="<?= $text_optionsSelec['answer_text'] ?>">
                                                            <?= $text_optionsSelec['answer_text'] ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div id="delay-animation" style="animation-delay: <?= $delay += 0.1 ?>s">
                            <input type="submit" value="Submit" class="submit-btn">
                        </div>
                    </form>
                <?php endif; ?>

            <?php else: ?>

                <div style="min-height: 80vh"></div>

                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        Swal.fire({
                            title: "Enter your name",
                            input: "text",
                            inputAttributes: {
                                autocapitalize: "off",
                                maxlength: 50,
                                pattern: "^[a-zA-Z' ]+$",
                                title: "Only one word is allowed!"
                            },
                            inputValidator: (value) => {
                                if (!value || !/^[a-zA-Z' ]+$/.test(value)) {
                                    return "Please enter a valid name (one word only)!";
                                }
                            },
                            showCancelButton: false,
                            confirmButtonText: "Submit",
                            allowOutsideClick: false,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                const participantName = result.value;
                                window.location.href = window.location.href + "&participant_name=" + encodeURIComponent(participantName);
                            }
                        });
                    });
                </script>
            <?php endif; ?>

        </div>
        <?php include 'includes/footer.php' ?>
    </body>

    </html>
<?php
} else {
    header('Location: lessons.php');
    exit();
}
?>