<?php

//error_reporting(E_ALL);
//ini_set('display_errors', 1);
require $_SERVER["DOCUMENT_ROOT"] . "/Include/Database.php";
$sql = new mysqli($server, $username, $password, $database);
if ($sql->connect_error) {
    http_response_code(500);
    die("Couldn't Connect To Database");
}
$email = filter_input(INPUT_POST, "email");
$password = filter_input(INPUT_POST, "password");
if ($email == null) {
    http_response_code(400);
    die("Email cannot be blank");
}
if ($password == null) {
    http_response_code(400);
    die("Password cannot be blank");
}
$stmt = $sql->query("Select ID,UserType,Name,Email from Users where email='$email' and password=SHA2('$password',256)");
if ($stmt && mysqli_num_rows($stmt) == 0) {
    http_response_code(400);
    $sql->close();
    die("Invalid Username/Password");
}
while ($row = $stmt->fetch_assoc()) {
    $name = $row["Name"];
    $email = $row["Email"];
    $userType = $row["UserType"];
    $id = $row["ID"];
}
session_start();
$_SESSION["Name"] = $name;
$_SESSION["Email"] = $email;
$_SESSION["ID"] = $id;
$_SESSION["UserType"] = $userType;
http_response_code(200);
//echo "Login Successful<br>";
//var_dump($_SESSION);
$sql->close();
if(isset($_GET["fwd"])){
    header("Location: /Pages/Dashboard.php");
}