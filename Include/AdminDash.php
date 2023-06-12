<div class="adminDash">

    <script>
        $(document).ready(function () {
            $(".approveTutorButton").click(function (event) {
                let classElem = $(this)[0];
                let id = classElem.dataset.id;
                $.ajax({
                    type: "POST",
                    url: "/API/Users/ApproveTutor.php",
                    data: "id=" + id,
                    async: false,
                    success: function (data) {
                        classElem.parentElement.parentElementremove();
                        alert("Tutor Approved");
                        return true;
                    },
                    error: function (data) {
                        //classElem.parentElement.parentElement.remove();
                        return false;
                    }
                });
            });
            $(".rejectTutorButton").click(function (event) {
                let classElem = $(this)[0];
                let id = classElem.dataset.id;
                $.ajax({
                    type: "POST",
                    url: "/API/Users/RejectTutor.php",
                    data: "id=" + id,
                    async: false,
                    success: function (data) {
                        classElem.parentElement.parentElement.remove();
                        alert("Tutor Rejected");
                        return true;
                    },
                    error: function (data) {
                        // classElem.parentElement.parentElement.remove();
                        return false;
                    }
                });
            });


            $(".deleteUser").click(function (event) {
                let classElem = $(this)[0];
                let id = classElem.dataset.id;
                if (!confirm("Are you sure you would like to delete this user?")) {
                    return;
                }
                $.ajax({
                    type: "POST",
                    url: "/API/Users/DeleteUser.php",
                    data: "id=" + id,
                    async: false,
                    success: function (data) {
                        classElem.parentElement.parentElement.remove();
                        alert("User Deleted");
                    },
                    error: function (data) {
                        // classElem.parentElement.parentElement.remove();
                        return false;
                    }
                });
            });

            $(".editUser").click(function (event) {
                let user = $(this)[0];
                let id = user.dataset.id;
                $(".passwordReset").dialog(
                        {
                            title: "Reset Password for User  " + id,
                            modal: true,
                            buttons: [
                                {
                                    text: "Reset",
                                    click: function () {
                                        let pass1 = $("input[name=password1]").val();
                                        let pass2 = $("input[name=password2]").val();
                                        if (pass1 !== pass2) {
                                            alert("Passwords must match");
                                            return;
                                        }
                                        $.ajax({
                                            type: "POST",
                                            url: "/API/Users/ResetPassword.php",
                                            data: "id=" + id + "&password=" + pass1,
                                            async: false,
                                            success: function (data) {
                                                alert("User Updated");
                                            },
                                            error: function (data) {
                                                // classElem.parentElement.parentElement.remove();
                                                return false;
                                            }
                                        });

                                    }
                                }
                            ]
                        }
                );
            });
            $(".addClass").click(function (event) {
                $(".addClassDialog").dialog(
                        {
                            title: "Add New Class",
                            modal: true,
                            buttons: [
                                {
                                    text: "Add",
                                    click: function () {
                                        $.ajax({
                                            type: "POST",
                                            url: "/API/api.php/records/Classes",
                                            data: $('.addClassDialog form').serialize(),
                                            async: false,
                                            success: function (data) {
                                                alert("Class Added");
                                                location.reload();
                                            },
                                            error: function (data) {
                                                // classElem.parentElement.parentElement.remove();
                                                return false;
                                            }
                                        });

                                    }
                                }
                            ]
                        }
                );
            });

            $(".DeleteClass").click(function (event) {
                let elem = $(this)[0];
                let id = elem.dataset.id;
                if (!confirm("Are you sure you would like to delete this class?")) {
                    return;
                }
                $.ajax({
                    type: "DELETE",
                    url: "/API/api.php/records/Classes/" + id,
                    async: false,
                    success: function (data) {
                        elem.parentElement.parentElement.remove();
                        alert("Class Deleted");
                    },
                    error: function (data) {
                        // classElem.parentElement.parentElement.remove();
                        return false;
                    }
                });

            });
            
            
            $(".joinLink").click(function (event) {
                let elem = $(this)[0];
                let id = elem.dataset.id;
                
                $.ajax({
                    type: "GET",
                    url: "/API/api.php/records/Schedules/" + id,
                    async: false,
                    success: function (data) {
                       window.location.href=data["MeetingLink"];
                    },
                    error: function (data) {
                        // classElem.parentElement.parentElement.remove();
                        return false;
                    }
                });

            });
        });



    </script>
    <div class='flex-container'>
        <div class="box">
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
            $stmt = $sql->query("SELECT * FROM TutorScheduleView");


            //if the table is not equal to 0 then while this is true fetch all variables
            if ($stmt && mysqli_num_rows($stmt) != 0) {
                while ($row = $stmt->fetch_assoc()) {
                    //row from studentClassesView
                    //create variable to grab student information from another table 
                    //showing all session information 
                    $class = "<div class='classCard'>"
                            . "Session Date: " . date_format(date_create($row["Date"]), "m/d/Y") . "<br>"
                            . "Session Class: {$row["ClassName"]}<br>"
                            . "Session Tutor ID: {$row["TutorID"]}<br>"
                            . "Session Start Time:  " . date_format(date_create("1/1/2000 " . $row["StartTime"]), "h:i:s a") . "<br>"
                            . "Session End Time:  " . date_format(date_create("1/1/2000 " . $row["EndTime"]), "h:i:s a") . "<br>"
                            . "\n<div class='joinClassLink'><button data-id='{$row["ID"]}' class='joinLink'>Join Session!</button></div>"
                            . "\n<div><button data-id='{$row["ID"]}' class='ViewAssignmentsButton'>View Assignments!</button></div>\n</div>";
                    echo $class;
                }
            } else {
                echo "No Classes Scheduled";
            }
            ?>
        </div>

        <!-- adding All Classes view and ability to edit/add classes within the admin dashboard -->
        <div class="box">
            <h4>All Classes</h4>
            <button class='addClass'>Add Class</button>
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
                . "<button data-id='{$row["ID"]}' class='DeleteClass'>Remove Class</button></div>\n</div>";
        echo $class;
    }
} else {
    echo "No Classes Found!";
}
?>

        </div>
    </div>
    <div class='flex-container'>
        <!-- All Tutors table and adding "viewTutor" && Delete tutor button -->
        <div class="box">
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
        <div class="box">
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
                . "<div><button class='approveTutorButton' data-id='{$row["ID"]}'>Approve Tutor</button>&nbsp;&nbsp;"
                . "<button class='rejectTutorButton' data-id='{$row["ID"]}' >Reject Tutor</button></div>\n</div>";
        echo $class;
    }
} else {
    echo "No Pending Applications!";
}
?>
        </div>
    </div>
    <div class='flex-container'>
        <!-- All Tutors table and adding "viewTutor" && Delete tutor button -->
        <div class="box">
            <h4>All Users</h4>
<?php
require $_SERVER["DOCUMENT_ROOT"] . "/Include/DataBase.php";
$sql = new mysqli($server, $username, $password, $database);
if ($sql->connect_error) {
    http_response_code(500);
    die("Couldn't Connect To Database");
}
$stmt = $sql->query("SELECT ID,Name,Email,UserType FROM Users");
if ($stmt && mysqli_num_rows($stmt) != 0) {
    while ($row = $stmt->fetch_assoc()) {
        $class = "<div class='tutorCard'>"
                . "<strong>ID:</strong>{$row["ID"]}<br>"
                . "Name: {$row["Name"]}<br>"
                . "Email: {$row["Email"]}<br>"
                . "UserType: {$row["UserType"]}<br>"
                . "<button class='editUser' data-id='{$row["ID"]}'>Reset Password</button><button class='deleteUser' data-id='{$row["ID"]}'>Delete</button></div>";
        echo $class;
    }
} else {
    echo "No Tutors Availiable!"; //not sure what to put here lol
}
?>
        </div>


    </div>


    <div class='passwordReset' style='display: none'>
        <form>
            Password: <input type='password' name='password1'/><br><br>Retype: <input type='password' name='password2'/>
        </form>

    </div>

    <div class='addClassDialog' style='display: none'>
        <form>
            <input type='text' name='ClassName' placeholder='Class Name'><br>
            <input type='text' name='ClassNumber' placeholder='Class Number'><br>
            <input type='text' name='University' placeholder='University'><br>
            <input type='text' name='Book' placeholder='Book'><br>
        </form>

    </div>
</div>