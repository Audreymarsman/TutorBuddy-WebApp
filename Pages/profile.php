<html>
    <head>
        <title>Tutor Buddy</title>
        <link rel="stylesheet" href="/Styles/MainStyle.css"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            .accountUpgrade textarea{
                height: 200px;
                width: 50%;
            }
            .ApplyButton{
                width: 40%;
            }

            .profilePicPopup{
                display: none;
            }

        </style>
    </head>
    <body>
        <?php include $_SERVER["DOCUMENT_ROOT"] . "/Include/NavBar.php"; ?>
        <script>
            $(document).ready(function () {
                var availRow = 0;
                $.ajax({
                    type: "GET",
                    url: "/API/api.php/records/UserAvailability?filter=UserID,eq,<?PHP echo $_SESSION["ID"] ?>",
                    async: true,
                    success: function (data) {
                        if (data["records"].length > 0) {
                            availRow = data["records"][0]["ID"];
                            $("input[name=startAvail]").val(data["records"][0]["startTime"]);
                            $("input[name=endAvail]").val(data["records"][0]["endTime"]);
                        }
                    }

                });

                $(".ApplyButton").click(function (event) {
                    let id = "<?PHP echo $_SESSION["ID"] ?>";
                    let bioInfo = $("textarea[name=bioInfo]").val();
                    $.ajax({
                        type: "POST",
                        url: "/API/Users/RequestTutorUpgrade.php",
                        data: "bioInfo=" + encodeURIComponent(bioInfo) + "&userID=" + id,
                        async: true,
                        success: function () {
                            alert("Your request to upgrade your account to Tutor was received! We will review it and get back to you asap! Please note that to make sure your account reflects these changes, we will be logging you out. Thank you!");
                            window.location = "/API/Users/Logout.php";
                        },
                        error: function (data) {
                            alert("Your request to upgrade your account to Tutor failed! Sorry about that :(...." + data);
                        }
                    });
                });

                $("input[name=startAvail").on('change', function (event) {
                    let id = "<?PHP echo $_SESSION["ID"] ?>";
                    let start = $("input[name=startAvail]").val();
                    if (availRow == 0) {
                        $.ajax({
                            type: "POST",
                            url: "/API/api.php/records/UserAvailability",
                            data: "startTime=" + start + "&endTime=00:00&UserID=" + id,
                            success: function (data) {
                                availRow = data;
                            },
                            error: function (data) {
                                alert(data);
                            },
                            async: true
                        });
                    } else {
                        $.ajax({
                            type: "PUT",
                            url: "/API/api.php/records/UserAvailability/" + availRow,
                            data: "startTime=" + start,
                            success: function (data) {

                            },
                            error: function (data) {
                                alert(data);
                            },
                            async: true
                        });
                    }
                });

                $("input[name=endAvail").on('change', function (event) {
                    let id = "<?PHP echo $_SESSION["ID"] ?>";
                    let end = $("input[name=endAvail]").val();
                    if (availRow == 0) {
                        $.ajax({
                            type: "POST",
                            url: "/API/api.php/records/UserAvailability",
                            data: "startTime=00:00&endTime=" + end + "&UserID=" + id,
                            success: function (data) {
                                availRow = data;
                            },
                            error: function (data) {
                                alert(data);
                            },
                            async: true
                        });
                    } else {
                        $.ajax({
                            type: "PUT",
                            url: "/API/api.php/records/UserAvailability/" + availRow,
                            data: "endTime=" + end,
                            success: function (data) {

                            },
                            error: function (data) {
                                alert(data);
                            },
                            async: true
                        });
                    }
                });


                $(".profilePicButton").click(function (event) {
                    let id = "<?PHP echo $_SESSION["ID"] ?>";
                    $(".profilePicPopup input[name=userID]").val(id);
                    $(".profilePicPopup").dialog(
                            {
                                title: "Upload An Profile Pic!",
                                modal: true,
                                buttons: [
                                    {
                                        text: "Upload!",
                                        icon: "ui-icon-heart",
                                        click: function () {
                                            $.ajax({
                                                xhr: function () {
                                                    var progress = $('.progress'),
                                                            xhr = $.ajaxSettings.xhr();

                                                    progress.show();

                                                    xhr.upload.onprogress = function (ev) {
                                                        if (ev.lengthComputable) {
                                                            var percentComplete = parseInt((ev.loaded / ev.total) * 100);
                                                            progress.val(percentComplete);
                                                            if (percentComplete === 100) {
                                                                progress.hide().val(0);
                                                            }
                                                        }
                                                    };

                                                    return xhr;
                                                },
                                                // Your server script to process the upload
                                                url: '/API/Files/uploadProfile.php',
                                                type: 'POST',
                                                contentType: false,
                                                cache: false,
                                                processData: false,
                                                async: false,
                                                data: new FormData($('.profilePicPopup form')[0]),

                                                success: function (data) {

                                                    $(classElem).html("Uploaded!");
                                                    window.location.href = "";
                                                },
                                                error: function (data) {
                                                    alert("Upload Failed: " + data);
                                                }
                                            });
                                            $(this).dialog("close");
                                        }
                                    }
                                ]
                            }
                    );

                });
            });




        </script>
    </body>
    <h1>About You!</h1>
    <div class='aboutYou'>
        <span class='label'>Your Name: </span><span class='data'><?PHP echo $_SESSION["Name"]; ?></span><br>
        <span class='label'>Your Email: </span><span class='data'><?PHP echo $_SESSION["Email"]; ?></span><br>
        <span class='label'>Your Rating: </span><span class='data'><?PHP
            require $_SERVER["DOCUMENT_ROOT"] . "/Include/Database.php";
            $sql = new mysqli($server, $username, $password, $database);
            if ($sql->connect_error) {
                http_response_code(500);
                die("Couldn't Connect To Database");
            }
            $stmt = $sql->query("Select AVG(Rating) as 'Rating' from Rating where UserID={$_SESSION["ID"]}");
            if ($stmt && mysqli_num_rows($stmt) != 0) {
                while ($row = $stmt->fetch_assoc()) {
                    echo $row["Rating"];
                }
            } else {
                echo "0";
            }
            ?>/5</span><br>
        <span class='label'>Account Type: </span><span class='data'><?PHP
            switch ($_SESSION["UserType"]) {
                case "1":
                    echo "Student";
                    break;
                case "2":
                    echo "Tutor";
                    break;
                case "3":
                    echo "Administrator";
                    break;
                case "4":
                    echo "Pending Tutor Upgrade";
                    break;
            }
            ?>
        </span><br>
        <span class='label'>Your Availability: </span><span class='data'><input type='time' name='startAvail'> - <input type='time' name='endAvail'></span><br>
        <span class='label'>Your Profile Pic: </span><br><?PHP echo (file_exists($_SERVER["DOCUMENT_ROOT"] . "/Images/Users/{$_SESSION[ID]}.jpg") ? "<img width='100px' src='/Images/Users/{$_SESSION[ID]}.jpg'/>" : "<p>No Image Available</p>") ?><br>
        <button class='profilePicButton'>Upload Pic</button>
    </div>
    <br><br>
    <h1>Account Upgrade</h1>
    <div class='accountUpgrade'>
        <?PHP
        if ($_SESSION["UserType"] == 1) {
            echo "<p>
            Feel like you know enough to stop learning and start teaching? Fill out this form to apply to become a tutor!
        </p>
        <textarea name='bioInfo' placeholder=\"Tell Us About You!\"></textarea><br><br>
        <button class='ApplyButton'>Apply!</button>";
        } else {
            echo "Your account is not currently eligible for upgrade.";
        }
        ?>

    </div>

    <div class='profilePicPopup'>
        <form>
            <input type='hidden' name='userID'/>
            Upload a pic!  <input type='file' name='file'/>    
        </form>
    </div>
</html>