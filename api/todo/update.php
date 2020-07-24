<?php
include "../../config/db.php";
include "../../config/config.php";

if (
    isset($_POST["edit_title"]) && isset($_POST["edit_description"]) &&
    isset($_POST["edit_name"]) && isset($_POST["edit_email"]) &&
    strlen($_POST["edit_title"]) > 0 && strlen($_POST["edit_description"]) > 0 &&
    strlen($_POST["edit_title"]) > 0 && strlen($_POST["edit_email"]) > 0
) {
    $id = $_POST['edit_id'];
    $title = $_POST["edit_title"];
    $description = $_POST["edit_description"];
    $user_name = $_POST["edit_name"];
    $user_email = $_POST["edit_email"];
    $done = $_POST["edit_status"];

    if(empty($done))
        $done = 0;

    $db->query("UPDATE `tasks` SET `title` = '$title', `description` = '$description', `user_email` = '$user_email', `user_name` = '$user_name', `done` = '$done' WHERE `id` = $id");
    header("Location:$base_url/index.php");

} else {
    header("Location:$base_url/index.php?error=NOTALLDATA");
}
