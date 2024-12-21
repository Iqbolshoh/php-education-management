<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ./login/");
    exit;
}

include './config.php';
$query = new Database();

$lesson_id = isset($_GET['lesson_id']) ? intval($_GET['lesson_id']) : 0;

if ($lesson_id > 0) {
    $results = $query->select('results', '*', "lesson_id = $lesson_id");
} else {
    $lessons = $query->select('lessons', '*', '1');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="../favicon.ico">
    <title>Results</title>
    <?php include 'includes/css.php'; ?>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php include 'includes/navbar.php'; ?>
        <div class="content-wrapper">

            <?php
            $arr = array(
                ["title" => "Home", "url" => "./"],
                ["title" => "Results", "url" => "#"],
            );
            pagePath('Results', $arr);
            ?>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Lessons</h3>
                                </div>
                                <div class="card-body">
                                    <?php if (isset($lessons)): ?>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>№</th>
                                                    <th>Lesson Name</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($lessons as $key => $lesson): ?>
                                                    <tr>
                                                        <td><?= $key + 1 ?></td>
                                                        <td>
                                                            <?= $lesson['title'] ?>
                                                        </td>
                                                        <td>
                                                            <a href="?lesson_id=<?= $lesson['id'] ?>" class="btn btn-primary btn-sm">View Results</a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    <?php elseif (isset($results)): ?>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>№</th>
                                                    <th>Participant Name</th>
                                                    <th>Total Questions</th>
                                                    <th>Answered Questions</th>
                                                    <th>Percentage</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($results as $key => $result): ?>
                                                    <tr>
                                                        <td><?= $key + 1 ?></td>
                                                        <td><?= htmlspecialchars($result['participant_name']) ?></td>
                                                        <td><?= $result['total_questions'] ?></td>
                                                        <td><?= $result['answered_questions'] ?></td>
                                                        <td>
                                                            <?php
                                                            if ($result['answered_questions'] == 0) {
                                                                echo "0%";
                                                            } else {
                                                                $percentage = ($result['answered_questions'] / $result['total_questions']) * 100;
                                                                echo $percentage . "%";
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>

                                            </tbody>
                                        </table>
                                        <br>
                                        <a href="results.php" class="btn btn-secondary" style="width: 100%;">Back to Lessons</a>
                                    <?php else: ?>
                                        <p class="text-center">No data available.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <?php include 'includes/footer.php'; ?>
    </div>

    <?php include 'includes/js.php'; ?>
</body>

</html>