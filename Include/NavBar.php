<?PHP
session_start();
if (!isset($_SESSION["ID"])) {
    header("Location: https://onlinetutoring.thetechnician94.com");
    http_response_code(401);
    die();
}
?>

<div id="navBar">
    <div class="hamburger">
        <div class="bar1"></div>
        <div class="bar2"></div>
        <div class="bar3"></div>
    </div>
    <div class="slideOut">
        <div class="links">

            <?PHP
            switch ($_SESSION["UserType"]) {
                case 1:
                case 4:
                    echo "<a href='/API/Users/Logout.php'><div class='link'>Logout</div></a><hr>
            <a href = '/Pages/Profile.php'><div class='link'>Profile</div></a><hr>
            <a href = '/Pages/Dashboard.php'><div class='link'>Dashboard</div></a><hr>
            <a href = '/Pages/Tutors.php'><div class='link'>Tutors</div></a><hr>
            <a href = '/Pages/Sessions.php'><div class='link'>Sessions</div></a><hr>
            <a href = '/Pages/Classes.php'><div class='link'>Classes</div></a><hr>";
                    break;
                case 2:
                    echo "<a href='/API/Users/Logout.php'><div class='link'>Logout</div></a><hr>
            <a href = '/Pages/Profile.php'><div class='link'>Profile</div></a><hr>
            <a href = '/Pages/Dashboard.php'><div class='link'>Dashboard</div></a><hr>
            <a href = '/Pages/Sessions.php'><div class='link'>Sessions</div></a><hr>";
                    break;
                case 3:
                    echo "<a href='/API/Users/Logout.php'><div class='link'>Logout</div></a><hr>
            <a href = '/Pages/Profile.php'><div class='link'>Profile</div></a><hr>
            <a href = '/Pages/Dashboard.php'><div class='link'>Dashboard</div></a><hr>
            <a href = '/Pages/Tutors.php'><div class='link'>Tutors</div></a><hr>
            <a href = '/Pages/Sessions.php'><div class='link'>All Sessions</div></a><hr>
            <a href = '/Pages/Classes.php'><div class='link'>All Classes</div></a><hr>";
                    break;
            }
            ?>

        </div>
    </div>
</div>
<script src="/Libraries/jquery.js"></script>
<script src="/Libraries/jquery-ui/jquery-ui-1.13.2/jquery-ui.min.js"></script>

<script src="/Scripts/NavBar.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">