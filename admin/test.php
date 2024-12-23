<?php include 'auth.php'?>
<?

$lessonid = isset($_GET['lessonid']) ? intval($_GET['lessonid']) : null;

if ($lessonid !== null) {
    $lessons_test = $query->select('lessons', '*', "id = '$lessonid'");
} else {
    $lessons_test = [];
}

$edit_test_id = isset($_GET['edit_test_id']) ? intval($_GET['edit_test_id']) : null;



$tests = [];
if ($lessonid !== null) {
    $tests = $query->select('test', '*', "lesson_id = '$lessonid'");
}

$edit_test = null;
if ($edit_test_id !== null) {
    $edit_test = $query->select('test', '*', "id = $edit_test_id")[0] ?? null;
    $edit_test_options = $query->select('test_options', '*', "test_id = $edit_test_id");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_test'])) {
        $question = $_POST['question'];
        $options = $_POST['options'];
        $correct_option = $_POST['correct_option'];

        $test_id = $query->insert('test', [
            'lesson_id' => $lessonid,
            'question' => $question
        ]);

        foreach ($options as $index => $option) {
            $query->insert('test_options', [
                'test_id' => $test_id,
                'option_text' => $option,
                'is_correct' => ($correct_option == $index) ? 1 : 0
            ]);
        }
    } elseif (isset($_POST['update_test'])) {
        $test_id = $_POST['test_id'];
        $question = $_POST['question'];
        $options = $_POST['options'];
        $correct_option = $_POST['correct_option'];

        $query->update('test', ['question' => $question], "id = $test_id");
        $query->delete('test_options', "test_id = $test_id");

        foreach ($options as $index => $option) {
            $query->insert('test_options', [
                'test_id' => $test_id,
                'option_text' => $option,
                'is_correct' => ($correct_option == $index) ? 1 : 0
            ]);
        }
    }
    header("Location: ?lessonid=$lessonid");
    exit;
}

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $query->delete('test', "id = '$delete_id'");
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
                ["title" => "Worksheet", "url" => "#"],
            );
            pagePath('Worksheet', $arr);
            ?>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">

                        <?php if ($lessons_test): ?>

                            <form method="POST" class="edit-add">
                                <h4><?= $edit_test ? 'Edit Test' : 'Add New Test' ?></h4>
                                <input type="hidden" name="test_id" value="<?= $edit_test['id'] ?? '' ?>">
                                <div class="form-group">
                                    <label for="question">Test Question</label>
                                    <textarea name="question" id="question" class="form-control" rows="4" placeholder="Enter the question" required><?= $edit_test['question'] ?? '' ?></textarea>
                                </div>

                                <div id="options-container">
                                    <label>Options:</label>
                                    <?php if ($edit_test): ?>
                                        <?php foreach ($edit_test_options as $index => $option): ?>
                                            <div class="option-item d-flex align-items-center mb-2">
                                                <input type="text" name="options[]" class="form-control mr-2" placeholder="Option text" value="<?= $option['option_text'] ?>" required>
                                                <input type="radio" name="correct_option" value="<?= $index ?>" <?= $option['is_correct'] ? 'checked' : '' ?>> Correct
                                                <button type="button" class="btn btn-danger btn-sm ml-2 remove-option">Remove</button>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <div class="option-item d-flex align-items-center mb-2">
                                            <input type="text" name="options[]" class="form-control mr-2" placeholder="Option text" required>
                                            <input type="radio" name="correct_option" value="0" required> Correct
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <button type="button" class="btn btn-secondary" id="add-option">Add Option</button>

                                <div class="form-group mt-4">
                                    <button type="submit" name="<?= $edit_test ? 'update_test' : 'add_test' ?>" class="btn btn-primary">Save Test</button>
                                </div>
                            </form>

                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Topics List</h3>
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
                                        <?php foreach ($tests as $index => $test): ?>
                                            <tr>
                                                <td><?= $index + 1 ?></td>
                                                <td>
                                                    <p style="white-space: pre-wrap;"><?= $test['question'] ?></p>
                                                </td>
                                                <td>
                                                    <a href="?lessonid=<?= $lessonid ?>&edit_test_id=<?= $test['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                                    <a href="?lessonid=<?= $lessonid ?>&delete_id=<?= $test['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
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
        document.getElementById('add-option').addEventListener('click', function() {
            const optionsContainer = document.getElementById('options-container');
            const optionCount = optionsContainer.querySelectorAll('.option-item').length;
            const optionHTML = `
            <div class="option-item d-flex align-items-center mb-2">
                <input type="text" name="options[]" class="form-control mr-2" placeholder="Option text" required>
                <input type="radio" name="correct_option" value="${optionCount}" required> Correct
                <button type="button" class="btn btn-danger btn-sm ml-2 remove-option">Remove</button>
            </div>`;
            optionsContainer.insertAdjacentHTML('beforeend', optionHTML);
        });

        document.getElementById('options-container').addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-option')) {
                e.target.closest('.option-item').remove();
            }
        });
    </script>

</body>

</html>