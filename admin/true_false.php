<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ./login/");
    exit;
}

include './config.php';
$query = new Database();

$lessonid = isset($_GET['lessonid']) ? intval($_GET['lessonid']) : null;

$true_false = [];
if ($lessonid !== null) {
    $true_false = $query->select('tru_false', '*', "lesson_id = '$lessonid'");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_true_false'])) {
        $statement = ($_POST['statement']);
        $is_true = isset($_POST['is_true']) ? 1 : 0;

        $query->insert('tru_false', [
            'lesson_id' => $lessonid,
            'statement' => $statement,
            'is_true' => $is_true
        ]);

        header("Location: true_false.php?lessonid=$lessonid");
        exit;
    }

    if (isset($_POST['update_true_false'])) {
        foreach ($_POST['statement'] as $id => $statement) {
            $statement = ($statement);
            $is_true = isset($_POST['is_true'][$id]) ? 1 : 0;

            $query->update('tru_false', [
                'statement' => $statement,
                'is_true' => $is_true
            ], "id = '$id'");
        }
        header("Location: true_false.php?lessonid=$lessonid");
        exit;
    }
}


if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $query->delete('tru_false', "id = '$delete_id'");
    header("Location: true_false.php?lessonid=$lessonid");
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
    <title>Admin | True/False</title>
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

    .form-container {
        background-color: #f9f9f9;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-top: 20px;
        border: 1px solid #ddd;
    }

    .form-container h3 {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .form-group label {
        font-size: 18px;
        color: #333;
        margin-bottom: 8px;
    }

    .form-control {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 4px;
        background-color: #fff;
        color: #333;
    }

    .form-control:focus {
        border-color: #007bff;
        outline: none;
    }

    .checkbox-label {
        font-size: 16px;
        color: #333;
    }

    .submit-btn {
        background-color: #007bff;
        padding: 12px 30px;
        font-size: 16px;
        border: none;
        border-radius: 4px;
        color: white;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .submit-btn:hover {
        background-color: #0056b3;
    }

    .card {
        padding: 10px;
    }
</style>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php include 'includes/navbar.php' ?>
        <div class="content-wrapper">

            <?php
            $arr = array(
                ["title" => "Home", "url" => "./"],
                ["title" => "True/False", "url" => "#"],
            );
            pagePath('True/False', $arr);
            ?>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">

                        <?php if ($true_false): ?>
                            <div class="col-12">
                                <div class="col-12">
                                    <div class="form-container">
                                        <h4>Add New True/False Question</h4>
                                        <form method="POST">
                                            <input type="hidden" name="lessonid" value="<?= $lessonid ?>">

                                            <div class="form-group">
                                                <label for="statement">Question Statement</label>
                                                <textarea name="statement" id="statement" class="form-control" rows="4" required></textarea>
                                            </div>

                                            <div class="form-group">
                                                <label for="is_true" class="checkbox-label">Is this statement true?</label>
                                                <input type="checkbox" name="is_true" id="is_true" value="1"> Yes
                                            </div>

                                            <button type="submit" name="add_true_false" class="submit-btn">Add Question</button>
                                        </form>
                                    </div>
                                    <br>

                                    <div class="card">
                                        <form method="POST">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>№</th>
                                                        <th>Statement</th>
                                                        <th>Answer</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($true_false as $index => $question): ?>
                                                        <tr>
                                                            <td><?= $index + 1 ?></td>
                                                            <td>
                                                                <textarea name="statement[<?= $question['id'] ?>]" class="form-control" rows="3"><?= $question['statement'] ?></textarea>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" name="is_true[<?= $question['id'] ?>]" <?= $question['is_true'] ? 'checked' : '' ?>>
                                                            </td>
                                                            <td>
                                                                <a href="true_false.php?lessonid=<?= $lessonid ?>&delete_id=<?= $question['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>

                                            <button type="submit" name="update_true_false" class="btn btn-primary">Update Questions</button>
                                        </form>
                                    </div>
                                    <br>
                                    <br>
                                </div>
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