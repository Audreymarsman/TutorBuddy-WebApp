<?php

$userID = filter_input(INPUT_POST, "userID");
if ($userID == null) {
    http_response_code(400);
    die("userID must be specified");
}
if (sizeof($_FILES) == 0) {
    http_response_code(400);
    die("A file was not sent");
}
$uploadDir = $_SERVER["DOCUMENT_ROOT"] . "/Images/Users/";
mkdir($uploadDir);
if (file_exists($uploadDir . "/$userID.jpg")) {
    unlink($uploadDir . "/$userID.jpg");
}
if (move_uploaded_file($_FILES["file"]["tmp_name"], $uploadDir . "/$userID.jpg")) {
    echo "Success";
} else {
    http_response_code(500);
    echo "Couldn't upload file";
}
