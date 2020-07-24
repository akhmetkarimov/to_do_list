<?php

include "../../config/db.php";
include "../../config/config.php";

if (isset($_POST["user_name"]) && isset($_POST["user_password"])) {

    $uName = $_POST["user_name"];
    $uPassword = $_POST["user_password"];

    $exist = $db->query("SELECT * FROM users WHERE user_name = '$uName'");

    if ($exist->num_rows > 0) {
        $current_user = $exist->fetch_object();

        $cookie_name = "user";
        $cookie_value = $current_user->id;
        setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 1 day

        header("Location: $base_url/index.php");
    } else {
        header("Location: $base_url/index.php?error=NOT_FOUND");
    }
} else {
    header("Location: $base_url/index.php?error=NOT_ALL_DATA");
}
