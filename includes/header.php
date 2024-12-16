<head>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,500;1,400&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            font-size: 62.5%;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9fafb;
            color: #333;
        }

        header ul {
            list-style: none;
        }

        header a {
            text-decoration: none;
            color: inherit;
        }

        .header {
            border-bottom: 1px solid #e2e8f0;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 2rem;
            background-color: #ffffff;
        }

        .logo {
            font-size: 2.4rem;
            font-weight: 700;
            color: #482ff7;
        }

        .menu {
            display: flex;
            gap: 3rem;
        }

        .menu-item {
            font-size: 1.6rem;
            font-weight: 400;
        }

        .menu-item:hover,
        .menu-item.active {
            color: #482ff7;
            font-weight: 500;
        }

        .burger {
            display: none;
            flex-direction: column;
            gap: 0.6rem;
            cursor: pointer;
        }

        .burger-line {
            width: 25px;
            height: 3px;
            background-color: #334155;
        }

        .container {
            width: 100%;
            margin: auto;
            margin-top: 20px;
            margin-bottom: 30px;
            padding: 2rem;
            background-color: #ffffff;
        }

        @media (max-width: 768px) {
            .menu {
                position: fixed;
                left: -100%;
                top: 5rem;
                flex-direction: column;
                width: 100%;
                background-color: #ffffff;
                box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
                transition: all 0.3s ease;
                z-index: 1000;
                padding: 2rem;
            }

            .menu.active {
                left: 0;
            }

            .burger {
                display: flex;
            }

            .burger.active .burger-line:nth-child(1) {
                transform: translateY(8px) rotate(45deg);
            }

            .burger.active .burger-line:nth-child(2) {
                opacity: 0;
            }

            .burger.active .burger-line:nth-child(3) {
                transform: translateY(-8px) rotate(-45deg);
            }
        }
    </style>
</head>

<header class="header">
    <nav class="navbar">
        <a href="./" class="logo">Letter Edu</a>

        <?php
        $current_page = basename($_SERVER['PHP_SELF']);
        ?>

        <ul class="menu">
            <li><a href="./" class="menu-item <?= $current_page == 'index.php' ? 'active' : '' ?>">Home</a></li>
            <li><a href="about.php" class="menu-item <?= $current_page == 'about.php' ? 'active' : '' ?>">About US</a>
            </li>
            <li><a href="lessons.php"
                    class="menu-item <?= $current_page == 'lessons.php' ? 'active' : '' ?>">Lessons</a></li>
        </ul>

        <div class="burger">
            <span class="burger-line"></span>
            <span class="burger-line"></span>
            <span class="burger-line"></span>
        </div>
    </nav>
</header>

<script>
    const burger = document.querySelector('.burger');
    const menu = document.querySelector('.menu');

    burger.addEventListener('click', () => {
        burger.classList.toggle('active');
        menu.classList.toggle('active');
    });
</script>