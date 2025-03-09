<?php include 'auth.php'?>
<?

$user_id = $_SESSION['user_id'];
$result = $query->select('users', '*', "id = $user_id");

$user = $result[0];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $_SESSION['first_name'] = $first_name;
    $_SESSION['last_name'] = $last_name;

    if (!empty($password)) {
        $password = $query->hashPassword($password);
        $query->update('users', [
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'username' => $username,
            'password' => $password
        ], "id = $user_id");
    } else {
        $query->update('users', [
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'username' => $username
        ], "id = $user_id");
    }

    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="../favicon.ico">
    <title>AdminLTE 3 | User settings</title>
    <?php include 'includes/css.php'; ?>
</head>
<style>
    body {
        background-color: #f4f6f9;
    }

    .form-container {
        max-width: 600px;
        margin: 50px auto;
        background: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .form-container h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #333;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        width: 100%;
        font-size: 18px;
        padding: 10px;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #004085;
    }

    .form-text {
        font-size: 0.875rem;
        color: #6c757d;
    }
</style>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php include 'includes/navbar.php' ?>
        <div class="content-wrapper">

            <?php
            $arr = array(
                ["title" => "Home", "url" => "./"],
                ["title" => "User settings", "url" => "#"],
            );
            pagePath('User settings', $arr);
            ?>

            <section class="content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="container">
                            <div class="form-container">
                                <h2>User Settings</h2>
                                <form action="" method="POST">
                                    <div class="mb-3">
                                        <label for="first_name" class="form-label">First Name</label>
                                        <input type="text" class="form-control" id="first_name" name="first_name" value="<?= htmlspecialchars($user['first_name']) ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="last_name" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" id="last_name" name="last_name" value="<?= htmlspecialchars($user['last_name']) ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="username" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter new password">
                                        <small class="form-text">Leave blank to keep the current password.</small>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </form>
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