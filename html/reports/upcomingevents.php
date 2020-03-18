<?php 
    session_start();
    include_once("../utilities/misc.php");
    include_once("../utilities/permissions.php")
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel = "stylesheet"
        type = "text/css"
        href = "/style.css" />
    <title>Upcoming Events</title>
</head>
<body>
    <?php //Include Header
        $headerTitle = "Upcoming Events";
        include("../templates/header.php");
    ?>
    <br/>

    <div>
        <h2>All upcoming events</h2>
        <p>The format [YYYY-MM-DD HH:MM:SS] is used for Date/Time values</p>
        <table>
            <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Start Date/Time</th>
                    <th>End Date/Time</th>
                    <th>Expected Attendance</th>
            </tr>
        <?php
            $events = getUpcomingEvents();
            foreach($events as $event)
            {
                echo ("
                <tr>
                    <td>". $event['OperationID'] . " </td>
                    <td>". $event['Name'] . "</td>
                    <td>". $event['StartDateTime'] ."</td>
                    <td>". $event['EndDateTime'] ."</td>
                    <td>". $event['ExpectedAttendance'] ."</td>
                <tr>");
            }
        ?>
        </table>
    </div>
</body>