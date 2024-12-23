<?php include 'auth.php'?>
<?

$topics = $query->select('lessons', '*');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['insert'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];

    $insert = $query->insert('lessons', [
        'title' => $title,
        'description' => $description
    ]);

    if ($insert) {
        header("Location: ./topics.php");
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $id = $_POST['id'];
    $delete = $query->delete('lessons', "id = $id");

    if ($delete) {
        header("Location: ./topics.php");
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'] ?? null;
    $title = $_POST['title'] ?? null;
    $description = $_POST['description'] ?? null;

    $update = $query->update('lessons', [
        'title' => $title,
        'description' => $description
    ], "id = $id");

    if ($update) {
        header("Location: ./topics.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="../favicon.ico">
    <title>AdminLTE 3 | Topics</title>
    <?php include 'includes/css.php'; ?>
</head>
<style>
    .btn-primary {
        width: 100%;
    }
</style>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php include 'includes/navbar.php' ?>
        <div class="content-wrapper">

            <?php
            $arr = array(
                ["title" => "Home", "url" => "./"],
                ["title" => "Topics", "url" => "#"],
            );
            pagePath('Topics', $arr);
            ?>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h3 class="card-title">Insert New Topic</h3>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="topics.php">
                                        <div class="mb-3">
                                            <label for="title" class="form-label">Title</label>
                                            <input type="text" class="form-control" id="title" name="title" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="description" class="form-label">Description</label>
                                            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                                        </div>
                                        <button type="submit" name="insert" class="btn btn-primary">Add Topic</button>
                                    </form>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Topics List</h3>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>№</th>
                                                <th>Title</th>
                                                <th>Description</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($topics) {
                                                $count = 1;
                                                foreach ($topics as $topic) {
                                                    echo "<tr>";
                                                    echo "<td>{$count}</td>";
                                                    echo "<td>{$topic['title']}</td>";
                                                    echo "<td>{$topic['description']}</td>";
                                                    echo "<td>
                                                            <button class='btn btn-warning btn-sm' 
                                                                    data-bs-toggle='modal' 
                                                                    data-bs-target='#updateModal' 
                                                                    data-id='{$topic['id']}' 
                                                                    data-title='{$topic['title']}' 
                                                                    data-description='{$topic['description']}'>
                                                                Update
                                                            </button>
                                                            <form method='POST' action='topics.php' class='d-inline'>
                                                                <input type='hidden' name='id' value='{$topic['id']}'>
                                                                <button type='submit' name='delete' class='btn btn-danger btn-sm'>Delete</button>
                                                            </form>
                                                        </td>";
                                                    echo "</tr>";
                                                    $count++;
                                                }
                                            } else {
                                                echo "<tr><td colspan='4'>No topics found.</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <?php include 'includes/footer.php'; ?>
    </div>

    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="topics.php">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel">Update Topic</h5>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="topicId">
                        <div class="mb-3">
                            <label for="topicTitle" class="form-label">Title</label>
                            <input type="text" class="form-control" id="topicTitle" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="topicDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="topicDescription" name="description" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php include 'includes/js.php' ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const updateModal = document.getElementById('updateModal');
        updateModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const title = button.getAttribute('data-title');
            const description = button.getAttribute('data-description');

            const modalIdInput = document.getElementById('topicId');
            const modalTitleInput = document.getElementById('topicTitle');
            const modalDescriptionInput = document.getElementById('topicDescription');

            modalIdInput.value = id;
            modalTitleInput.value = title;
            modalDescriptionInput.value = description;
        });
    </script>
</body>

</html>