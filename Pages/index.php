<?PHP
if (isset($_SESSION["ID"])) {
    header("Location: /Pages/Dashboard.php");
}
?>
<html>
    <head>
        <title>Tutor Buddy</title>
        <link rel="stylesheet" href="/Styles/MainStyle.css"/>
        <script src="/Libraries/jquery.js"></script>
        <script src="/Libraries/jquery-ui/jquery-ui-1.13.2/jquery-ui.min.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script>
            function signup() {
                $("#signupDialog").dialog(
                        {
                            title: "Signup for Tutor Buddy!",
                            modal: true,
                            buttons: [
                                {
                                    text: "Cancel",
                                    click: function () {
                                        $(this).dialog("close");
                                    }
                                }, {
                                    text: "Create Account",
                                    icon: "ui-icon-heart",
                                    click: function () {
                                        if ($("#signupDialog input[name=password]").val() !== $("#signupDialog input[name=password2]").val()) {
                                            alert("The two passwords must match");
                                            return;
                                        }
                                        $.ajax({
                                            type: "POST",
                                            url: "/API/Users/Signup.php",
                                            data: $("#signupDialog form").serialize(),
                                            success: function () {
                                                alert("Sign Up Successful! Login now!");
                                            },
                                            error: function (data) {
                                                alert("Error signing up: " + data["responseText"]);
                                            }
                                        });
                                        $(this).dialog("close");
                                    }
                                }
                            ]
                        }
                );
            }

        </script>
        <style>
            #signupDialog{
                display: none;
            }
            #signupDialog form{
                text-align:  center;
            }
            #signupDialog input{
                margin-bottom: 3px;
            }

            .parent{
                margin-top: 15%;
            }

            .left{
                width: 50%; 
                height: 100px; 
                float: left;
            }
            .left h2{
                font-size: 48px;
                font-weight: bold;
                font-family: "Arial";
            }
            .left h4{
                font-size: 24px;
                font-family: "Arial";
                font-style: italic;
            }
            .right{
                margin-left: 60%; 
                height: 150px; 
            }

            .loginForm{
                margin-left: auto;
                margin-right: auto;
                padding-top: 15px;
            }
            .loginForm input{
                padding: 5px;
                margin-bottom: 10px;
            }
            .formLabel{
                padding-right: 10px;
            }

            .loginBox{
                background-color: #ffffcc;
                border-radius: 10px;
                text-align: center;
                box-shadow: 4px 4px #ffffcc;
                border: 4px solid rgba(238,174,202,1);
                width: 300px;
                font-weight: bold;
                font-family: "Arial";
            }
            .loginBox button{
                border:2px solid rgb(238,174,202);
                background: rgba(148,187,233,1);
                border-radius: 5px;
                width: 75px;
                height: 25px;
                font-weight: bold;
            }
            .loginBox button:hover{
                cursor: pointer;
            }
            .loginBox input[type=password]{

            }

            .loginBox input[type=text]{

            }
            .loginBox input[type=submit]{
                border:2px solid rgb(238,174,202);
                background: rgba(148,187,233,1);
                border-radius: 5px;
                width: 75px;
                height: 25px;
                font-weight: bold;
            }
            .loginBox input[type=submit]:hover{
                cursor: pointer;
            }

            .loginBox hr{
                background-color: rgb(238,174,202);
                width: 90%;

            }
            .signUpBox{
                text-align: center;
                height: 30px;
            }
            .image{
                position: fixed;
                top: 10px;
                left: 10px;

            }
            .image img{
                transform: rotate(180deg);
                width: 50%;
            }

        </style>
    </head>
    <body>
        <div class="image">
            <img src="/Images/large-flower-bg.png"></img>
        </div>
        <div class="parent">
            <div class="left" > 
                <h2>Welcome to Tutor Buddy</h2>
                <h4>Transforming Education, One Click at a Time</h4>
            </div>
            <div class="right"> 
                <div class="loginBox">
                    <div class='loginForm' align="center">
                        <form action="/API/Users/Login.php?fwd=1" method="POST">
                            <input type='text' name='email' placeholder="Email"/><br/>
                            <input type='password' name='password' placeholder="Password"/><br>
                            <input class="signIn" type='submit' name='submit' value="Sign In"/>
                        </form>
                    </div>
                    <hr>
                    <div class="signUpBox">
                        <button class="signUp" onclick='signup()'>Sign Up</button>
                    </div>
                </div>
            </div>
        </div>
    </body>

    <div id='signupDialog'>
        <form>
            <input type='text' name='name' placeholder="Your Name"/><br/>
            <input type='text' name='email' placeholder="Email"/><br/>
            <input type='password' name='password' placeholder="Password"/><br>
            <input type='password' name='password2' placeholder="Retype Password"/><br>
        </form>

    </div>
</html>