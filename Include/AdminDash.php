<div class="adminDash">

    <script>
        $(document).ready(function () {
            $("#approveTutorButton").click(function (event) {
                let classElem = $(this)[0];
                let id = classElem.dataset.id;
                $.ajax({
                    type: "POST",
                    url: "/API/Users/ApproveTutor/",
                    data: "id=" + id,
                    async: false,
                    success: function (data) {
                        return true;
                    },
                    error: function (data) {
                        return false;
                    }
                });
            });
            $("#rejectTutorButton").click(function (event) {
                let classElem = $(this)[0];
                let id = classElem.dataset.id;
                $.ajax({
                    type: "POST",
                    url: "/API/Users/RejectTutor/",
                    data: "id=" + id,
                    async: false,
                    success: function (data) {
                        window.reload();
                        return true;
                    },
                    error: function (data) {
                        return false;
                    }
                });
            });



        });



    </script>
    <div class="column border-gradient-rounded">
        <!-- All Sessions for Admin to view, edit, and join all sessions -->
        <h4>All Sessions</h4>
        <?php
        
        require $_SERVER["DOCUMENT_ROOT"] . "/Include/DataBase.php";
        $sql = new mysqli($server, $username, $password, $database);

        //throw error if you can't connect to the database
        if ($sql->connect_error) {
            http_response_code(500);
            die("Couldn't Connect To Database");
        }

        //create  sql query to pull from the table Schedules
        $stmt = $sql->query("SELECT * FROM Schedules");

        //pull from studentClasses view and pull tutor name and student name
        $studentInfo = $sql->query("SELECT * FROM StudentUpcomingSessions");


        //if the table is not equal to 0 then while this is true fetch all variables
        if ($stmt && mysqli_num_rows($stmt) != 0) {
            while ($row = $stmt->fetch_assoc()) {
                //row from studentClassesView

                while ($sessionInfo = $studentInfo->fetch_assoc()) {
                    //create variable to grab student information from another table 
                    $className = $sessionInfo['ClassName'];
                    $tutorName = $sessionInfo['Tutor Name'];
                    $classNumber = $sessionInfo['ClassNumber'];
                    //showing all session information 
                    $class = "<div class='classCard'>"
                            . "Session Date: " . date_format(date_create($row["Date"]), "m/d/Y") . "<br>"
                            . "Session Class: {$className}<br>"
                            . "Session Tutor ID: {$row["TutorID"]}<br>"
                            . "Session Tutor: {$tutorName}<br>"
                            . "Session Start Time: {$row["StartTime"]}<br>"
                            . "Session End Time: {$row["EndTime"]}<br>"
                            . "\n<div class='joinClassLink'><button data-id='{$row["ID"]}' data-studentID='{$_SESSION["ID"]}' class='joinLink'>Join Session!</button></div>"
                            . "\n<div><button data-id='{$row["ID"]}' class='ViewAssignmentsButton'>View Assignments!</button></div>\n</div>";
                    echo $class;
                }
            }
        } else {
            echo "No Classes Scheduled";
        }
        ?>
    </div>

    <!-- adding All Classes view and ability to edit/add classes within the admin dashboard -->
    <div class="column border-gradient-rounded">
        <h4>All Classes</h4>

        <?php
        require $_SERVER["DOCUMENT_ROOT"] . "/Include/DataBase.php";
        $sql = new mysqli($server, $username, $password, $database);
        // add function to assign tutors and approve tutors to different courses
        //throw error if you can't connect to the database
        if ($sql->connect_error) {
            http_response_code(500);
            die("Couldn't Connect to Database");
        }
        //create sql query to pull from the table Classes
        $classes = $sql->query("SELECT * FROM Classes");

        //if the table is not equal to 0 then while this is true fetch all variables
        if ($classes && mysqli_num_rows($classes)) {
            while ($row = $classes->fetch_assoc()) {
                $class = "<div class='classCard'>"
                        . "Class Name: {$row["ClassName"]}<br>"
                        . "Class Number: {$row["ClassNumber"]}<br>"
                        . "University: {$row["University"]}<br>"
                        . "<div class='removeClass'>"
                                . "<button data-id='{$row["ID"]}' class='RemoveClassButton'>Remove Class</button></div>\n</div>";
                echo $class;
            }
        } else {
            echo "No Classes Found!";
        }
        ?>

    </div>

    <!-- All Tutors table and adding "viewTutor" && Delete tutor button -->
    <div class="column border-gradient-rounded">
        <h4>All Tutors</h4>
        <?php
        require $_SERVER["DOCUMENT_ROOT"] . "/Include/DataBase.php";
        $sql = new mysqli($server, $username, $password, $database);
        if ($sql->connect_error) {
            http_response_code(500);
            die("Couldn't Connect To Database");
        }
        $stmt = $sql->query("SELECT ID,Name,BioInfo,Rating FROM TutorView");
        if ($stmt && mysqli_num_rows($stmt) != 0) {
            while ($row = $stmt->fetch_assoc()) {
                $class = "<div class='tutorCard'>"
                        . "<strong>Name:</strong><br> {$row["Name"]}<br>"
                        . "BioInfo: {$row["BioInfo"]}<br>"
                        . "Rating: {$row["Rating"]}<br></div>";
                echo $class;
            }
        } else {
            echo "No Tutors Availiable!"; //not sure what to put here lol
        }
        ?>
    </div>

    <!-- Reviewing candidates that applied for tutoring -->
    <div class="border-gradient-rounded">
        <h4>Tutoring Applications Pending</h4>
        <?php
        require $_SERVER["DOCUMENT_ROOT"] . "/Include/DataBase.php";
        $sql = new mysqli($server, $username, $password, $database);
        if ($sql->connect_error) {
            http_response_code(500);
            die("Couldn't Connect To Database");
        }
        $stmt = $sql->query("SELECT ID,Email,Name,BioInfo FROM Users WHERE UserType=4");
        if ($stmt && mysqli_num_rows($stmt) != 0) {
            while ($row = $stmt->fetch_assoc()) {
                //email password name & join with other table 
                $class = "<div class='tutorCard'>"
                        . "<strong>Name:</strong><br> {$row["Name"]}<br>"
                        . "Email: {$row["Email"]}<br>"
                        . "Name: {$row["Name"]}<br>"
                        . "BioInfo: {$row["BioInfo"]}<br>"
                        //ideally the button for pressing accept would be right here. I don't know how to play with the logic 
                        . "<div><button id='approveTutorButton' data-id='{$row["ID"]}' class='approveTutorButton'>Approve Tutor</button>&nbsp;&nbsp;"
                        . "<button id='rejectTutorButton' data-id='{$row["ID"]}' class='rejectbutton'>Approve Tutor</button></div>\n</div>";
                echo $class;
            }
        } else {
            echo "No Tutors Availiable!";
        }
        ?>
    </div>
</div>