<html>
    <head>
        <title>Tutor Buddy</title>
        <link rel="stylesheet" href="/Styles/MainStyle.css"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">

    </head>
    <body>
        <?php
        include $_SERVER["DOCUMENT_ROOT"] . "/Include/NavBar.php";

        switch ($_SESSION["UserType"]) {
            case 1:
            case 4:
                include $_SERVER["DOCUMENT_ROOT"] . "/Include/StudentSessions.php";
                break;
            case 2:
                include $_SERVER["DOCUMENT_ROOT"] . "/Include/TutorSessions.php";
                break;
            case 3:
                echo "Uh oh! You shouldn't be here";
                break;
        }
        ?>

    </body>


</html>