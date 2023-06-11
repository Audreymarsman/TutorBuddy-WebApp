<?php

//error_reporting(E_ALL);
//ini_set('display_errors', 1);
require $_SERVER["DOCUMENT_ROOT"] . "/Include/Database.php";
$sql = new mysqli($server, $username, $password, $database);
if ($sql->connect_error) {
    http_response_code(500);
    die("Couldn't Connect To Database");
}
$userID = filter_input(INPUT_POST, "id");

if ($id == null) {
    http_response_code(400);
    die("UserID cannot be blank");
}

$pstmt = $sql->prepare("Update Users set UserType=2 where ID=?");
$pstmt->bind_param("s", $id);
$result = $pstmt->execute();
if (!$result) {
    http_response_code(500);
    die("Unable to update user: " . mysqli_error($sql));
}
http_response_code(200);
$sql->close();
