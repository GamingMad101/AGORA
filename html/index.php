<?php 
    session_start();
    include_once("./utilities/misc.php");
    include_once("./utilities/permissions.php");

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">   
    <link rel = "stylesheet"
        type = "text/css"
        href = "style.css" />
    <title>Index</title>
    <?php 
        $headerTitle = "Main Page"
    ?>
</head>
<body>
    <?php
        if(isset($_SESSION['UserID']))
        {
            include("./templates/header.php");
            // Add code here to run if user is logged in.
            include("./templates/homeLoggedIn.php");
            
            
            // Show Administration Panel if the user has access.
            if( getPermValue($_SESSION['UserID'], "administration") )
            {
                echo ("<br/>");
                include("./templates/homeAdminPanel.php");
            }

        } else {
            // Runs this code if no user is logged in.
            include("./templates/homeNotLoggedIn.php");
        }
    ?>
</body>