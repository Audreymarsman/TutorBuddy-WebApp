<html>
    <head>
        <title>Tutor Buddy</title>
        <link rel="stylesheet" href="/Styles/MainStyle.css"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">

    </head>
    <body>
        <?php include $_SERVER["DOCUMENT_ROOT"] . "/Include/NavBar.php"; ?>
        <div class="assignments">
            <script src="/Scripts/Classes.js"></script>
            <h3>Uploaded Assignments</h3>
            <?php
            $id = filter_input(INPUT_GET, "id");
            $files = scandir($_SERVER["DOCUMENT_ROOT"] . "/Assignments/$id",SCANDIR_SORT_ASCENDING);
            foreach ($files as $file) {
                if($file=="." || $file==".."){
                    continue;
                }
                echo "<a href='/Assignments/$id/$file'>$file</a><br>";
            }
            ?>


        </div>
    </body>


</html>