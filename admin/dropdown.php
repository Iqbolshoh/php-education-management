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

$dropdowns = [];
if ($lessonid) {
    $dropdowns = $query->select('dropdown', '*', "lesson_id = '$lessonid'");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_dropdown'])) {
        $question = $_POST['question'];
        $correct_answer = $_POST['correct_answer'];
        $lesson_id = intval($_POST['lesson_id']);

        $query->insert('dropdown', [
            'lesson_id' => $lesson_id,
            'question' => $question,
            'correct_answer' => $correct_answer
        ]);
    }

    if (isset($_POST['update_dropdown'])) {
        foreach ($_POST['id'] as $id) {
            $id = intval($id);
            $question = $_POST['question'][$id];
            $correct_answer = $_POST['correct_answer'][$id];

            $query->update('dropdown', [
                'question' => $question,
                'correct_answer' => $correct_answer
            ], "id = '$id'");
        }
    }

    header("Location: " . $_SERVER['PHP_SELF'] . "?lessonid=$lessonid");
    exit;
}

if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $query->delete('dropdown', "id = '$delete_id'");
    header("Location: " . $_SERVER['PHP_SELF'] . "?lessonid=$lessonid");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="../favicon.ico">
    <title>Dropdown</title>
    <?php include 'includes/css.php'; ?>
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

        .dropdownBox {
            background-color: white;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .form-group label {
            font-weight: bold;
            color: #333;
        }

        .btn-danger,
        .btn-primary {
            transition: background-color 0.3s ease;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php include 'includes/navbar.php'; ?>
        <div class="content-wrapper">
            <?php
            $arr = [["title" => "Home", "url" => "./"], ["title" => "Dropdown", "url" => "#"]];
            pagePath('Dropdown', $arr);
            ?>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <?php if ($lessons_test): ?>
                            <div class="col-12">
                                <div class="dropdownBox">
                                    <h4>Add Dropdown</h4>
                                    <form method="post">
                                        <input type="hidden" name="lesson_id" value="<?= $lessonid ?>">
                                        <div class="form-group">
                                            <label>New Question:</label>
                                            <textarea name="question" class="form-control" rows="4" placeholder="Enter the question" required></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Correct Answer:</label>
                                            <input type="text" name="correct_answer" class="form-control" required>
                                        </div>
                                        <button type="submit" name="add_dropdown" class="btn btn-primary">Add Dropdown</button>
                                    </form>
                                </div>

                                <form method="post">
                                    <div class="dropdownBox">
                                        <?php foreach ($dropdowns as $dropdown): ?>
                                            <input type="hidden" name="id[<?= $dropdown['id'] ?>]" value="<?= $dropdown['id'] ?>">
                                            <div class="form-group">
                                                <label>Question:</label>
                                                <textarea name="question[<?= $dropdown['id'] ?>]" class="form-control" rows="4" placeholder="Enter the question" required><?= $dropdown['question'] ?></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Correct Answer:</label>
                                                <input type="text" name="correct_answer[<?= $dropdown['id'] ?>]" value="<?= $dropdown['correct_answer'] ?>" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <a href="?lessonid=<?= $lessonid ?>&delete_id=<?= $dropdown['id'] ?>" class="btn btn-danger">Delete</a>
                                            </div>
                                            <hr>
                                        <?php endforeach; ?>
                                        <button type="submit" name="update_dropdown" class="btn btn-primary">Update All</button>
                                    </div>
                                </form>
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
</body>

</html>