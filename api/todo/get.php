<?php
include "../../config/db.php";
include "../../config/config.php";

if (isset($_GET["id"])) {

    $id = $_GET["id"];
    $query = $db->query("SELECT * FROM `tasks` WHERE id = $id");

    $edit_task = array();

    if ($query->num_rows > 0) {
        while ($elem = $query->fetch_object()) {
            $edit_task[] = array(
                "id" => $elem->id,
                "title" => $elem->title,
                "description" => $elem->description,
                "user_name" => $elem->user_name,
                "user_email" => $elem->user_email,
                "done" => $elem->done
            );
        }
    }
    $result = array(
        "result" => $edit_task,
    );

    echo json_encode($result, JSON_UNESCAPED_UNICODE);
}
