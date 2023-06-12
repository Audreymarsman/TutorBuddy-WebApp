<div class="availableClasses">
            <script src="/Scripts/Sessions.js"></script>
            <h3>Sessions Available</h3>
            <?php
            require $_SERVER["DOCUMENT_ROOT"] . "/Include/Database.php";
            $sql = new mysqli($server, $username, $password, $database);
            if ($sql->connect_error) {
                http_response_code(500);
                die("Couldn't Connect To Database");
            }
            $stmt = $sql->query("Select t1.ID,t1.StartTime,t1.EndTime,t1.Date,"
                    . "(Select t2.Name from Users t2 where ID=t1.TutorID) as Tutor,"
                    . "t3.ClassName,t3.University,t3.ClassNumber from Schedules t1 "
                    . "INNER JOIN Classes t3 ON t3.ID=t1.ClassID "
                    . "where t1.ID not in (Select ID from StudentSchedules where StudentID={$_SESSION["ID"]}) "
                    . "and t1.ClassID in (Select ClassID from StudentClasses where StudentID={$_SESSION["ID"]}) "
                    . "AND t1.TutorID in (Select TutorID from StudentTutors where StudentID={$_SESSION["ID"]})");
            if (mysqli_num_rows($stmt) != 0) {
                while ($row = $stmt->fetch_assoc()) {
                    $class = "<div class='classCard'>"
                            . "Class Name: {$row["ClassName"]}<br>"
                            . "Class Number: {$row["ClassNumber"]}<br>"
                            . "University: {$row["University"]}<br>"
                            . "Tutor: {$row["Tutor"]}<br>"
                            . "Start Time: {$row["StartTime"]}<br>"
                            . "End Time: {$row["EndTime"]}<br>"
                            . "Date: {$row["Date"]}<br>"
                            . "<div class='joinClassLink'><button data-id='{$row["ID"]}' data-studentID='{$_SESSION["ID"]}' class='joinLink'>Join Session!</button></div></div>";
                    echo $class;
                }
            } else {
                echo "No Sessions Available!";
            }
            ?>


        </div>