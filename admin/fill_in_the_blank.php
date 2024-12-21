<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ./login/");
    exit;
}

include './config.php';
$query = new Database();

$lessonid = isset($_GET['lessonid']) ? intval($_GET['lessonid']) : null;
$edit_blank_id = isset($_GET['edit_blank_id']) ? intval($_GET['edit_blank_id']) : null;

$blanks = [];
if ($lessonid !== null) {
    $blanks = $query->select('fill_in_the_blank', '*', "lesson_id = '$lessonid'");
}

$edit_blank = null;
if ($edit_blank_id !== null) {
    $edit_blank = $query->select('fill_in_the_blank', '*', "id = $edit_blank_id")[0] ?? null;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_blank'])) {
        $sentence = $_POST['sentence'];
        $correct_answer = $_POST['correct_answer'];

        $blank_id = $query->insert('fill_in_the_blank', [
            'lesson_id' => $lessonid,
            'sentence' => $sentence,
            'correct_answer' => $correct_answer
        ]);
    } elseif (isset($_POST['update_blank'])) {
        $blank_id = $_POST['blank_id'];
        $sentence = $_POST['sentence'];
        $correct_answer = $_POST['correct_answer'];

        $query->update('fill_in_the_blank', [
            'sentence' => $sentence,
            'correct_answer' => $correct_answer
        ], "id = $blank_id");
    }
    header("Location: ?lessonid=$lessonid");
    exit;
}

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $query->delete('fill_in_the_blank', "id = '$delete_id'");
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
    <title>AdminLTE 3 | Fill in the Blank</title>
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
                ["title" => "Fill in the Blank", "url" => "#"],
            );
            pagePath('Fill in the Blank', $arr);
            ?>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">

                        <?php if ($blanks): ?>

                            <form method="POST" class="edit-add">
                                <h4><?= $edit_blank ? 'Edit Blank' : 'Add New Blank' ?></h4>
                                <input type="hidden" name="blank_id" value="<?= $edit_blank['id'] ?? '' ?>">
                                <div class="form-group">
                                    <label for="sentence">Sentence with Blank</label>
                                    <textarea name="sentence" id="sentence" class="form-control" rows="2" placeholder="Enter the sentence with a blank" required><?= $edit_blank['sentence'] ?? '' ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="correct_answer">Correct Answer</label>
                                    <input type="text" name="correct_answer" id="correct_answer" class="form-control" placeholder="Enter the correct answer" required value="<?= $edit_blank['correct_answer'] ?? '' ?>">
                                </div>

                                <div class="form-group mt-4">
                                    <button type="submit" name="<?= $edit_blank ? 'update_blank' : 'add_blank' ?>" class="btn btn-primary">Save Blank</button>
                                </div>
                            </form>

                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Blanks List</h3>
                                </div>
                                <table class="table table-bordered mt-4">
                                    <thead>
                                        <tr>
                                            <th>№</th>
                                            <th>Sentence</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($blanks as $index => $blank): ?>
                                            <tr>
                                                <td><?= $index + 1 ?></td>
                                                <td><?= htmlspecialchars($blank['sentence']) ?></td>
                                                <td>
                                                    <a href="?lessonid=<?= $lessonid ?>&edit_blank_id=<?= $blank['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                                    <a href="?lessonid=<?= $lessonid ?>&delete_id=<?= $blank['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
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
    </div>
    <?php include 'includes/js.php'; ?>
</body>

</html>