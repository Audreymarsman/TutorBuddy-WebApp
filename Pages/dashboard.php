<html>
    <head>
        <title>Online Tutoring</title>
        <link rel="stylesheet" href="/Styles/MainStyle.css"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            .studentDash{
                margin: auto;
            }
            .studentDash .column {
                float: left;
                width: 28%;
                height: 100%;
                margin-right: 10px;
                text-align: center;
            }

            .border-gradient-rounded {
                /* Border */
                border: 4px solid transparent;
                border-radius: 20px;
                background: 
                    linear-gradient(to right, rgba(255,255,255,.1), rgba(255,255,255,.1)), 
                    linear-gradient(to right, pink , white); 
                background-clip: padding-box, border-box;
                background-origin: padding-box, border-box;

                /* Other styles */
                width: 100px;
             
                padding: 12px;
            }

            /* Clear floats after the columns */
            .studentDash:after {
                content: "";
                display: table;
                clear: both;
            }
            .studentDash h4{
                font-family: "Arial"
            }
            
            #ratePopup{
                display: none;
            }
            #uploadPopup{
                display: none; 
            }
            .progress { display: none; }
        </style>
    </head>
    <body>
        <?Php
        include $_SERVER["DOCUMENT_ROOT"] . "/Include/NavBar.php";
        ?>
          <script src="/Scripts/Dashboard.js"></script>
        <div class="dashboard">
            <h1>Dashboard</h1>
            <?php
            if ($_SESSION["UserType"] == 1 || $_SESSION["UserType"] == 4) { //student
                include $_SERVER["DOCUMENT_ROOT"] . "/Include/StudentDash.php";
            } else if ($_SESSION["UserType"] == 2) { //tutor
                include $_SERVER["DOCUMENT_ROOT"] . "/Include/TutorDash.php";
            } else {//admin
                include $_SERVER["DOCUMENT_ROOT"] . "/Include/AdminDash.php";
            }
            ?>
        </div>
    </body>


</html>