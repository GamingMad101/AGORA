<?php 
    session_start();
    include_once("../utilities/misc.php");
    include_once("../utilities/permissions.php");
 
    if(!getPermValue($_SESSION['UserID'], "administration")){
        header('Location:/');
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
    <?php //Include Header
        $headerTitle = "Administration Portal";
        include("../templates/header.php");
    ?>
    <br/>
    
    <div>
        <h1>User Administration Portal</h1>
        <list>
            <ul><a href="/reports/userlist.php">User List</a></ul>
            <ul><a href="/administration/userAdministration.php">Click Here</a></ul>
        </list>

        <h1>Group Administration</h1><br/>
        <list>
            <ul><a href="/administration/usergroups.php">Click Here</a></ul>
        </list>
        
        <h1>Operation Management</h1><br/>
        <list>
            <ul><a href="/reports/upcomingevents.php">Upcoming Events</a></ul>
            <ul><a href="/administration/operations.php">Click Here</a></ul>
        </list>

        <h1>Fireteam Management</h1><br/>
        <list>
            <ul><a href="/administration/fireteams.php">Click Here</a></ul>
        </list>

        <h1>Rank Management</h1><br/>
        <list>
            <ul><a href="/administration/rankManagement.php">Click Here</a></ul>
        </list>

        <h1>Award Management</h1><br/>
        <list>
            <ul><a href="/administration/awardManagement.php">Click Here</a></ul>
        </list>
    </div>
</body>