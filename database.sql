CREATE DATABASE IF NOT EXISTS letter_edu;

USE letter_edu;

CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(30) NOT NULL,
    last_name VARCHAR(30) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    username VARCHAR(30) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    profile_picture VARCHAR(255) DEFAULT 'default.png',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS lessons (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(100) NOT NULL,
    description VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS lesson_items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    lesson_id INT,
    type ENUM('video', 'content') NOT NULL,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    link VARCHAR(255),
    position INT NOT NULL,
    FOREIGN KEY (lesson_id) REFERENCES lessons(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    lesson_id INT,
    sentence TEXT NOT NULL,
    correct_answer VARCHAR(255) NOT NULL,
    FOREIGN KEY (lesson_id) REFERENCES lessons(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS options (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question_id INT,
    option_text VARCHAR(255) NOT NULL,
    FOREIGN KEY (question_id) REFERENCES questions(id) ON DELETE CASCADE
);

INSERT INTO
    users (
        first_name,
        last_name,
        email,
        username,
        password
    )
VALUES
    (
        'Iqbolshoh',
        'Ilhomjonov',
        'iilhomjonov777@gmail.com',
        'iqbolshoh',
        '65c2a32982abe41b1e6ff888d351ee6b7ade33affd4a595667ea7db910aecaa8'
    );

INSERT INTO
    lessons (title, description)
VALUES
    (
        'Basic English',
        'Learn the fundamentals of English, including grammar, vocabulary, and basic sentence structures.'
    ),
    (
        'Intermediate English',
        'Enhance your English skills with intermediate lessons on grammar, reading, and speaking.'
    ),
    (
        'Advanced English',
        'Master advanced topics, including complex grammar, professional vocabulary, and fluent conversation.'
    ),
    (
        'Business English',
        'Learn business-related vocabulary and phrases to communicate effectively in a professional environment.'
    ),
    (
        'English for Travel',
        'Prepare for travel by learning common phrases and vocabulary for navigating airports, hotels, and tourist destinations.'
    ),
    (
        'English for Exams',
        'Prepare for language exams like TOEFL, IELTS, or Cambridge with focused lessons on test strategies and skills.'
    ),
    (
        'English for Daily Conversations',
        'Improve your fluency with lessons on everyday conversations, including greetings, ordering food, and asking for directions.'
    );

INSERT INTO
    lesson_items (
        lesson_id,
        type,
        title,
        description,
        link,
        position
    )
VALUES
    (
        1,
        'video',
        'Basic English Video',
        'This video will guide you through the basics of English grammar, vocabulary, and common sentence structures with practical examples. By watching this video, you will gain a strong foundation for understanding and using English effectively in everyday situations.',
        'https://www.youtube.com/embed/dQw4w9WgXcQ',
        1
    ),
    (
        1,
        'content',
        'Introduction to Basic English',
        'In this lesson, you will explore the fundamentals of English grammar, including parts of speech, sentence construction, and essential vocabulary for beginners. You will also gain insights into the importance of mastering these basics for effective communication.',
        NULL,
        2
    ),
    (
        1,
        'content',
        'Sentence Structures and Phrases',
        'This section covers the construction of simple and compound sentences, as well as frequently used phrases in daily conversations. You will also learn techniques for identifying key patterns in English sentence structures to build your fluency.',
        NULL,
        3
    ),
    (
        1,
        'content',
        'Basic Pronunciation and Listening Skills',
        'In this lesson, we will focus on the basics of English pronunciation, helping you to articulate sounds clearly and accurately. You will also develop listening skills through practical exercises designed to improve your ability to understand spoken English in various contexts.',
        NULL,
        4
    );

INSERT INTO
    questions (lesson_id, sentence, correct_answer)
VALUES
    (1, 'I ____ to the store yesterday.', 'went'),
    (1, 'She ____ a book right now.', 'is reading'),
    (
        2,
        'They ____ in the park when it started raining.',
        'were playing'
    ),
    (2, 'I ____ never been to Paris.', 'have');

INSERT INTO
    options (question_id, option_text)
VALUES
    (1, 'go'),
    (1, 'went'),
    (1, 'going'),
    (1, 'gone'),
    (2, 'reads'),
    (2, 'read'),
    (2, 'is reading'),
    (2, 'was reading'),
    (3, 'are playing'),
    (3, 'were playing'),
    (3, 'play'),
    (3, 'played'),
    (4, 'had'),
    (4, 'have'),
    (4, 'has'),
    (4, 'having');