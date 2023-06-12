<div class="availableClasses">
    <script>
        $(document).ready(function () {
            populateClasses();
            $(".createSession").click(function (event) {
                $(".addSessionDialog").dialog(
                        {
                            title: "Add New Session",
                            modal: true,
                            width: "300 px",
                            buttons: [
                                {
                                    text: "Add",
                                    click: function () {
                                        let postdata = $(".addSessionDialog form").serialize();
                                        $.ajax({
                                            type: "POST",
                                            url: "/API/api.php/records/Schedules",
                                            data: postdata,
                                            async: false,
                                            success: function (data) {
                                                alert("Session Added");
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
                $(".addSessionDialog form").clear();
            });

            $(".deleteSessionButton").click(function (event) {
                if (!confirm("Are you sure you would like to delete this session?")) {
                    return;
                }
                let session = $(this)[0];
                let id = session.dataset.id;
                $.ajax({
                    type: "DELETE",
                    url: "/API/api.php/records/Schedules/" + id,
                    async: false,
                    success: function (data) {
                        alert("Session Deleted");
                        session.parentElement.parentElement.remove();
                    },
                    error: function (data) {

                        return false;
                    }
                });
            });

            $(".editSessionButton").click(function (event) {
                let session = $(this)[0];
                let id = session.dataset.id;
                $.ajax({
                    type: "GET",
                    url: "/API/api.php/records/Schedules/" + id,
                    async: false,
                    success: function (data) {
                        let session = data;
                        $(".addSessionDialog Select[name=ClassID]").val(session["ClassID"]);
                        $(".addSessionDialog input[name=Date]").val(session["Date"]);
                        $(".addSessionDialog input[name=StartTime]").val(session["StartTime"]);
                        $(".addSessionDialog input[name=EndTime]").val(session["EndTime"]);
                        $(".addSessionDialog input[name=MeetingLink]").val(session["MeetingLink"]);
                    },
                    error: function (data) {
                        // classElem.parentElement.parentElement.remove();
                        return false;
                    }
                });
                $(".addSessionDialog").dialog(
                        {
                            title: "Edit Session",
                            modal: true,
                            width: "300 px",
                            buttons: [
                                {
                                    text: "Edit",
                                    click: function () {
                                        let postdata = $(".addSessionDialog form").serialize();
                                        $.ajax({
                                            type: "PUT",
                                            url: "/API/api.php/records/Schedules/" + id,
                                            data: postdata,
                                            async: false,
                                            success: function (data) {
                                                alert("Session Edited");
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
                $(".addSessionDialog form").clear();
            });
        });

        function populateClasses() {
            $.ajax({
                type: "GET",
                url: "/API/api.php/records/Classes",
                async: true,
                success: function (data) {
                    let classes = data["records"];
                    $(classes).each(function (index) {
                        let clas = data["records"][index]; //intentional misspelling. class is reserved
                        $(".addSessionDialog select").append("<option value='" + clas["ID"] + "'>" + clas["ClassNumber"] + ", " + clas["ClassName"] + " (" + clas["University"] + ")</option>");
                    });
                },
                error: function (data) {
                    alert(data);
                }
            });
        }

    </script>
    <div class="column border-gradient-rounded">
        <h4>Upcoming Sessions</h4>
        <button class='createSession'>Create Session</button>
        <?php
        require $_SERVER["DOCUMENT_ROOT"] . "/Include/Database.php";
        $sql = new mysqli($server, $username, $password, $database);
        if ($sql->connect_error) {
            http_response_code(500);
            die("Couldn't Connect To Database");
        }
        $stmt = $sql->query("Select * from TutorScheduleView where `TutorID`={$_SESSION["ID"]} order by `Date` ASC");
        if ($stmt && mysqli_num_rows($stmt) != 0) {
            while ($row = $stmt->fetch_assoc()) {
                $class = "<div class='classCard'>"
                        . "Class Name: {$row["ClassName"]}<br>"
                        . "Class Number: {$row["ClassNumber"]}<br>"
                        . "University: {$row["University"]}<br>"
                        . "Start Time: ".date_format(date_create("1/1/2000 ".$row["StartTime"]),"h:i:s a")."<br>"
                        . "End Time: ".date_format(date_create("1/1/2000 ".$row["EndTime"]),"h:i:s a")."<br>"
                        . "Date: " . date_format(date_create($row["Date"]), "m/d/Y") . "<br>"
                        . "<button data-id={$row["ID"]} class='editSessionButton'>Edit Session</button>&nbsp;&nbsp;<button data-id={$row["ID"]} class='deleteSessionButton'>Delete Session</button></div>";
                echo $class;
            }
        } else {
            echo "No Upcoming Sessions!";
        }
        ?>

    </div>

    <div class='addSessionDialog' style='display: none'>
        <form>
            <input type="hidden" value="<?PHP echo $_SESSION["ID"] ?>" name="TutorID"/><br>
            Class: <select name='ClassID'><option value=''>--Select Class--</option></select><br>
            Date: <input type='date' name='Date' placeholder="Date"/><br>
            Start Time: <input type='time' name='StartTime'  placeholder="Start Time"/><br>
            End Time: <input type='time' name='EndTime'  placeholder="End Time"/><br>
            Meeting Link: <input type='text' name='MeetingLink'  placeholder="Meeting Link"/>
        </form>

    </div>


</div>