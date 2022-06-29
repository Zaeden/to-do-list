<?php
$update = false;
$delete = false;

$insert = false;
include "./partials/_dbconnect.php";

if (isset($_GET['delete'])) {
    $sno = $_GET['delete'];
    $delete = true;
    $sql = "DELETE FROM `notes` WHERE `sno` = '$sno'";
    $result = mysqli_query($conn, $sql);
}
// exit();
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['snoEdit'])) {
        //Update the record.
        $sno = $_POST["snoEdit"];
        $title = $_POST["titleEdit"];
        $description = $_POST["descriptionEdit"];

        $query = "UPDATE `notes` SET `title` = '$title', `description` = '$description' WHERE `notes`.`sno` = '$sno'";

        $result =  mysqli_query($conn, $query);

        if ($result) {
            $update = true;
        }
    } else {

        $title = $_POST["title"];
        $description = $_POST["description"];

        $query = "INSERT INTO `notes` (`title`, `description`, `date`) VALUES ('$title', '$description', current_timestamp())";

        $result = mysqli_query($conn, $query);
        if ($result) {
            $insert = true;
        }
    }
}


?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>To Do List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>


</head>

<body>




    <!-- Edit Modal -->
    <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
        Edit Modal -->
    </button>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/to-do-list/index.php" method="post">
                        <input type="hidden" name="snoEdit" id="snoEdit">
                        <div class="mb-3">
                            <label for="title" class="form-label">Edit Title</label>
                            <input type="text" name="titleEdit" class="form-control" id="titleEdit" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Edit Description</label>
                            <textarea name="descriptionEdit" class="form-control" id="descriptionEdit" rows="3"></textarea>
                        </div>
                        <!-- <button type="submit" class="btn btn-primary">Update Note</button> -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update Task</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">To Do List</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Contact</a>
                    </li>


                </ul>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <?php
    if ($delete) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Task has been deleted!</strong> You can check the remaining tasks below.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }
    ?>
    <?php
    if ($update) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Task has been updated!</strong> You can check the tasks below.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }
    ?>

    <?php
    if ($insert) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Task has been added!</strong> You can check the tasks below.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }


    ?>

    <!-- HTML for form input -->

    <div class="container my-5">
        <h2>Add a Task</h2>
        <form action="/to-do-list/index.php?update=true" method="post">
            <div class="mb-3">
                <label for="title" class="form-label">Task Title</label>
                <input type="text" name="title" class="form-control" id="title" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Task Description</label>
                <textarea name="description" class="form-control" id="description" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Note</button>
        </form>
    </div>




    <!-- Container for showing the tasks -->

    <div class="container my-4">
        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th scope="col">S. No.</th>
                    <th scope="col">Task Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <?php
            $query = "SELECT * from notes";
            $result = mysqli_query($conn, $query);
            $sno = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tbody>
                        <tr>
                            <th scope="row">' . $sno . '</th>
                            <td>' . $row["title"] . '</td>
                            <td>' . $row["description"] . '</td>
                            <td><button class="btn btn-sm btn-primary mx-3 edit" id="' . $row["sno"] . '">Edit</button><button class="btn btn-sm btn-danger delete" id="d' . $row["sno"] . '">Delete</button>
                            </td>
                        </tr>';
                $sno++;
            }
            ?>
            </tbody>
        </table>
    </div>
    <hr>


    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>

    <script>
        let edits = document.getElementsByClassName("edit");
        Array.from(edits).forEach((element) => {
            element.addEventListener("click", (e) => {
                console.log("edit");
                let tr = e.target.parentNode.parentNode;
                let title = tr.getElementsByTagName("td")[0].innerText;
                let description = tr.getElementsByTagName("td")[1].innerText;
                console.log(title, description);
                titleEdit.value = title;
                descriptionEdit.value = description;
                snoEdit.value = e.target.id;
                console.log(e.target.id);
                $("#editModal").modal("toggle");

            })
        })

        let deletes = document.getElementsByClassName("delete");
        Array.from(deletes).forEach((element) => {
            element.addEventListener("click", (e) => {
                console.log("edit");
                sno = e.target.id.substr(1, );

                if (confirm("Press a button!")) {
                    console.log("Yes");
                    window.location = `/to-do-list/index.php?delete=${sno}`;
                } else {
                    console.log("No");
                }

            })
        })
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>