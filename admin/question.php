<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ./login/");
    exit;
}

include './config.php';
$query = new Database();

$lessonid = isset($_GET['lessonid']) ? intval($_GET['lessonid']) : null;

if ($lessonid !== null) {
    $lessons_test = $query->select('lessons', '*', "id = '$lessonid'");
} else {
    $lessons_test = [];
}

$edit_question_id = isset($_GET['edit_question_id']) ? intval($_GET['edit_question_id']) : null;

$questions = [];
if ($lessonid !== null) {
    $questions = $query->select('questions', '*', "lesson_id = '$lessonid'");
}

$edit_question = null;
if ($edit_question_id !== null) {
    $edit_question = $query->select('questions', '*', "id = $edit_question_id")[0] ?? null;
    $edit_answers = $query->select('answers', '*', "question_id = $edit_question_id");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_question'])) {
        $question_text = $_POST['question_text'];
        $question_id = $query->insert('questions', [
            'lesson_id' => $lessonid,
            'question_text' => $question_text
        ]);

        $answers = $_POST['answers'];

        foreach ($answers as $index => $answer) {
            $query->insert('answers', [
                'question_id' => $question_id,
                'answer_text' => $answer,
            ]);
        }
    } elseif (isset($_POST['update_question'])) {
        $question_id = $_POST['question_id'];
        $question_text = $_POST['question_text'];
        $query->update('questions', ['question_text' => $question_text], "id = $question_id");

        $query->delete('answers', "question_id = $question_id");

        $answers = $_POST['answers'];

        foreach ($answers as $index => $answer) {
            $query->insert('answers', [
                'question_id' => $question_id,
                'answer_text' => $answer
            ]);
        }
    }
    header("Location: ?lessonid=$lessonid");
    exit;
}

if (isset($_GET['delete_question_id'])) {
    $delete_question_id = $_GET['delete_question_id'];
    $query->delete('answers', "question_id = '$delete_question_id'");
    $query->delete('questions', "id = '$delete_question_id'");
    header("Location: ?lessonid=$lessonid");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="../favicon.ico">
    <title>AdminLTE 3 | Test</title>
    <?php include 'includes/css.php'; ?>
</head>

<style>
    button {
        width: 100%;
        color: #fff;
        border: none;
        padding: 12px 24px;
        font-size: 16px;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .card {
        width: 100%;
        max-width: calc(100% - 20px);
        margin: 10px;
        margin-bottom: 20px;
    }

    .table {
        background-color: rgb(255, 255, 255);
        padding: 20px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        margin: 0px 10px;
        margin-bottom: 20px;
        width: 100%;
        max-width: calc(100% - 20px);
        transition: box-shadow 0.3s ease;
        border: 1px solid #e0e0e0;
    }

    .edit-add {
        background-color: rgb(255, 255, 255);
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        margin: 0px 10px;
        margin-bottom: 20px;
        width: 100%;
        max-width: calc(100% - 20px);
        transition: box-shadow 0.3s ease;
        border: 1px solid #e0e0e0;
    }
</style>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php include 'includes/navbar.php'; ?>
        <div class="content-wrapper">

            <?php
            $arr = array(
                ["title" => "Home", "url" => "./"],
                ["title" => "Questions", "url" => "#"],
            );
            pagePath('Questions', $arr);
            ?>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">

                        <?php if ($lessons_test): ?>
                            <?php if (empty($questions) || !empty($edit_question_id)): ?>
                                <form method="POST" class="edit-add">
                                    <h4><?= $edit_question ? 'Edit Question' : 'Add New Question' ?></h4>
                                    <input type="hidden" name="question_id" value="<?= $edit_question['id'] ?? '' ?>">
                                    <div class="form-group">
                                        <label for="question_text">Question Text</label>
                                        <textarea name="question_text" id="question_text" class="form-control" rows="4" placeholder="Enter the question" required><?= $edit_question['question_text'] ?? '' ?></textarea>
                                    </div>

                                    <div id="answers-container">
                                        <label>Answers:</label>
                                        <?php if ($edit_question): ?>
                                            <?php foreach ($edit_answers as $index => $answer): ?>
                                                <div class="answer-item d-flex align-items-center mb-2">
                                                    <input type="text" name="answers[]" class="form-control mr-2" placeholder="Answer text" value="<?= $answer['answer_text'] ?>" required>
                                                    <button type="button" class="btn btn-danger btn-sm ml-2 remove-answer">Remove</button>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <div class="answer-item d-flex align-items-center mb-2">
                                                <input type="text" name="answers[]" class="form-control mr-2" placeholder="Answer text" required>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <button type="button" class="btn btn-secondary" id="add-answer">Add Answer</button>

                                    <div class="form-group mt-4">
                                        <button type="submit" name="<?= $edit_question ? 'update_question' : 'add_question' ?>" class="btn btn-primary">Save Question</button>
                                    </div>
                                </form>
                            <?php endif ?>
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Questions List</h3>
                                </div>
                                <table class="table table-bordered mt-4">
                                    <thead>
                                        <tr>
                                            <th>№</th>
                                            <th>Question</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($questions as $index => $question): ?>
                                            <tr>
                                                <td><?= $index + 1 ?></td>
                                                <td>

                                                <td><?= $question['question_text'] ?></td>
                                                <td>
                                                    <a href="?lessonid=<?= $lessonid ?>&edit_question_id=<?= $question['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                                    <a href="?lessonid=<?= $lessonid ?>&delete_question_id=<?= $question['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>

                        <?php else: ?>
                            <form method="get" style="min-width: min(400px, 100%); margin: 50px auto; border: 1px solid #ddd; border-radius: 8px; padding: 20px; background-color: #f9f9f9; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                                <?php $lessons = $query->select('lessons', '*'); ?>

                                <div class="form-group" style="margin-bottom: 20px;">
                                    <label for="lessonid" style="display: block; font-size: 18px; font-weight: bold; color: #333; margin-bottom: 8px;">Select a Lesson</label>
                                    <select name="lessonid" id="lessonid" class="form-control" style="width: 100%; padding: 5px; font-size: 16px; border: 1px solid #ccc; border-radius: 4px; background-color: #fff; color: #333;">
                                        <option value="" selected disabled>-- Select a Lesson --</option>
                                        <?php foreach ($lessons as $index => $lesson): ?>
                                            <option value="<?= $lesson['id'] ?>" <?= $lesson['id'] == $lessonid ? 'selected' : '' ?>>
                                                <?= $index + 1 . ". " . $lesson['title'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group" style="text-align: center;">
                                    <button type="submit" class="btn btn-primary">Select Lesson</button>
                                </div>
                            </form>

                        <?php endif; ?>

                    </div>
                </div>
            </section>
        </div>
        <?php include 'includes/footer.php'; ?>
    </div>

    <?php include 'includes/js.php'; ?>

    <script>
        document.getElementById('add-answer').addEventListener('click', function() {
            var container = document.getElementById('answers-container');
            var newAnswer = document.createElement('div');
            newAnswer.classList.add('answer-item', 'd-flex', 'align-items-center', 'mb-2');
            newAnswer.innerHTML = `
            <input type="text" name="answers[]" class="form-control mr-2" placeholder="Answer text" required>
            <button type="button" class="btn btn-danger btn-sm ml-2 remove-answer">Remove</button>
        `;
            container.appendChild(newAnswer);

            newAnswer.querySelector('.remove-answer').addEventListener('click', function() {
                container.removeChild(newAnswer);
            });
        });

        document.querySelectorAll('.remove-answer').forEach(function(button) {
            button.addEventListener('click', function() {
                var answerItem = button.closest('.answer-item');
                document.getElementById('answers-container').removeChild(answerItem);
            });
        });
    </script>

</body>

</html>