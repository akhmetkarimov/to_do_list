<?php 
include"../../config/config.php";
setcookie("user", '', time() - 3600,'/');
header("Location: $base_url/index.php");
