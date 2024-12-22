<?php

include 'config.php';
$query = new Database();
$items = $query->select('lesson_items', '*', 'lesson_id = 4');

echo '<p style="white-space: pre-wrap;">' . $items[0]['description'] . '</p>';
