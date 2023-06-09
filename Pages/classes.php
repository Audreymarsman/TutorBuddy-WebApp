<html>
    <head>
        <title>Tutor Buddy</title>
        <link rel="stylesheet" href="/Styles/MainStyle.css"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">

    </head>
    <body>
        <?php include $_SERVER["DOCUMENT_ROOT"] . "/Include/NavBar.php"; ?>
        <div class="availableClasses">
            <script src="/Scripts/Classes.js"></script>
            <h3>Classes Available</h3>
            <?php
            require $_SERVER["DOCUMENT_ROOT"] . "/Include/Database.php";
            $sql = new mysqli($server, $username, $password, $database);
            if ($sql->connect_error) {
                http_response_code(500);
                die("Couldn't Connect To Database");
            }
            $stmt = $sql->query("Select * from Classes t1 where t1.ID not in (Select ClassID from StudentClasses where StudentID={$_SESSION["ID"]})");
            if (mysqli_num_rows($stmt) != 0) {
                while ($row = $stmt->fetch_assoc()) {
                    $class = "<div class='classCard'>"
                            . "Class Name: {$row["ClassName"]}<br>"
                            . "Class Number: {$row["ClassNumber"]}<br>"
                            . "University: {$row["University"]}<br>"
                            . "<div class='addClassLink'><button data-id='{$row["ID"]}' data-studentID='{$_SESSION["ID"]}' class='addClass'>Add To My Classes!</button></div></div>";
                    echo $class;
                }
            } else {
                echo "No Classes Available!";
            }
            ?>


        </div>
    </body>


</html>