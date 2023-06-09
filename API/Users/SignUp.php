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
$name = filter_input(INPUT_POST, "name");
$created = date("Y:m:d H:i:s");
if ($email == null) {
    http_response_code(400);
    die("Email cannot be blank");
}
if ($name == null) {
    http_response_code(400);
    die("Name cannot be blank");
}
if ($password == null) {
    http_response_code(400);
    die("Password cannot be blank");
}
$stmt = $sql->query("Select email from Users where email='$email'");
if ($stmt && mysqli_num_rows($stmt) > 0) {
    http_response_code(400);
    $sql->close();
    die("A user with this email already exists");
}
$pstmt = $sql->prepare("Insert into Users (email,password,name,timestamp) VALUES (?,SHA2(?,256),?,?)");
$pstmt->bind_param("ssss", $email, $password, $name, $created);
$result = $pstmt->execute();
if (!$result) {
    http_response_code(500);
    die("Unable to create user: " . mysqli_error($sql));
}
http_response_code(201);

if (isset($_GET["login"]) && isset($_GET["fwd"])) {
    $stmt = $sql->query("Select ID,UserType from Users where email='$email'");
    if ($stmt && mysqli_num_rows($stmt) > 0) {
        while ($row = $stmt->fetch_assoc()) {
            $userType = $row["UserType"];
            $id = $row["ID"];
        }
        session_start();
        $_SESSION["Name"] = $name;
        $_SESSION["Email"] = $email;
        $_SESSION["ID"] = $id;
        $_SESSION["UserType"] = $userType;
        header("Location: /Pages/Dashboard.php");
    } else {
        http_response_code(500);
        die("Error logging in after user creation???");
    }
} else if (isset($_GET["login"])) {
    $stmt = $sql->query("Select ID,UserType from Users where email='$email'");
    if ($stmt && mysqli_num_rows($stmt) > 0) {
        while ($row = $stmt->fetch_assoc()) {
            $userType = $row["UserType"];
            $id = $row["ID"];
        }
        session_start();
        $_SESSION["Name"] = $name;
        $_SESSION["Email"] = $email;
        $_SESSION["ID"] = $id;
        $_SESSION["UserType"] = $userType;
    } else {
        http_response_code(500);
        die("Error logging in after user creation???");
    }
}
$sql->close();
