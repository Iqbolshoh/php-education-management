<?php include 'auth.php'?>
<?

$user = $query->select('users', '*')[0];
$topics = $query->select('lessons', '*')[0];
$results = $query->select('results', '*');

$tests = count($query->select('test', '*'));
$tru_falses = count($query->select('tru_false', '*'));
$dropdowns = count($query->select('dropdown', '*'));
$fill_in_the_blanks = count($query->select('fill_in_the_blank', '*'));
$matchings = count($query->select('matching', '*'));
$answers = count($query->select('answers', '*'));

$question = $tests + $tru_falses + $dropdowns + $fill_in_the_blanks + $matchings + $answers;

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/x-icon" href="../favicon.ico">
  <title>AdminLTE 3 | Dashboard</title>
  <?php include 'includes/css.php'; ?>
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <?php include 'includes/navbar.php' ?>
    <div class="content-wrapper">

      <?php
      $arr = array(
        ["title" => "Home", "url" => "./"],
        ["title" => "Dashboard", "url" => "#"],
      );
      pagePath('Dashboard', $arr);
      ?>

      <section class="content">
        <div class="container-fluid">

          <div class="row">
            <div class="col-lg-3 col-6">

              <div class="small-box bg-info">
                <div class="inner">
                  <h3><?= $user['first_name'] ?></h3>

                  <p><?= $user['email'] ?></p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="./user.php" class="small-box-footer">Edit User <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>

            <div class="col-lg-3 col-6">

              <div class="small-box bg-success">
                <div class="inner">
                  <h3><?= count($topics) . ' Topics' ?></sup></h3>

                  <p>Available in the system</p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
                <a href="./topics.php" class="small-box-footer">Add Topics <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>

            <div class="col-lg-3 col-6">
              <div class="small-box bg-warning">
                <div class="inner">
                  <h3><?= $question ?></h3>

                  <p>Total number of questions.</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="./test.php" class="small-box-footer">See questions <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>

            <div class="col-lg-3 col-6">

              <div class="small-box bg-danger">
                <div class="inner">
                  <h3><?= count($results) ?></h3>

                  <p>People passed the test.</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
                <a href="./results.php" class="small-box-footer">View result <i class="fas fa-arrow-circle-right"></i></a>
              </div>

            </div>
          </div>

        </div>

      </section>
    </div>

    <?php include 'includes/footer.php'; ?>
  </div>

  <?php include 'includes/js.php' ?>
</body>

</html>