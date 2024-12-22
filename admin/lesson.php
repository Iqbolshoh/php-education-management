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


if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['add_lesson'])) {
    foreach ($_POST['title'] as $id => $title) {
        $description =  $_POST['description'][$id];
        $type =  $_POST['type'][$id];
        $link =  $_POST['link'][$id];
        $position = (int)$_POST['position'][$id];

        $query->update('lesson_items', [
            'title' => $title,
            'description' => $description,
            'type' => $type,
            'link' => $link,
            'position' => $position
        ], "id = '$id'");
    }

    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    $query->delete('lesson_items', "id = '$delete_id'");

    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_lesson'])) {
    $title = $_POST['title'];
    $description =  $_POST['description'];
    $type =  $_POST['type'];
    $link =  $_POST['link'];
    $position = (int)$_POST['position'];

    $query->insert('lesson_items', [
        'lesson_id' => $lessonid,
        'title' => $title,
        'description' => $description,
        'type' => $type,
        'link' => $link,
        'position' => $position
    ]);

    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}

$lessons = $query->select('lesson_items', '*', "lesson_id = '$lessonid' ORDER BY position ASC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="../favicon.ico">
    <title>AdminLTE 3 | Lesson</title>
    <?php include 'includes/css.php'; ?>
</head>
<style>
    body {
        box-sizing: border-box;
    }

    .lesson-item {
        background-color: rgb(255, 255, 255);
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        margin: 0px 10px;
        margin-bottom: 20px;
        max-width: calc(100% - 20px);
        transition: box-shadow 0.3s ease;
        border: 1px solid #e0e0e0;
    }

    .lesson-item form {
        display: flex;
        flex-direction: column;
    }

    .lesson-item .form-group {
        margin-bottom: 20px;
    }

    .lesson-item label {
        font-weight: bold;
        margin-bottom: 5px;
        color: #333;
    }

    .lesson-item input,
    .lesson-item textarea {
        width: 100%;
        padding: 15px;
        font-size: 16px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: rgb(255, 255, 255);
        color: #333;
        transition: border-color 0.3s ease;
    }

    .lesson-item input:focus,
    .lesson-item textarea:focus {
        border-color: #00aaff;
        outline: none;
    }

    .lesson-item textarea {
        min-height: 120px;
        resize: vertical;
    }

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

    @media (max-width: 768px) {
        .lesson-item {
            padding: 15px;
        }

        .lesson-item button {
            width: 100%;
        }
    }

    .lesson-item-title {
        font-size: 20px;
        font-weight: 600;
        color: #333;
        background-color: #f4f6f9;
        border: 1px solid #e0e0e0;
        padding: 10px;
        margin-bottom: 20px;
        border-radius: 8px;
        display: inline-block;
        text-align: center;
        text-transform: uppercase;
        letter-spacing: 1px;
        width: 100%;
    }

    .item-lesson {
        background-color: rgb(255, 255, 255);
        margin-bottom: 25px;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        border: 1px solid #eee;
    }

    .item-lesson .form-group {
        margin-bottom: 15px;
    }

    .item-lesson input,
    .item-lesson textarea,
    .form-control {
        font-size: 16px;
        border-radius: 6px;
        background-color: rgb(255, 255, 255);

    }
</style>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php include 'includes/navbar.php' ?>
        <div class="content-wrapper">

            <?php
            $arr = array(
                ["title" => "Home", "url" => "./"],
                ["title" => "Lesson", "url" => "#"],
            );
            pagePath('Lesson', $arr);
            ?>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">

                        <?php if ($lessons_test): ?>

                            <div class="lesson-item col-12">
                                <form method="POST">
                                    <h3>Add New Lesson Item</h3>

                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <input type="text" name="title" class="form-control" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea name="description" class="form-control" required></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="type">Type</label>
                                        <select name="type" class="form-control" required onchange="toggleLinkField(this)">
                                            <option value="content">Content</option>
                                            <option value="video">Video</option>
                                        </select>
                                    </div>

                                    <div class="form-group video-link" id="link-field" style="display: none;">
                                        <label for="link">Link (youtube.com)</label>
                                        <input type="text" name="link" class="form-control" id="link" oninput="extractVideoId(this)">
                                    </div>

                                    <div class="form-group">
                                        <label for="position">Position</label>
                                        <input type="number" name="position" class="form-control" required>
                                    </div>

                                    <button type="submit" name="add_lesson" class="btn btn-primary">Add Lesson</button>
                                </form>
                            </div>

                            <br>
                            <br>

                            <?php if ($lessons): ?>
                                <div class="lesson-item col-12">
                                    <form method="POST">
                                        <?php foreach ($lessons as $index => $lesson): ?>
                                            <div class="item-lesson">
                                                <div class="form-group">
                                                    <p class="lesson-item-title"><strong>Item_<?= $index + 1 ?></strong></p>
                                                    <label for="title[<?php echo $lesson['id']; ?>]">Title</label>
                                                    <input type="text" name="title[<?php echo $lesson['id']; ?>]" value="<?php echo  ($lesson['title']); ?>" class="form-control" required>
                                                </div>

                                                <div class="form-group">
                                                    <label for="description[<?php echo $lesson['id']; ?>]">Description</label>
                                                    <textarea name="description[<?php echo $lesson['id']; ?>]" class="form-control" required><?php echo  ($lesson['description']); ?></textarea>
                                                </div>

                                                <div class="form-group">
                                                    <label for="type[<?php echo $lesson['id']; ?>]">Type</label>
                                                    <select name="type[<?php echo $lesson['id']; ?>]" class="form-control" required onchange="toggleLinkField1(this, <?php echo $lesson['id']; ?>)">
                                                        <option value="content" <?php echo ($lesson['type'] == 'content') ? 'selected' : ''; ?>>Content</option>
                                                        <option value="video" <?php echo ($lesson['type'] == 'video') ? 'selected' : ''; ?>>Video</option>
                                                    </select>
                                                </div>

                                                <div class="form-group video-link" id="link-field-<?php echo $lesson['id']; ?>" style="display: <?php echo ($lesson['type'] == 'video') ? 'block' : 'none'; ?>;">
                                                    <label for="link[<?php echo $lesson['id']; ?>]">Link </label> <span>(youtube.com)</span>
                                                    <input type="text" name="link[<?php echo $lesson['id']; ?>]" value="<?php echo  ($lesson['link']); ?>" class="form-control" id="link-<?php echo $lesson['id']; ?>" oninput="extractVideoId1(this, <?php echo $lesson['id']; ?>)">
                                                </div>

                                                <div class="form-group">
                                                    <label for="position[<?php echo $lesson['id']; ?>]">Position</label>
                                                    <input type="number" name="position[<?php echo $lesson['id']; ?>]" value="<?php echo $lesson['position']; ?>" class="form-control" required>
                                                </div>
                                                <a href="?delete_id=<?php echo $lesson['id']; ?>" class="btn btn-danger">Delete</a>
                                            </div>
                                        <?php endforeach; ?>
                                        <button type="submit" class="btn btn-warning mt-2">Update All</button>
                                    </form>
                                </div>

                            <?php endif; ?>

                        <?php else: ?>
                            <form method="get" style="min-width: min(400px, 100%); margin: 50px auto; border: 1px solid #ddd; border-radius: 8px; padding: 20px; background-color: #f9f9f9; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                                <?php $lessons = $query->select('lessons', '*'); ?>

                                <div class="form-group" style="margin-bottom: 20px;">
                                    <label for="lessonid" style="display: block; font-size: 18px; font-weight: bold; color: #333; margin-bottom: 8px;">Select a Lesson</label>
                                    <select name="lessonid" id="lessonid" class="form-control" style="width: 100%; padding: 5px; font-size: 16px; border: 1px solid #ccc; border-radius: 4px; background-color: #fff; color: #333;">
                                        <option value="" selected disabled>-- Select a Lesson --</option>
                                        <?php foreach ($lessons as $lesson): ?>
                                            <option value="<?= $lesson['id'] ?>" <?= $lesson['id'] == $lessonid ? 'selected' : '' ?>>
                                                <?= $lesson['id'] . ". " . $lesson['title'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group" style="text-align: center;">
                                    <button type="submit" class="btn btn-primary" style="padding: 12px 30px; font-size: 16px; background-color: #007bff; border: none; border-radius: 4px; color: white; cursor: pointer; transition: background-color 0.3s;">
                                        Submit
                                    </button>
                                </div>
                            </form>
                        <?php endif; ?>

                    </div>
                </div>
            </section>

        </div>
        <br>

        <?php include 'includes/footer.php'; ?>
    </div>

    <?php include 'includes/js.php'; ?>

    <script>
        function toggleLinkField1(selectElement, lessonId) {
            const linkField = document.getElementById('link-field-' + lessonId);

            if (selectElement.value === 'video') {
                linkField.style.display = 'block';
            } else {
                linkField.style.display = 'none';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const selects = document.querySelectorAll('select[name^="type"]');
            selects.forEach(function(select) {
                const lessonId = select.name.match(/\d+/)[0];
                toggleLinkField1(select, lessonId);
            });
        });

        function extractVideoId1(inputElement, lessonId) {
            const videoUrl = inputElement.value;
            const regex = /[?&]v=([a-zA-Z0-9_-]+)/;
            const match = videoUrl.match(regex);

            if (match && match[1]) {
                document.querySelector(`#link-${lessonId}`).value = match[1];
            } else {
                document.querySelector(`#link-${lessonId}`).value = '';
            }
        }

        function toggleLinkField(selectElement) {
            const linkField = document.getElementById('link-field');

            if (selectElement.value === 'video') {
                linkField.style.display = 'block';
            } else {
                linkField.style.display = 'none';
            }
        }

        function extractVideoId(inputElement) {
            const videoUrl = inputElement.value;
            const regex = /[?&]v=([a-zA-Z0-9_-]+)/;
            const match = videoUrl.match(regex);

            if (match && match[1]) {
                inputElement.value = match[1];
            } else {
                inputElement.value = '';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const selectElement = document.querySelector('select[name="type"]');
            toggleLinkField(selectElement);
        });
    </script>
</body>

</html>