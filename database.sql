DROP DATABASE IF EXISTS UZWRITER_UZ;

CREATE DATABASE IF NOT EXISTS UZWRITER_UZ;

USE UZWRITER_UZ;

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

CREATE TABLE IF NOT EXISTS test (
    id INT PRIMARY KEY AUTO_INCREMENT,
    lesson_id INT,
    question TEXT NOT NULL,
    FOREIGN KEY (lesson_id) REFERENCES lessons(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS test_options (
    id INT PRIMARY KEY AUTO_INCREMENT,
    test_id INT NOT NULL,
    option_text VARCHAR(255) NOT NULL,
    is_correct BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (test_id) REFERENCES test(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS tru_false (
    id INT PRIMARY KEY AUTO_INCREMENT,
    lesson_id INT,
    statement TEXT NOT NULL,
    is_true BOOLEAN NOT NULL,
    FOREIGN KEY (lesson_id) REFERENCES lessons(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS dropdown (
    id INT PRIMARY KEY AUTO_INCREMENT,
    lesson_id INT,
    question TEXT NOT NULL,
    correct_answer VARCHAR(255) NOT NULL,
    FOREIGN KEY (lesson_id) REFERENCES lessons(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS fill_in_the_blank (
    id INT PRIMARY KEY AUTO_INCREMENT,
    lesson_id INT,
    sentence TEXT NOT NULL,
    correct_answer VARCHAR(255) NOT NULL,
    FOREIGN KEY (lesson_id) REFERENCES lessons(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS matching (
    id INT PRIMARY KEY AUTO_INCREMENT,
    lesson_id INT,
    left_side TEXT NOT NULL,
    right_side TEXT NOT NULL,
    FOREIGN KEY (lesson_id) REFERENCES lessons(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS results (
    id INT PRIMARY KEY AUTO_INCREMENT,
    lesson_id INT,
    participant_name VARCHAR(255) NOT NULL,
    total_questions INT NOT NULL,
    answered_questions INT NOT NULL,
    FOREIGN KEY (lesson_id) REFERENCES lessons(id) ON DELETE CASCADE
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
    lessons (id, title, description)
VALUES
    (
        1,
        'Beginner English',
        'Basic English lessons for beginners.'
    ),
    (
        2,
        'Intermediate English',
        'Intermediate-level English to enhance your skills.'
    ),
    (
        3,
        'Advanced English',
        'Advanced-level English for fluency and precision.'
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
        'content',
        'Basic Greetings',
        'Learn how to greet people and introduce yourself in English. Understand various greetings used in different contexts such as formal, informal, and casual settings. This lesson will introduce common phrases like "How are you?" and "Nice to meet you." You will also explore cultural nuances and appropriate responses, helping you feel confident when initiating conversations in English-speaking environments.',
        '',
        3
    ),
    (
        1,
        'video',
        'Introduction to English Alphabet',
        'This lesson covers the English alphabet, helping you recognize each letter, understand its pronunciation, and discover common words that begin with each letter. You will also see demonstrations of how each letter is articulated in various words. This foundational lesson will strengthen your reading and writing skills and help you improve letter recognition for both uppercase and lowercase characters.',
        '_neP6775wCY?si=uK0q15aYVrUBiyK7',
        1
    ),
    (
        1,
        'content',
        'Common Verbs',
        'This lesson focuses on frequently used verbs in English, their basic forms, and how to incorporate them into different sentence structures. You will learn the most common verbs and practice using them in affirmative, negative, and interrogative sentences. The goal is to help you use verbs naturally in your conversations, and we will provide tips for memorizing them to boost your confidence.',
        '',
        4
    ),
    (
        1,
        'video',
        'Basic Pronunciation Tips',
        'Improve your pronunciation with clear examples and tips on how to pronounce common words in English. We’ll focus on identifying frequent pronunciation mistakes and strategies to avoid them. This lesson highlights the importance of stress and intonation in spoken English, teaching you how to sound more natural when speaking. You will also practice mimicking native speakers to develop better fluency and clarity in your pronunciation.',
        '_neP6775wCY?si=uK0q15aYVrUBiyK7',
        2
    ),
    (
        1,
        'content',
        'Simple Sentences',
        'This lesson will teach you how to form simple sentences in English, with clear examples to help you understand sentence structure. We will cover how to use basic components such as nouns, verbs, and adjectives in your sentences. You will also learn some of the most common sentence patterns and how to expand them for more variety, allowing you to express simple ideas confidently in English.',
        '',
        5
    ),
    (
        2,
        'video',
        'Intermediate Grammar Video',
        'This video lesson dives into intermediate grammar concepts like past perfect tense, conditionals, and indirect speech. You will learn how to use these grammatical structures in everyday situations, focusing on their applications in both writing and speaking. The lesson includes interactive examples and practical exercises to help reinforce these rules and enhance your ability to use them in real-life conversations.',
        '_neP6775wCY?si=uK0q15aYVrUBiyK7',
        1
    ),
    (
        2,
        'content',
        'Grammar and Usage',
        'In this lesson, you will explore intermediate-level grammar concepts such as conditionals, relative clauses, and modal verbs. These structures are essential for expressing complex thoughts and ideas in English. You will learn how to integrate these grammar points into your speech and writing to communicate more naturally. Exercises will help you practice their use and improve fluency in real-world situations.',
        '',
        3
    ),
    (
        2,
        'video',
        'Idioms and Expressions',
        'Discover the world of idioms and expressions in this video lesson. Learn the meanings behind common idioms used in everyday conversations, such as "break the ice" and "get cold feet." We will also explore cultural context and how idioms are used by native speakers. You’ll have the chance to practice these idiomatic expressions in your own sentences and understand their significance in informal conversations.',
        '_neP6775wCY?si=uK0q15aYVrUBiyK7',
        2
    ),
    (
        2,
        'content',
        'Phrasal Verbs',
        'Phrasal verbs are an essential part of conversational English. This lesson will teach you the meanings and usage of common phrasal verbs. You will see examples of these verbs used in different contexts and practice identifying their literal and idiomatic meanings. We will also focus on using phrasal verbs naturally during conversations, improving your spoken English and fluency.',
        '',
        4
    ),
    (
        2,
        'content',
        'Listening Practice',
        'Enhance your listening skills with intermediate-level dialogues. This lesson includes various audio and video exercises designed to improve your ability to understand different accents and speaking speeds. Focus on picking out key words, main ideas, and supporting details. As you practice, you’ll gain strategies to comprehend complex sentences and follow along more effectively during conversations or presentations.',
        '',
        5
    ),
    (
        3,
        'content',
        'Complex Sentence Structures',
        'This lesson focuses on constructing and using complex and compound-complex sentences in both written and spoken English. You’ll learn how to use conjunctions, relative clauses, and other advanced sentence elements to express more sophisticated ideas. Exercises will help you practice these structures and build your ability to communicate effectively in professional, academic, and personal settings.',
        '',
        3
    ),
    (
        3,
        'video',
        'Advanced Grammar and Vocabulary',
        'Master advanced grammar topics and professional vocabulary in this lesson. We’ll cover complex structures like advanced tenses, inversion, and subjunctive mood. Additionally, we will explore high-level vocabulary used in academic and professional contexts. With interactive examples, you’ll learn how to avoid common mistakes and develop confidence in using advanced grammar and vocabulary in your writing and speaking.',
        '_neP6775wCY?si=uK0q15aYVrUBiyK7',
        1
    ),
    (
        3,
        'content',
        'Formal Writing',
        'In this lesson, you’ll learn the principles of formal writing, such as structuring essays, reports, and professional emails. You will understand how to organize ideas logically, use formal vocabulary, and avoid colloquial expressions. Through examples of academic and business writing, you will gain insight into effective communication in professional settings. This lesson will enhance your ability to produce clear and polished written content for formal situations.',
        '',
        4
    ),
    (
        3,
        'video',
        'Professional Writing Tips',
        'Learn valuable techniques for writing professional and effective documents such as reports, proposals, and business emails. This video lesson will guide you through the process of crafting compelling content, organizing ideas logically, and ensuring error-free writing. You will see real-world examples and gain the confidence to write clearly and persuasively in a professional context.',
        '_neP6775wCY?si=uK0q15aYVrUBiyK7',
        2
    ),
    (
        3,
        'content',
        'Advanced Vocabulary',
        'Expand your English vocabulary with more sophisticated words and their proper usage in various contexts. This lesson will teach you advanced vocabulary for formal and academic writing as well as for everyday conversations. You’ll learn how to substitute common words with more refined alternatives and understand the nuances of similar words. By using these advanced words in speaking and writing exercises, you’ll demonstrate your expertise in the language.',
        '',
        5
    );

INSERT INTO
    test (lesson_id, question)
VALUES
    (1, 'What is the capital of France?'),
    (
        1,
        'Which of the following is a renewable energy source?'
    ),
    (2, 'Which of these animals is a mammal?'),
    (3, 'What is the primary function of the heart?');

INSERT INTO
    test_options (test_id, option_text, is_correct)
VALUES
    (1, 'Paris', TRUE),
    (1, 'London', FALSE),
    (1, 'Berlin', FALSE),
    (2, 'Solar Energy', TRUE),
    (2, 'Coal', FALSE),
    (2, 'Oil', FALSE),
    (3, 'Dog', TRUE),
    (3, 'Eagle', FALSE),
    (3, 'Shark', FALSE),
    (4, 'Pumping blood', TRUE),
    (4, 'Digesting food', FALSE),
    (4, 'Producing oxygen', FALSE);

INSERT INTO
    tru_false (lesson_id, statement, is_true)
VALUES
    (1, 'The Earth revolves around the Sun.', TRUE),
    (1, 'The Earth revolves around the Sun.', TRUE),
    (2, 'All squares are rectangles.', TRUE),
    (3, 'Water boils at 50°C at sea level.', FALSE);

INSERT INTO
    dropdown (lesson_id, question, correct_answer)
VALUES
    (
        1,
        'Select the correct preposition: "I am going ___ the store." ',
        'to'
    ),
    (
        1,
        'Choose the correct option: "The cat is ___ the table."',
        'under'
    );

INSERT INTO
    fill_in_the_blank (lesson_id, sentence, correct_answer)
VALUES
    (
        1,
        'The quick brown ___ jumps over the lazy dog.',
        'fox'
    ),
    (1, '___ is the capital city of Japan.', 'Tokyo');

INSERT INTO
    matching (lesson_id, left_side, right_side)
VALUES
    (1, 'Apple', 'Fruit'),
    (1, 'Carrot', 'Vegetable'),
    (1, 'Dog', 'Animal'),
    (2, 'Python', 'Programming Language'),
    (3, 'HTML', 'Markup Language');