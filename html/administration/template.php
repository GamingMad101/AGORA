<?php 
    session_start();
    include_once("../utilities/misc.php");
    include_once("../utilities/permissions.php");


    // Set this permissionID to the one requires to view this page
    if(!getPermValue($_SESSION['UserID'], "viewTemplate")){
        header('Location:/administration/');
    }

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel = "stylesheet"
        type = "text/css"
        href = "/style.css" />
    <title>Template</title>
</head>
<body>
    <?php // SQL command
    if(false){
        include("../utilities/dbConfig.php");

        $sql = $db_conn->prepare("SQL COMMAND GOES HERE");
        $sql->bind_param("i", $_GET['UID']);
        $sql->execute();
        $result = $sql->get_result();
      
        $row = $result->fetch_assoc();
    
    }
    ?>
    <?php //Include Header
        $headerTitle = "Template";
        include("../templates/header.php");
    ?>
    <br/>
    <div>
        <h1>Title Goes Here</h1>
        <p>Content Goes Here</p>
    </div>
</body>