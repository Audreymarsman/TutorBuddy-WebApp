<div class="studentDash">
    <div class="column border-gradient-rounded">
        <h4>Upcoming Sessions</h4>

        <?php
        require $_SERVER["DOCUMENT_ROOT"] . "/Include/Database.php";
        $sql = new mysqli($server, $username, $password, $database);
        if ($sql->connect_error) {
            http_response_code(500);
            die("Couldn't Connect To Database");
        }
        $stmt = $sql->query("Select * from StudentUpcomingSessions where StudentID={$_SESSION["ID"]} LIMIT 5");
        if ($stmt && mysqli_num_rows($stmt) != 0) {
            while ($row = $stmt->fetch_assoc()) {
                $class = "<div class='classCard'>"
                        . "Class Name: {$row["ClassName"]}<br>"
                        . "Class Number: {$row["ClassNumber"]}<br>"
                        . "University: {$row["University"]}<br>"
                        . "Tutor: {$row["Tutor Name"]}<br>"
                        . "Start Time: {$row["StartTime"]}<br>"
                        . "End Time: {$row["EndTime"]}<br>"
                        . "Date: " . date_format(date_create($row["Date"]), "m/d/Y") . "<br>"
                        . "<div class='joinClassLink'><button data-id='{$row["ID"]}' data-studentID='{$_SESSION["ID"]}' class='joinLink'>Join Session!</button></div></div>";
                echo $class;
            }
        } else {
            echo "No Upcoming Sessions! <a href='/Pages/Sessions.php'>Sign Up</a>";
        }
        ?>

    </div>
    <div class="column border-gradient-rounded">
        <h4>My Classes</h4>
        <?php
        require $_SERVER["DOCUMENT_ROOT"] . "/Include/Database.php";
        $sql = new mysqli($server, $username, $password, $database);
        if ($sql->connect_error) {
            http_response_code(500);
            die("Couldn't Connect To Database");
        }
        $stmt = $sql->query("Select * from StudentClassesView where StudentID={$_SESSION["ID"]}");
        if ($stmt && mysqli_num_rows($stmt) != 0) {
            while ($row = $stmt->fetch_assoc()) {
                $class = "<div class='classCard'>"
                        . "Class Name: {$row["ClassName"]}<br>"
                        . "Class Number: {$row["ClassNumber"]}<br>"
                        . "University: {$row["University"]}<br>"
                        . "<div><button data-id='{$row["ID"]}' class='AddAssignmentButton'>Upload Assignment!</button></div>"
                        . "<div><button data-id='{$row["ID"]}' class='ViewAssignmentsButton'>View Assignments!</button></div>"
                        . "<div class='removeClass'><button data-id='{$row["ID"]}' class='RemoveClassButton'>Remove Class</button></div></div>";
                echo $class;
            }
        } else {
            echo "No Classes! <a href='/Pages/Classes.php'>Add Some</a>";
        }
        ?>
    </div>
    <div class="column border-gradient-rounded">
        <h4>My Tutors</h4>
        <?php
        require $_SERVER["DOCUMENT_ROOT"] . "/Include/Database.php";
        $sql = new mysqli($server, $username, $password, $database);
        if ($sql->connect_error) {
            http_response_code(500);
            die("Couldn't Connect To Database");
        }
        $stmt = $sql->query("Select * from StudentTutorView where StudentID={$_SESSION["ID"]}");
        if ($stmt && mysqli_num_rows($stmt) != 0) {
            while ($row = $stmt->fetch_assoc()) {
                $class = "<div class='tutorCard'>"
                        . "<strong>Name:</strong><br> {$row["Name"]}<br>"
                        . (file_exists($_SERVER["DOCUMENT_ROOT"] . "/Images/Tutors/{$row["TutorID"]}.jpg") ? "<img width='100%' src='/Images/Tutors/{$row["TutorID"]}.jpg'/>" : "<p>No Image Available</p>")
                        . "<br><br><div class='tutorButtons'><button data-id='{$row["ID"]}' class='RemoveTutorButton'>Remove from Favorites</button><br><button data-tutorid='{$row["TutorID"]}' data-name='{$row["Name"]}' data-studentid='{$_SESSION["ID"]}' class='RateTutorButton'>Rate!</button></div></div>";
                echo $class;
            }
        } else {
            echo "No Tutors Yet! <a href='/Pages/Tutors.php'>Add Some Now!</a>";
        }
        ?>
    </div>

    <div id='ratePopup'>
        <label>0</label>
        <input type='radio' name='rating' value='0'><br>
        <label>1</label>
        <input type='radio' name='rating' value='1'><br>
        <label>2</label>
        <input type='radio' name='rating' value='2'><br>
        <label>3</label>
        <input type='radio' name='rating' value='3'><br>
        <label>4</label>
        <input type='radio' name='rating' value='4'><br>
        <label>5</label>
        <input type='radio' name='rating' value='5'><br>
    </div>

    <div id='uploadPopup'>
        <form>
            <input type='hidden' name='classID'/>
            <label>File</label>
            <input type='file' name='file'/>
            <progress class="progress" value="0" max="100"></progress>
        </form>
    </div>
</div>