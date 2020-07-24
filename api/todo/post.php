<?php
include "../../config/db.php";
include "../../config/config.php";

if (
    isset($_POST["task_title"]) && isset($_POST["task_description"]) &&
    isset($_POST["user_name"]) && isset($_POST["user_email"]) &&
    strlen($_POST["task_title"]) > 0 && strlen($_POST["task_description"]) > 0 &&
    strlen($_POST["user_name"]) > 0 && strlen($_POST["user_email"]) > 0
) {

    $title = $_POST["task_title"];
    $description = $_POST["task_description"];
    $user_name = $_POST["user_name"];
    $user_email = $_POST["user_email"];
    $db->query("INSERT INTO `tasks` (`title`, `description`, `user_name`, `user_email`) VALUES ('$title', '$description', '$user_name', '$user_email')");

    header("Location: $base_url/index.php");
} else {
    header("Location:$base_url/index.php?error=NOTALLDATA");
}
