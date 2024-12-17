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

-- Lessons jadvali
INSERT INTO
    lessons (id, title, description)
VALUES
    (1, 'Beginner English', 'Basic English lessons for beginners.'),
    (2, 'Intermediate English', 'Intermediate-level English to enhance your skills.'),
    (3, 'Advanced English', 'Advanced-level English for fluency and precision.'),
    (4, 'Business English', 'Professional English for the workplace.'),
    (5, 'English for Travel', 'Essential English for traveling.'),
    (6, 'English for Exams', 'Preparation for English language exams.'),
    (7, 'Daily Conversations', 'Learn English for everyday interactions.');

INSERT INTO
    lesson_items (lesson_id, type, title, description, link, position)
VALUES
    -- Beginner English
    (1, 'content', 'Basic Greetings', 'Learn how to greet people and introduce yourself in English. Understand various greetings used in different contexts such as formal, informal, and casual settings. This lesson will introduce common phrases like "How are you?" and "Nice to meet you." You will also explore cultural nuances and appropriate responses, helping you feel confident when initiating conversations in English-speaking environments.', 'N/A', 3),
    (1, 'video', 'Introduction to English Alphabet', 'This lesson covers the English alphabet, helping you recognize each letter, understand its pronunciation, and discover common words that begin with each letter. You will also see demonstrations of how each letter is articulated in various words. This foundational lesson will strengthen your reading and writing skills and help you improve letter recognition for both uppercase and lowercase characters.', 'https://www.youtube.com/embed/abc101', 1),
    (1, 'content', 'Common Verbs', 'This lesson focuses on frequently used verbs in English, their basic forms, and how to incorporate them into different sentence structures. You will learn the most common verbs and practice using them in affirmative, negative, and interrogative sentences. The goal is to help you use verbs naturally in your conversations, and we will provide tips for memorizing them to boost your confidence.', 'N/A', 4),
    (1, 'video', 'Basic Pronunciation Tips', 'Improve your pronunciation with clear examples and tips on how to pronounce common words in English. We’ll focus on identifying frequent pronunciation mistakes and strategies to avoid them. This lesson highlights the importance of stress and intonation in spoken English, teaching you how to sound more natural when speaking. You will also practice mimicking native speakers to develop better fluency and clarity in your pronunciation.', 'https://www.youtube.com/embed/abc102', 2),
    (1, 'content', 'Simple Sentences', 'This lesson will teach you how to form simple sentences in English, with clear examples to help you understand sentence structure. We will cover how to use basic components such as nouns, verbs, and adjectives in your sentences. You will also learn some of the most common sentence patterns and how to expand them for more variety, allowing you to express simple ideas confidently in English.', 'N/A', 5),

    -- Intermediate English
    (2, 'video', 'Intermediate Grammar Video', 'This video lesson dives into intermediate grammar concepts like past perfect tense, conditionals, and indirect speech. You will learn how to use these grammatical structures in everyday situations, focusing on their applications in both writing and speaking. The lesson includes interactive examples and practical exercises to help reinforce these rules and enhance your ability to use them in real-life conversations.', 'https://www.youtube.com/embed/abc123', 1),
    (2, 'content', 'Grammar and Usage', 'In this lesson, you will explore intermediate-level grammar concepts such as conditionals, relative clauses, and modal verbs. These structures are essential for expressing complex thoughts and ideas in English. You will learn how to integrate these grammar points into your speech and writing to communicate more naturally. Exercises will help you practice their use and improve fluency in real-world situations.', 'N/A', 3),
    (2, 'video', 'Idioms and Expressions', 'Discover the world of idioms and expressions in this video lesson. Learn the meanings behind common idioms used in everyday conversations, such as "break the ice" and "get cold feet." We will also explore cultural context and how idioms are used by native speakers. You’ll have the chance to practice these idiomatic expressions in your own sentences and understand their significance in informal conversations.', 'https://www.youtube.com/embed/abc124', 2),
    (2, 'content', 'Phrasal Verbs', 'Phrasal verbs are an essential part of conversational English. This lesson will teach you the meanings and usage of common phrasal verbs. You will see examples of these verbs used in different contexts and practice identifying their literal and idiomatic meanings. We will also focus on using phrasal verbs naturally during conversations, improving your spoken English and fluency.', 'N/A', 4),
    (2, 'content', 'Listening Practice', 'Enhance your listening skills with intermediate-level dialogues. This lesson includes various audio and video exercises designed to improve your ability to understand different accents and speaking speeds. Focus on picking out key words, main ideas, and supporting details. As you practice, you’ll gain strategies to comprehend complex sentences and follow along more effectively during conversations or presentations.', 'N/A', 5),

    -- Advanced English
    (3, 'content', 'Complex Sentence Structures', 'This lesson focuses on constructing and using complex and compound-complex sentences in both written and spoken English. You’ll learn how to use conjunctions, relative clauses, and other advanced sentence elements to express more sophisticated ideas. Exercises will help you practice these structures and build your ability to communicate effectively in professional, academic, and personal settings.', 'N/A', 3),
    (3, 'video', 'Advanced Grammar and Vocabulary', 'Master advanced grammar topics and professional vocabulary in this lesson. We’ll cover complex structures like advanced tenses, inversion, and subjunctive mood. Additionally, we will explore high-level vocabulary used in academic and professional contexts. With interactive examples, you’ll learn how to avoid common mistakes and develop confidence in using advanced grammar and vocabulary in your writing and speaking.', 'https://www.youtube.com/embed/def456', 1),
    (3, 'content', 'Formal Writing', 'In this lesson, you’ll learn the principles of formal writing, such as structuring essays, reports, and professional emails. You will understand how to organize ideas logically, use formal vocabulary, and avoid colloquial expressions. Through examples of academic and business writing, you will gain insight into effective communication in professional settings. This lesson will enhance your ability to produce clear and polished written content for formal situations.', 'N/A', 4),
    (3, 'video', 'Professional Writing Tips', 'Learn valuable techniques for writing professional and effective documents such as reports, proposals, and business emails. This video lesson will guide you through the process of crafting compelling content, organizing ideas logically, and ensuring error-free writing. You will see real-world examples and gain the confidence to write clearly and persuasively in a professional context.', 'https://www.youtube.com/embed/def457', 2),
    (3, 'content', 'Advanced Vocabulary', 'Expand your English vocabulary with more sophisticated words and their proper usage in various contexts. This lesson will teach you advanced vocabulary for formal and academic writing as well as for everyday conversations. You’ll learn how to substitute common words with more refined alternatives and understand the nuances of similar words. By using these advanced words in speaking and writing exercises, you’ll demonstrate your expertise in the language.', 'N/A', 5),

-- Business English
    (4, 'content', 'Business Introductions', 'Learn how to introduce yourself in a professional setting. This lesson will cover appropriate greetings, explaining your role, and the vocabulary used in business introductions. You will practice introducing yourself, colleagues, and clients, making you feel more comfortable in business meetings and networking situations.', 'N/A', 1),
    (4, 'video', 'Professional Email Writing', 'In this lesson, you will learn how to write clear and professional emails. We will cover appropriate email formats, common phrases, and etiquette in business correspondence. You will also practice writing emails for different purposes, such as inquiries, complaints, and business proposals.', 'https://www.youtube.com/embed/def458', 2),
    (4, 'content', 'Negotiation Skills', 'This lesson focuses on vocabulary and phrases commonly used in business negotiations. You will learn how to negotiate effectively, make requests, and offer solutions in a business context. Through role-playing exercises, you will practice applying these skills to real-world scenarios.', 'N/A', 3),
    (4, 'video', 'Business Presentations', 'Master the art of business presentations in English. In this video lesson, you will learn how to structure and deliver clear, engaging presentations. We’ll cover key phrases for presenting, handling questions, and creating effective visuals to support your ideas.', 'https://www.youtube.com/embed/def459', 4),
    (4, 'content', 'Business Meetings', 'Prepare for business meetings with useful vocabulary and phrases for setting agendas, discussing topics, and taking minutes. This lesson will help you understand meeting protocols and express yourself clearly in formal discussions, both in-person and online.', 'N/A', 5),

-- English for Travel
    (5, 'content', 'Airport Vocabulary', 'Learn essential vocabulary and phrases used at airports, such as checking in, security procedures, and navigating terminals. This lesson will give you the confidence to interact with airline staff and handle common travel situations.', 'N/A', 1),
    (5, 'video', 'Booking a Hotel', 'In this lesson, you will learn how to make hotel reservations, ask about amenities, and check-in or check-out in English. You’ll also practice typical dialogues you might encounter during your stay.', 'https://www.youtube.com/embed/ghi123', 2),
    (5, 'content', 'Ordering Food and Drinks', 'Understand the vocabulary and phrases used when ordering food and drinks at restaurants or cafes. This lesson includes common food items, meal-related etiquette, and tips for making special requests when dining out.', 'N/A', 3),
    (5, 'video', 'Asking for Directions', 'Learn how to ask for and understand directions in English. This video will cover phrases for asking about locations, transportation, and common tourist destinations. Practice dialogues will help you feel confident when navigating unfamiliar places.', 'https://www.youtube.com/embed/ghi124', 4),
    (5, 'content', 'Emergency Situations', 'Prepare for travel emergencies by learning how to communicate in critical situations, such as losing your passport, calling for help, or reporting an accident. You will learn the necessary vocabulary and key phrases for getting assistance in urgent situations.', 'N/A', 5),

-- English for Exams
    (6, 'video', 'IELTS Listening Strategies', 'Learn effective strategies for the listening section of the IELTS exam. This video will introduce different question types and provide tips for listening comprehension, such as identifying key information and managing time during the test.', 'https://www.youtube.com/embed/jkl101', 1),
    (6, 'content', 'IELTS Speaking Practice', 'This lesson provides exercises for the speaking section of the IELTS exam. You will practice answering questions, expressing opinions, and discussing topics related to current events, hobbies, and education. You’ll receive tips for improving fluency and coherence in your answers.', 'N/A', 2),
    (6, 'content', 'TOEFL Reading Skills', 'Enhance your reading skills for the TOEFL exam by learning strategies for skimming, scanning, and understanding academic texts. You will practice identifying the main idea, supporting details, and answering typical TOEFL reading comprehension questions.', 'N/A', 3),
    (6, 'video', 'TOEFL Writing Tips', 'This video covers useful tips for improving your writing skills for the TOEFL exam. Learn how to structure essays, develop your arguments, and manage your time effectively. You will also see examples of strong and weak responses to help you understand what examiners are looking for.', 'https://www.youtube.com/embed/jkl102', 4),
    (6, 'content', 'Practice Mock Tests', 'Prepare for your English exams by taking practice mock tests. These practice tests will simulate the real exam environment, helping you become familiar with the test format and assess your readiness. You will also receive feedback and strategies for improving your performance.', 'N/A', 5),

-- Daily Conversations
    (7, 'content', 'Introducing Yourself in Daily Life', 'Learn how to introduce yourself in casual and everyday situations. This lesson will help you with common introductions, making small talk, and responding to typical greetings you encounter in informal settings.', 'N/A', 1),
    (7, 'video', 'Talking About Hobbies', 'In this lesson, you will learn how to talk about your hobbies and interests in English. We will cover vocabulary related to activities such as sports, reading, cooking, and travel. You will practice using expressions and questions to discuss your favorite pastimes.', 'https://www.youtube.com/embed/mno123', 2),
    (7, 'content', 'Asking for Help', 'This lesson will teach you how to ask for help in everyday situations, such as when you need assistance with directions, shopping, or making plans. We’ll focus on polite requests and common phrases used in daily life.', 'N/A', 3),
    (7, 'video', 'Talking About the Weather', 'Learn how to discuss the weather in casual conversations. This lesson covers common phrases and expressions related to weather, as well as how to make small talk using the weather as a topic.', 'https://www.youtube.com/embed/mno124', 4),
    (7, 'content', 'Making Plans with Friends', 'Understand how to make plans with friends, family, or colleagues in English. This lesson covers how to invite someone out, confirm plans, and make suggestions for activities in a natural and friendly way.', 'N/A', 5);

-- Savollar jadvali
INSERT INTO
    questions (lesson_id, sentence, correct_answer)
VALUES
    -- Beginner English
    (1, 'I ____ to the store yesterday.', 'went'),
    (1, 'She ____ a book right now.', 'is reading'),
    (1, 'They ____ to the park every weekend.', 'go'),
    (1, 'We ____ pizza for dinner last night.', 'had'),
    (1, 'I ____ a new phone tomorrow.', 'will buy'),

    -- Intermediate English
    (2, 'They ____ in the park when it started raining.', 'were playing'),
    (2, 'I ____ never been to Paris.', 'have'),
    (2, 'She ____ to the gym regularly.', 'goes'),
    (2, 'They ____ for the bus when I saw them.', 'were waiting'),
    (2, 'I ____ been working here for 5 years.', 'have'),

    -- Advanced English
    (3, 'By the time we arrived, they ____ the meeting.', 'had started'),
    (3, 'He ____ been studying all day.', 'has'),
    (3, 'We ____ already finished the project when the boss arrived.', 'had'),
    (3, 'I ____ going to the conference next week.', 'am'),
    (3, 'They ____ speaking about the new policy when we walked in.', 'were'),

    -- Business English
    (4, 'We need to ____ the presentation by Friday.', 'complete'),
    (4, 'The manager ____ a meeting with the client yesterday.', 'held'),
    (4, 'I ____ preparing the report for the meeting.', 'am'),
    (4, 'She ____ an email to the client right now.', 'is writing'),
    (4, 'The team ____ the project by next month.', 'will finish'),

    -- English for Travel
    (5, 'Where ____ the nearest airport?', 'is'),
    (5, 'I ____ to London next week.', 'am flying'),
    (5, 'We ____ a taxi to the hotel.', 'took'),
    (5, 'How ____ is it to the nearest restaurant?', 'far'),
    (5, 'I ____ my passport at the hotel.', 'left'),

    -- English for Exams
    (6, 'She ____ an excellent grade in the exam.', 'got'),
    (6, 'I ____ study for the test tomorrow.', 'must'),
    (6, 'They ____ the answers carefully during the exam.', 'checked'),
    (6, 'He ____ to the library to prepare for the exam.', 'went'),
    (6, 'We ____ finish all the questions on time.', 'need to'),

    -- Daily Conversations
    (7, 'I ____ like coffee with my breakfast.', 'usually'),
    (7, 'She ____ in the kitchen at the moment.', 'is cooking'),
    (7, 'We ____ to the movies tonight.', 'are going'),
    (7, 'I ____ never been to that restaurant.', 'have'),
    (7, 'They ____ a lot of fun at the party.', 'had');

-- Variantlar jadvali
INSERT INTO
    options (question_id, option_text)
VALUES
    -- Beginner English
    (1, 'go'), (1, 'went'), (1, 'going'), (1, 'gone'),
    (2, 'reads'), (2, 'read'), (2, 'is reading'), (2, 'was reading'),
    (3, 'are going'), (3, 'go'), (3, 'goes'), (3, 'gone'),
    (4, 'eats'), (4, 'had'), (4, 'have'), (4, 'has'),
    (5, 'will buy'), (5, 'buy'), (5, 'will buying'), (5, 'bought'),

    -- Intermediate English
    (6, 'were playing'), (6, 'are playing'), (6, 'played'), (6, 'playing'),
    (7, 'have'), (7, 'has'), (7, 'had'), (7, 'having'),
    (8, 'goes'), (8, 'went'), (8, 'is going'), (8, 'go'),
    (9, 'were waiting'), (9, 'waited'), (9, 'waiting'), (9, 'were waiting'),
    (10, 'have'), (10, 'had'), (10, 'have been'), (10, 'had been'),

    -- Advanced English
    (11, 'had started'), (11, 'started'), (11, 'has started'), (11, 'will start'),
    (12, 'has'), (12, 'had'), (12, 'have been'), (12, 'was'),
    (13, 'had'), (13, 'have'), (13, 'were'), (13, 'has'),
    (14, 'am'), (14, 'will'), (14, 'is'), (14, 'was'),
    (15, 'were'), (15, 'was'), (15, 'had been'), (15, 'is'),

    -- Business English
    (16, 'complete'), (16, 'completing'), (16, 'completed'), (16, 'completes'),
    (17, 'held'), (17, 'holds'), (17, 'holded'), (17, 'holding'),
    (18, 'am'), (18, 'is'), (18, 'was'), (18, 'are'),
    (19, 'is writing'), (19, 'writes'), (19, 'write'), (19, 'writing'),
    (20, 'will finish'), (20, 'finished'), (20, 'finish'), (20, 'will finished'),

    -- English for Travel
    (21, 'is'), (21, 'are'), (21, 'will'), (21, 'was'),
    (22, 'am flying'), (22, 'flies'), (22, 'will fly'), (22, 'fly'),
    (23, 'took'), (23, 'take'), (23, 'taking'), (23, 'taken'),
    (24, 'far'), (24, 'near'), (24, 'close'), (24, 'long'),
    (25, 'left'), (25, 'leaving'), (25, 'leave'), (25, 'leaves'),

    -- English for Exams
    (26, 'got'), (26, 'have got'), (26, 'had'), (26, 'gotten'),
    (27, 'must'), (27, 'should'), (27, 'will'), (27, 'can'),
    (28, 'checked'), (28, 'checking'), (28, 'check'), (28, 'checked'),
    (29, 'went'), (29, 'go'), (29, 'will go'), (29, 'gone'),
    (30, 'need to'), (30, 'need'), (30, 'must'), (30, 'need being'),

    -- Daily Conversations
    (31, 'usually'), (31, 'never'), (31, 'always'), (31, 'often'),
    (32, 'is cooking'), (32, 'cooking'), (32, 'cooked'), (32, 'cooks'),
    (33, 'are going'), (33, 'going'), (33, 'went'), (33, 'will go'),
    (34, 'have'), (34, 'never been'), (34, 'was'), (34, 'been'),
    (35, 'had'), (35, 'have had'), (35, 'having'), (35, 'was');

