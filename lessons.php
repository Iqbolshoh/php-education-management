<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lessons - Letter Edu</title>
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


    .features {
        border-radius: 15px;
        background: linear-gradient(135deg, #ff6b81, #ff9a9e);
        color: white;
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

<body>

    <?php include 'includes/header.php'; ?>

    <div class="container">

        <section class="section features">
            <h1 class="section__title">Our Lessons</h1>
            <p class="section__content">Explore our lessons designed to help you master the English language at every
                level. Choose a lesson below to get started!</p>
        </section>

        <section class="section lessons-list">
            <div class="lesson-card">
                <h3>Basic English</h3>
                <p>Learn the fundamentals of English, including grammar, vocabulary, and basic sentence structures.</p>
                <a href="lesson_detail.php?lesson=basic-english"><button class="btn">Start Learning</button></a>
            </div>

            <div class="lesson-card">
                <h3>Intermediate English</h3>
                <p>Enhance your English skills with intermediate lessons on grammar, reading, and speaking.</p>
                <a href="lesson_detail.php?lesson=intermediate-english"><button class="btn">Start Learning</button></a>
            </div>

            <div class="lesson-card">
                <h3>Advanced English</h3>
                <p>Master advanced topics, including complex grammar, professional vocabulary, and fluent conversation.
                </p>
                <a href="lesson_detail.php?lesson=advanced-english"><button class="btn">Start Learning</button></a>
            </div>
        </section>

    </div>

    <?php include 'includes/footer.php'; ?>

</body>

</html>