<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>

<style>
    .hero {
        margin-top: 70px;
        text-align: center;
        padding: 6rem 2rem;
        background: linear-gradient(135deg, #6c5ce7, #a29bfe);
        color: white;
        border-radius: 10px;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        max-width: 1200px;
        margin: 0 auto;
    }

    .hero__title {
        font-size: 4rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        letter-spacing: -1px;
        text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.2);
    }

    .hero__subtitle {
        font-size: 1.8rem;
        font-weight: 400;
        margin-bottom: 2.5rem;
        opacity: 0.9;
    }

    .hero__button {
        font-size: 1.6rem;
        font-weight: 600;
        padding: 1.2rem 2.5rem;
        background-color: #ff6b81;
        color: white;
        border-radius: 50px;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        letter-spacing: 1px;
    }

    .hero__button:hover {
        background-color: #d65a71;
        transform: scale(1.05);
    }

    .hero__button:focus {
        outline: none;
    }
</style>

<body>

    <?php include 'includes/header.php' ?>

    <section class="hero">
        <h1 class="hero__title">Welcome to Letter Edu</h1>
        <p class="hero__subtitle">Your trusted platform for online education and services.</p>
        <button class="hero__button">Get Started</button>
    </section>

</body>

</html>