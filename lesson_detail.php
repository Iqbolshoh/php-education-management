<?php

if (isset($_GET['lessonid'])) {
    $lessonid = intval($_GET['lessonid']);
} else {
    header('Location: index.php');
    exit();
}

$lessons = [
    1 => [
        'title' => 'Basic English',
        'description' => 'Learn the fundamentals of English, including grammar, vocabulary, and basic sentence structures.',
        'content' => [
            'This lesson will introduce you to the basics of English grammar and vocabulary.',
            'You will learn sentence structures, common words, and phrases used in everyday conversations.',
            'We will also cover basic pronunciation and listening skills.',
        ],
        'video' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
    ],
    2 => [
        'title' => 'Intermediate English',
        'description' => 'Enhance your English skills with intermediate lessons on grammar, reading, and speaking.',
        'content' => [
            'In this lesson, you will delve deeper into English grammar, including verb tenses and complex sentence structures.',
            'We will focus on reading comprehension and listening skills to help improve your fluency.',
            'A variety of exercises will test and improve your skills in speaking and writing.',
        ],
        'video' => 'https://www.youtube.com/embed/kJQP7kiw5Fk',
    ],
    3 => [
        'title' => 'Advanced English',
        'description' => 'Master advanced topics, including complex grammar, professional vocabulary, and fluent conversation.',
        'content' => [
            'This advanced course will take your English skills to the next level, focusing on high-level grammar topics.',
            'You will learn about idiomatic expressions and advanced vocabulary for professional contexts.',
            'We will also emphasize fluent conversation with practice activities.',
        ],
        'video' => 'https://www.youtube.com/embed/M7lc1UVf-VE',
    ],
];

if (array_key_exists($lessonid, $lessons)) {
    $lesson = $lessons[$lessonid];
} else {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($lesson['title']) ?></title>
    <link rel="stylesheet" href="styles.css">
</head>

<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f8f9fa;
        margin: 0;
        padding: 0;
    }

    .container {
        background-color: #f8f9fa;
        max-width: 900px;
        margin: 0 auto;
        padding: 20px;
    }

    .lesson {
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        padding: 40px;
        margin-top: 30px;
        margin-bottom: 40px;
    }

    .lesson-title {
        font-size: 36px;
        color: #333;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .lesson-description {
        font-size: 18px;
        color: #555;
        margin-bottom: 25px;
        line-height: 1.6;
    }

    .lesson-content p {
        font-size: 16px;
        line-height: 1.8;
        color: #666;
        margin-bottom: 20px;
    }

    .video-container {
        margin-top: 40px;
        margin-bottom: 40px;
    }

    .video-container h3 {
        font-size: 24px;
        color: #333;
        margin-bottom: 15px;
    }

    iframe {
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .buttons {
        display: flex;
        gap: 25px;
        justify-content: center;
    }

    .btn {
        padding: 15px 30px;
        border: none;
        border-radius: 5px;
        font-size: 18px;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.3s, transform 0.2s;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .btn-back {
        background-color: #007bff;
        color: #fff;
    }

    .btn-back:hover {
        background-color: #0056b3;
        transform: translateY(-2px);
    }

    .btn-test {
        background-color: #28a745;
        color: #fff;
    }

    .btn-test:hover {
        background-color: #218838;
        transform: translateY(-2px);
    }

    a {
        text-decoration: none;
    }

    @media (max-width: 768px) {
        .lesson-title {
            font-size: 30px;
        }

        .lesson-description {
            font-size: 16px;
        }

        .lesson-content p {
            font-size: 14px;
        }

        iframe {
            width: 100%;
            height: auto;
        }
    }
</style>

<body>
    <?php include 'includes/header.php'; ?>

    <div class="container">
        <section class="lesson">
            <h1 class="lesson-title"><?= htmlspecialchars($lesson['title']) ?></h1>
            <p class="lesson-description"><?= htmlspecialchars($lesson['description']) ?></p>

            <div class="lesson-content">
                <?php foreach ($lesson['content'] as $content): ?>
                    <p><?= nl2br(htmlspecialchars($content)) ?></p>
                <?php endforeach; ?>
            </div>

            <div class="video-container">
                <h3>Watch the video:</h3>
                <iframe width="100%" height="315" src="<?= htmlspecialchars($lesson['video']) ?>" frameborder="0"
                    allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen></iframe>
            </div>

            <div class="buttons">
                <a href="lessons.php">
                    <button class="btn btn-back">Back to Lessons</button>
                </a>

                <a href="woorksheet.php?lessonid=<?= $lessonid ?>">
                    <button class="btn btn-test">Worksheet</button>
                </a>
            </div>
        </section>
    </div>

    <?php include 'includes/footer.php'; ?>

</body>

</html>