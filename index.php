<?php
include "config/db.php";
$task_list = $db->query("SELECT * FROM `tasks` ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
</head>

<body>

    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
        <h5 class="my-0 mr-md-auto font-weight-normal">To Do List / Akhmetkarimov Yedil</h5>
        <nav class="my-2 my-md-0 mr-md-3">
            <a class="p-2 text-dark" href="mailto: akhmetkarimov.yedil@gmail.com">Gmail</a>
            <a class="p-2 text-dark" href="https://t.me/akhmetkarimov_yedil">Telegram</a>
        </nav>
        <?php
        if (isset($_COOKIE["user"]) && strlen($_COOKIE["user"]) > 0) {
        ?>
            <a href="api/auth/signout.php" class="btn btn-outline-primary">Sign Out</a>
        <?php } else { ?>
            <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#signinModal">Sign in</button>

            <div class="modal fade" id="signinModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered " role="document">
                    <div class="modal-content">
                        <div class="modal-header border-bottom-0">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body pb-md-5">
                            <div class="form-title text-center">
                                <h4>Sign In</h4>
                            </div>
                            <div class="d-flex flex-column text-center">
                                <form action="api/auth/signin.php" method="POST">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Your username..." name="user_name">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" placeholder="Your password..." name="user_password">
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-block btn-round">Sign in</button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h1 class="display-4">To Do List</h1>
        <p class="lead">This site is specially created for BeeJee</p>
    </div>

    <div class="container pb-md-4">
        <form action="api/todo/post.php" method="POST">
            <div class="form-group">
                <label for="task_title">Task Title</label>
                <input type="text" class="form-control" id="task_title" name="task_title">
            </div>

            <div class="form-group">
                <label for="task_description">Task Description</label>
                <textarea class="form-control" id="task_description" rows="3" name="task_description"></textarea>
            </div>

            <div class="form-group">
                <label for="user_email">Your Email</label>
                <input type="email" class="form-control" id="user_email" name="user_email" aria-describedby="emailHelp">
            </div>

            <div class="form-group">
                <label for="user_name">Your Name</label>
                <input type="text" class="form-control" id="user_name" name="user_name">
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>


    <div class="container pt-md-5">

        <table id="to_do_table" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>Task title</th>
                    <th>Task Description</th>
                    <th>User Email</th>
                    <th>User Name</th>
                    <th>Status</th>
                    <?php
                    if (isset($_COOKIE["user"]) && strlen($_COOKIE["user"]) > 0) {
                    ?>
                        <th>Action</th>
                    <?php
                    } ?>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($task_list->num_rows > 0) {
                    while ($task = $task_list->fetch_object()) {
                        $content =
                            '<tr>
                            <td>' . $task->title . '</td>
                            <td>' . $task->description . '</td>
                            <td>' . $task->user_email . '</td>
                            <td>' . $task->user_name . '</td>';

                        if ($task->done == 0) {
                            $content .= '<td><i class="far fa-times-circle" style="color: red;"></i><span style="opacity:0">' . $task->done . '</span></td>';
                        } else {
                            $content .= '<td><i class="far fa-check-circle" style="color: lightgreen;"></i><span style="opacity:0">' . $task->done . '</span></td>';
                        }

                        if (isset($_COOKIE["user"]) && strlen($_COOKIE["user"]) > 0) {
                            $content .= '<td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" onclick="sendEditInfo('.$task->id.')">Edit</button></td>';
                        }
                        echo $content . '</tr>';
                    }
                }
                ?>
            </tbody>
        </table>

        <footer class="pt-4 my-md-5 pt-md-5 border-top center">
            <small class="d-block mb-3 text-muted text-center">© Akhmetkarimov Yedil 2020</small>
        </footer>
    </div>



    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="edit_form" action="api/todo/update.php" method="POST">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Edit task title" name="edit_title" id="edit_title">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Edit task description" name="edit_description" id="edit_description">
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" placeholder="Edit task user email" name="edit_email" id="edit_email">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Edit task user name" name="edit_name" id="edit_name">
                        </div>
                        <div class="form-group">
                            Status <input type="checkbox" name ="edit_status" id="edit_status">
                        </div>
                        <input type="hidden" name ="edit_id" id="edit_id">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit"  form="edit_form" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="js/scripts.js"></script>


</body>
</html>