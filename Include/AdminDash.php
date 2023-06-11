<div class="adminDash">
    <div class="column border-gradient-rounded">
        <!-- All Sessions for Admin to view, edit, and join all sessions -->
        <h4>All Sessions</h4>
        <?php 
            require $_SERVER["DOCUMENT_ROOT"] . "/Include/Database.php";
            $sql = new mysqli($server, $username, $password, $database);

            //throw error if you can't connect to the database
            if($sql -> connect_error){
                http_response_code(500);
                die("Couldn't Connect To Database");
            }

            //create sql query to pull from the table Schedules
            $stmt = $sql -> query("SELECT * FROM Schedules WHERE ID={$_SESSION["ID"]}");

            //pull from studentClasses view and pull tutor name and student name
            $studentInfo = $sql -> query("SELECT * FROM StudentUpcomingSessions WHERE StudentID={$_SESSION["ID"]}");


            //if the table is not equal to 0 then while this is true fetch all variables
            if($stmt && mysqli_num_rows($stmt) != 0){
                while ($row = $stmt -> fetch_assoc()){
                    //row from studentClassesView
                    $sessionInfo = $studentInfo -> fetch_assoc();

                    $className = null;
                    $classNumber = null;
                    $tutorName = null;

                    //create variable to grab student information from another table 
                    if(isset($row['Date']) && $sessionInfo['Date'] === true){
                        $className = $sessionInfo['ClassName'];
                        $tutorName = $sessionInfo['TutorName'];
                        $classNumber = $sessionInfo['ClassNumber'];
                    }
                    //showing all session information 
                    $class = "<div class='classCard'>"
                        . "Session Date: " . date_format(date_create($row["Date"]), "m/d/Y") . "<br>"
                        . "Session Class: {$className}<br>"
                        . "Session Tutor ID: {$row["Tutor ID"]}<br>"
                        . "Session Tutor: {$tutorName}<br>"
                        . "Session Start Time: {$row["Start Time"]}<br>"
                        . "Session End Time: {$row["End Time"]}<br>"
                        . "<div class='joinClassLink'><button data-id='{$row["ID"]}' data-studentID='{$_SESSION["ID"]}' class='joinLink'>Join Session!</button></div>"
                        . "<div><button data-id='{$row["ID"]}' class='ViewAssignmentsButton'>View Assignments!</button></div>";
                    echo $class;
                }
            }
            else{
                echo "No Classes Scheduled";
            }
        ?>
    </div>
    
    <!-- adding All Classes view and ability to edit/add classes within the admin dashboard -->
    <div class="column border-gradient-rounded">
        <h4>All Classes</h4>

        <?php
            require $_SERVER["DOCUMENT ROOT"] . "/Include/Database.php";
            $sql = new mysqli($server, $username, $password, $database);
            
            //throw error if you can't connect to the database
            if($sql -> connect_error){
                http_response_code(500);
                die("Couldn't Connect to Database");
            }
            //create sql query to pull from the table Classes
            $classes = $sql -> query("SELECT * FROM Classes");
            
            //if the table is not equal to 0 then while this is true fetch all variables
            if($classes && mysqli_num_rows($classes)){
                while($row = $classes -> fetch_assoc()){
                    $class = "<div class='classCard'>"
                        . "Class Name: {$row["ClassName"]}<br>"
                        . "Class Number: {$row["ClassNumber"]}<br>"
                        . "University: {$row["University"]}<br>"
                        . "<div class='removeClass'><button data-id='{$row["ID"]}' class='RemoveClassButton'>Remove Class</button></div></div>";
                    echo $class;
                }
            }
            else{
                echo "No Classes Found!";
            }

        ?>
        
    </div>

    <!-- All Tutors table and adding "viewTutor" && Delete tutor button -->
    <div class="column border-gradient-rounded">
        <h4>All Tutors</h4>
        <?php
        require $_SERVER["DOCUMENT_ROOT"] . "/Include/Database.php";
        $sql = new mysqli($server, $username, $password, $database);
        if ($sql->connect_error) {
            http_response_code(500);
            die("Couldn't Connect To Database");
        }
        $stmt = $sql->query("SELECT * FROM StudentTutorView");
        if ($stmt && mysqli_num_rows($stmt) != 0) {
            while ($row = $stmt->fetch_assoc()) {
                $class = "<div class='tutorCard'>"
                        . "<strong>Name:</strong><br> {$row["Name"]}<br>"
                        . (file_exists($_SERVER["DOCUMENT_ROOT"] . "/Images/Tutors/{$row["TutorID"]}.jpg") ? "<img width='100%' src='/Images/Tutors/{$row["TutorID"]}.jpg'/>" : "<p>No Image Available</p>")
                        . "<br><br><div class='tutorButtons'><button data-id='{$row["ID"]}' class='RemoveTutorButton'>Remove from Favorites</button><br><button data-tutorid='{$row["TutorID"]}' data-name='{$row["Name"]}' data-studentid='{$_SESSION["ID"]}' class='RateTutorButton'>Rate!</button></div></div>";
                echo $class;
            }
        }
        else {
            echo "No Tutors Availiable!";
        }
        ?>
    </div>
</div>