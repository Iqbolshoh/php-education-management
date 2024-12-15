<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lessons - Letter Edu</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        .section {
            padding: 5rem 2rem;
            text-align: center;
            margin: 2rem 0;
        }

        .section__title {
            font-size: 3rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            letter-spacing: -1.5px;
        }

        .section__content {
            font-size: 1.6rem;
            font-weight: 400;
            margin-bottom: 2.5rem;
            opacity: 0.9;
            letter-spacing: 0.5px;
        }

        .lessons-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 2rem;
        }

        .lesson-card {
            background: linear-gradient(135deg, #6c5ce7, #a29bfe);
            padding: 2.5rem;
            border-radius: 15px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            width: 300px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
            color: white;
            position: relative;
            opacity: 0;
            animation: slideUpFade 0.7s ease forwards;
        }

        .lesson-card:hover {
            transform: translateY(-15px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.2);
        }

        .lesson-card h3 {
            font-size: 2.2rem;
            color: #fff;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.3);
        }

        .lesson-card p {
            font-size: 1.4rem;
            color: #f7f7f7;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .features {
            border-radius: 15px;
            background: linear-gradient(135deg, #ff6b81, #ff9a9e);
            color: white;
            animation: slideUpFade 0.7s ease forwards;
        }

        .btn {
            font-size: 1.6rem;
            font-weight: 600;
            padding: 1rem 2.5rem;
            background-color: #ff6b81;
            color: white;
            border-radius: 50px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        }

        .btn:hover {
            background-color: #d65a71;
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
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

        @media (max-width: 768px) {
            .section__title {
                font-size: 2.5rem;
            }

            .section__content {
                font-size: 1.4rem;
            }

            .lessons-list {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>

<body>
    <?php include 'includes/header.php'; ?>

    <div class="container">
        <section class="section features">
            <h1 class="section__title">Our Lessons</h1>
            <p class="section__content">Explore our lessons designed to help you master the English language at every
                level. Choose a lesson below to get started!</p>
        </section>

        <section class="section lessons-list">
            <?php
            $lessons = [
                ['title' => 'Basic English', 'description' => 'Learn the fundamentals of English, including grammar, vocabulary, and basic sentence structures.', 'id' => 1],
                ['title' => 'Intermediate English', 'description' => 'Enhance your English skills with intermediate lessons on grammar, reading, and speaking.', 'id' => 2],
                ['title' => 'Advanced English', 'description' => 'Master advanced topics, including complex grammar, professional vocabulary, and fluent conversation.', 'id' => 3],
            ];

            $delay = 0;

            foreach ($lessons as $lesson): ?>
                <div class="lesson-card" style="animation-delay: <?= $delay ?>s;">
                    <h3><?= htmlspecialchars($lesson['title']) ?></h3>
                    <p><?= htmlspecialchars($lesson['description']) ?></p>
                    <a href="lesson_detail.php?lessonid=<?= urlencode($lesson['id']) ?>">
                        <button class="btn">Start Learning</button>
                    </a>
                </div>
                <?php
                $delay += 0.1;
            endforeach;
            ?>

        </section>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>

</html>