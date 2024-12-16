<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aboutn US</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>

<style>
    body {
        margin: 0;
        padding: 0;
        font-family: 'Poppins', sans-serif;
        background-color: #f7f7f7;
    }

    .section {
        padding: 5rem 2rem;
        text-align: center;
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

    .call-to-action {
        border-top-right-radius: 15px;
        border-top-left-radius: 15px;
        background: linear-gradient(135deg, #6c5ce7, #a29bfe);
        color: white;
        animation: fadeInUp 1s ease-out forwards;
    }

    .features {
        border-bottom-right-radius: 15px;
        border-bottom-left-radius: 15px;
        background: linear-gradient(135deg, #ff6b81, #ff9a9e);
        color: white;
        animation: fadeInUp 1s ease-out forwards;
    }

    @keyframes fadeInUp {
        0% {
            opacity: 0;
            transform: translateY(50px);
        }

        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .btn {
        font-size: 1.6rem;
        font-weight: 600;
        padding: 1.3rem 3rem;
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

    @media (max-width: 768px) {
        .section__title {
            font-size: 2.5rem;
        }

        .section__content {
            font-size: 1.4rem;
        }
    }
</style>

<body>

    <?php include 'includes/header.php' ?>

    <div class="container">

        <section class="section call-to-action">
            <h2 class="section__title">Start Learning Today!</h2>
            <p class="section__content">Don't wait to improve your English. Click below to start practicing and
                exploring
                our lessons!</p>
            <button class="btn" onclick="window.location.href='lessons.php'">Start Learning</button>
        </section>

        <br>

        <section class="section features">
            <h2 class="section__title">Features of Letter Edu</h2>
            <p class="section__content">Our platform offers a variety of features to help you succeed:</p>
            <ul style="font-size: 1.5rem; text-align: left; margin-left: 15%; max-width: 800px; line-height: 1.8;">
                <li>Interactive Lessons for Different Levels</li>
                <li>Real-time Vocabulary Building Exercises</li>
                <li>Grammar and Pronunciation Practice</li>
                <li>Progress Tracking & Personalized Recommendations</li>
                <li>Quizzes and Tests to Reinforce Learning</li>
            </ul>
        </section>

    </div>

    <?php include 'includes/footer.php' ?>


</body>

</html>