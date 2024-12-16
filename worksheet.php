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

    $lesson = $lesson[0];

    $questions = $query->select('questions', '*', "lesson_id = {$lesson['id']}");
    shuffle($questions);
} else {
    header('Location: lessons.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $score = 0;
    foreach ($questions as $index => $question) {
        if (isset($_POST['answer' . $index]) && $_POST['answer' . $index] === $question['correct_answer']) {
            $score++;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($lesson['title']) ?></title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f0f4f8;
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 900px;
        margin: 20px auto;
        padding: 30px;
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        animation: slideUpFade 0.7s ease forwards;
    }

    .container h1 {
        color: #2c3e50;
        margin-bottom: 20px;
        font-size: 24px;
        animation: slideUpFade 0.7s ease forwards;
    }

    .container p {
        font-size: 16px;
        color: #555;
        margin-bottom: 20px;
        animation: slideUpFade 0.7s ease forwards;
    }

    .question {
        margin-bottom: 20px;
        animation: slideUpFade 0.7s ease forwards;
    }

    .question label {
        font-size: 18px;
        display: block;
        margin-bottom: 10px;
        color: #333;
    }

    .question select {
        padding: 12px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f9f9f9;
        box-sizing: border-box;
    }

    .buttons {
        display: flex;
        justify-content: space-between;
        margin-top: 30px;
        gap: 15px;
    }

    .buttons a {
        text-decoration: none;
        color: #ffffff;
        background-color: #3498db;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        font-size: 16px;
        font-weight: bold;
        text-align: center;
        transition: background-color 0.3s ease;
    }

    .buttons a:hover {
        background-color: #2980b9;
    }

    .buttons #submitBtn {
        color: #ffffff;
        background-color: #ff6b81;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        font-size: 16px;
        font-weight: bold;
        text-align: center;
        transition: background-color 0.3s ease;
    }

    .buttons #submitBtn:hover {
        background-color: #d65a71;
    }

    .result {
        font-size: 18px;
        font-weight: bold;
        color: #2c3e50;
        margin-top: 20px;
    }

    .question {
        background-color: rgba(41, 127, 185, 0.1);
        border-radius: 5px;
        padding: 33px 11px;
        opacity: 0;
        transition: opacity 0.5s ease-in-out;
    }

    .correct {
        background-color: #28a745;
        color: white;
    }

    .error {
        background-color: #e74c3c;
        color: white;
    }


    @keyframes fadeIn {
        0% {
            opacity: 0;
        }

        100% {
            opacity: 1;
        }
    }


    @media (max-width: 768px) {
        .buttons {
            flex-direction: column;
            gap: 15px;
        }

        .container {
            padding: 20px;
        }

        .container h1 {
            font-size: 20px;
        }

        .question label {
            font-size: 16px;
        }
    }

    @keyframes slideUpFade {
        0% {
            opacity: 0;
            transform: translateY(30px);
        }

        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<body>
    <?php include 'includes/header.php'; ?>

    <div class="container">
        <h1><?= htmlspecialchars($lesson['title']) ?></h1>
        <p><?= htmlspecialchars($lesson['description']) ?></p>

        <form method="POST" id="quizForm">
            <?php foreach ($questions as $index => $question): ?>
                <?php
                $options = $query->select('options', 'option_text', "question_id = {$question['id']}");
                shuffle($options);
                $delay = 0.1 * $index;
                ?>

                <div class="question" style="animation-delay: <?= $delay ?>s; opacity: 0;">
                    <label for="answer<?= $index ?>">
                        <strong><?= $index + 1 ?>)</strong>
                        <?php
                        $parts = explode('____', $question['sentence']);
                        echo $parts[0];
                        ?>
                        <select name="answer<?= $index ?>" id="answer<?= $index ?>">
                            <?php foreach ($options as $option): ?>
                                <?php $option = $option['option_text'] ?>
                                <option value="<?= htmlspecialchars($option) ?>" <?= isset($_POST['answer' . $index]) && $_POST['answer' . $index] === $option ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($option) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (isset($parts[1])) {
                            echo $parts[1];
                        } ?>
                    </label>
                </div>
            <?php endforeach; ?>

            <div class="buttons">
                <button type="submit" id="submitBtn">Submit</button>
                <a href="lesson_detail.php?lessonid=<?= $lessonid ?>">Back to Lessons</a>
            </div>
        </form>

    </div>

    <?php include 'includes/footer.php'; ?>

    <script>
        const form = document.getElementById('quizForm');
        const submitBtn = document.getElementById('submitBtn');
        const selectElements = document.querySelectorAll('select');

        form.addEventListener('submit', function(event) {
            event.preventDefault();
            const score = calculateScore();

            const totalQuestions = <?= count($questions) ?>;
            const percentage = Math.round((score / totalQuestions) * 100);

            Swal.fire({
                title: `Your Result: ${percentage}%`,
                text: `Your score is: ${score} out of ${totalQuestions}`,
                icon: 'success',
                showCancelButton: true,
                confirmButtonText: 'Recycling',
                cancelButtonText: 'Go to Lessons',
            }).then((result) => {
                if (result.isConfirmed) {
                    selectElements.forEach(select => {
                        select.disabled = false;
                    });

                    submitBtn.style.display = 'block';
                } else if (result.isDismissed) {
                    window.location.href = 'lessons.php';
                }
            });

        });

        function calculateScore() {
            let score = 0;
            const formData = new FormData(form);

            <?php foreach ($questions as $index => $question): ?>
                if (formData.get('answer<?= $index ?>') === '<?= $question['correct_answer'] ?>') {
                    score++;
                }
            <?php endforeach; ?>

            return score;
        }
    </script>
</body>

</html>