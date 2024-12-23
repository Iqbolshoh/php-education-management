<?php include 'auth.php' ?>
<?

$lessonid = isset($_GET['lessonid']) ? intval($_GET['lessonid']) : null;

if ($lessonid !== null) {
    $lessons_test = $query->select('lessons', '*', "id = '$lessonid'");
} else {
    $lessons_test = [];
}

$edit_matching_id = isset($_GET['edit_matching_id']) ? intval($_GET['edit_matching_id']) : null;

$matchings = [];
if ($lessonid !== null) {
    $matchings = $query->select('matching', '*', "lesson_id = '$lessonid'");
}

$edit_matching = null;
if ($edit_matching_id !== null) {
    $edit_matching = $query->select('matching', '*', "id = $edit_matching_id")[0] ?? null;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_matching'])) {
        $left_side = $_POST['left_side'];
        $right_side = $_POST['right_side'];

        $matching_id = $query->insert('matching', [
            'lesson_id' => $lessonid,
            'left_side' => $left_side,
            'right_side' => $right_side
        ]);
    } elseif (isset($_POST['update_matching'])) {
        $matching_id = $_POST['matching_id'];
        $left_side = $_POST['left_side'];
        $right_side = $_POST['right_side'];

        $query->update('matching', [
            'left_side' => $left_side,
            'right_side' => $right_side
        ], "id = $matching_id");
    }
    header("Location: ?lessonid=$lessonid");
    exit;
}

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $query->delete('matching', "id = '$delete_id'");
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
    <title>AdminLTE 3 | Matching</title>
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
                ["title" => "Matching", "url" => "#"],
            );
            pagePath('Matching', $arr);
            ?>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">

                        <?php if ($lessons_test): ?>

                            <form method="POST" class="edit-add">
                                <h4><?= $edit_matching ? 'Edit Matching' : 'Add New Matching' ?></h4>
                                <input type="hidden" name="matching_id" value="<?= $edit_matching['id'] ?? '' ?>">
                                <div class="form-group">
                                    <label for="left_side">Left Side</label>
                                    <textarea name="left_side" id="left_side" class="form-control" rows="4" placeholder="Enter left side content" required><?= $edit_matching['left_side'] ?? '' ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="right_side">Right Side</label>
                                    <input type="text" name="right_side" id="right_side" class="form-control" placeholder="Enter right side content" required value="<?= $edit_matching['right_side'] ?? '' ?>">
                                </div>

                                <div class="form-group mt-4">
                                    <button type="submit" name="<?= $edit_matching ? 'update_matching' : 'add_matching' ?>" class="btn btn-primary">Save Matching</button>
                                </div>
                            </form>

                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Matchings List</h3>
                                </div>
                                <table class="table table-bordered mt-4">
                                    <thead>
                                        <tr>
                                            <th>№</th>
                                            <th>Left Side</th>
                                            <th>Right Side</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($matchings as $index => $matching): ?>
                                            <tr>
                                                <td><?= $index + 1 ?></td>
                                                <td>
                                                    <p style="white-space: pre-wrap;"><?= $matching['left_side'] ?></p>
                                                </td>
                                                <td><?= $matching['right_side'] ?></td>
                                                <td>
                                                    <a href="?lessonid=<?= $lessonid ?>&edit_matching_id=<?= $matching['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                                    <a href="?lessonid=<?= $lessonid ?>&delete_id=<?= $matching['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
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