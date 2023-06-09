<html>
    <head>
        <title>Tutor Buddy</title>
        <link rel="stylesheet" href="/Styles/MainStyle.css"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <?php include $_SERVER["DOCUMENT_ROOT"] . "/Include/NavBar.php"; ?>
        <div class="availableTutors">
            <script src="/Scripts/Tutors.js"></script>
            <h3>Recommend Tutor</h3>

            <div class='recommendTutor'>
                Recommend a tutor for: 
                <input type='hidden' name='myID' value='<?PHP echo $_SESSION["ID"]?>' readonly/>
                <select id='studentClasses'>

                </select> 
                <div class='recommendedTutor'></div>
            </div>
            <h3>Tutors Available</h3>
            <?php
            require $_SERVER["DOCUMENT_ROOT"] . "/Include/Database.php";
            $sql = new mysqli($server, $username, $password, $database);
            if ($sql->connect_error) {
                http_response_code(500);
                die("Couldn't Connect To Database");
            }
            $stmt = $sql->query("Select * from TutorView where ID not in (SELECT TutorID from StudentTutors where StudentID={$_SESSION["ID"]}) order by Rating DESC");
            if (mysqli_num_rows($stmt) != 0) {
                while ($row = $stmt->fetch_assoc()) {
                    $class = "<div class='tutorCard' data-tutorid='{$row["ID"]}'>"
                            . "<strong>Name:</strong><br> {$row["Name"]}<br>"
                            . "<strong>About Me:</strong><br> {$row["BioInfo"]}<br>"
                            . "<strong>Rating:</strong><br> " . ($row["Rating"] == null ? 0 : $row["Rating"]) . "/5<br>"
                            . (file_exists($_SERVER["DOCUMENT_ROOT"] . "/Images/Tutors/{$row["ID"]}.jpg") ? "<img width='50%' src='/Images/Tutors/{$row["ID"]}.jpg'/>" : "<p>No Image Available</p>")
                            . "<br><br><div class='addTutor'><button data-id='{$row["ID"]}' data-studentID='{$_SESSION["ID"]}' class='AddTutorButton'>Add To My Favorites!</button></div></div>";
                    echo $class;
                }
            } else {
                echo "No Tutors Available!";
            }
            ?>


        </div>
    </body>


</html>