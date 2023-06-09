<?php
$classID = filter_input(INPUT_POST, "classID");
if ($classID == null) {
    http_response_code(400);
    die("classID must be specified");
}
if(sizeof($_FILES)==0){
    http_response_code(400);
    die("A file was not sent");
}
$uploadDir = $_SERVER["DOCUMENT_ROOT"] . "/Assignments/$classID";
mkdir($uploadDir);
if (move_uploaded_file($_FILES["file"]["tmp_name"], $uploadDir . "/" . $_FILES["file"]["name"])) {
    echo "Success";
} else {
    http_response_code(500);
    echo "Couldn't upload file";
}
