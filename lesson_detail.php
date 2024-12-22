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
    $lesson_items = $query->select('lesson_items', '*', "lesson_id = $lessonid ORDER BY position ASC");
} else {
    header('Location: lessons.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $lesson['title'] ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        .container {
            max-width: 900px;
            margin: 20px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            animation: slideUpFade 1s ease forwards;
        }

        .lesson-title {
            font-size: 36px;
            color: #ff6b81;
            text-align: center;
            margin-bottom: 20px;
        }

        .lesson-description {
            font-size: 18px;
            color: #555;
            margin-bottom: 30px;
            text-align: center;
        }

        .lesson-content h2,
        .video-title {
            font-size: 24px;
            color: #ff6b81;
            margin-bottom: 15px;
        }

        .lesson-content p,
        .video-wrapper {
            font-size: 16px;
            color: #2c3e50;
            margin-bottom: 15px;
            text-align: justify;
            line-height: 1.5;
        }

        .video-wrapper {
            margin-top: 40px;
        }

        .video-wrapper iframe {
            width: 100%;
            height: 450px;
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .action-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            gap: 20px;
        }

        .action-buttons a {
            display: block;
            text-decoration: none;
            color: #fff;
            background-color: #3498db;
            padding: 15px 30px;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 700;
            text-align: center;
            transition: background-color 0.3s, transform 0.3s;
        }

        .action-buttons a:hover {
            background-color: #2980b9;
            transform: translateY(-3px);
        }

        hr {
            border: none;
            height: 1px;
            background: #ff6b81;
            margin: 40px 0;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .lesson-title {
                font-size: 28px;
            }

            .lesson-description {
                font-size: 16px;
            }

            .lesson-content h2,
            .video-title {
                font-size: 20px;
            }

            .lesson-content p,
            .video-wrapper {
                font-size: 14px;
            }

            .video-wrapper iframe {
                height: 300px;
            }

            .action-buttons {
                flex-direction: column;
                align-items: center;
            }

            .action-buttons a {
                width: 100%;
                margin-bottom: 10px;
            }
        }
    </style>
</head>

<body>
    <?php include 'includes/header.php'; ?>

    <div class="container">
        <section class="lesson-section">
            <h1 class="lesson-title"><?= $lesson['title'] ?></h1>
            <p class="lesson-description"><?= $lesson['description'] ?></p>

            <hr>

            <?php foreach ($lesson_items as $item): ?>
                <?php if ($item['type'] == 'content'): ?>
                    <div class="lesson-content">
                        <h2><?= $item['title'] ?></h2>
                        <p style="white-space: pre-wrap;"><?= $item['description'] ?></p>
                    </div>
                <?php elseif ($item['type'] == 'video'): ?>
                    <div class="video-wrapper">
                        <h2 class="video-title"><?= $item['title'] ?></h2>
                        <iframe src="https://youtube.com/embed/<?= $item['link'] ?>" title="<?= $item['title'] ?>"></iframe>
                        <p style="white-space: pre-wrap;"><?= $item['description'] ?></p>
                    </div>

                    <br>
                <?php endif; ?>
            <?php endforeach; ?>

            <div class="action-buttons">
                <a href="lessons.php">Back to Lessons</a>
                <a href="worksheet.php?lessonid=<?= $lessonid ?>">Worksheet </a>
            </div>
        </section>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>

</html>