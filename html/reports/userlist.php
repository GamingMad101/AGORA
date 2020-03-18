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
    <title>Template</title>
</head>
<body>
    <?php //Include Header
        $headerTitle = "User List";
        include("../templates/header.php");
    ?>
    <br/>

    <div>
        <h2>All users by rank:</h2>
        <table>
            <tr>
                <th> Username </th>
                <th> First Name </th>
                <th> Last Name </th>
                <th> Rank</th>
                <?php 
                            
                    if($viewProfiles = getPermValue($_SESSION['UserID'], "viewProfiles")){
                        echo "<th> Profile Link </th>";
                    }
                ?>
            </tr>
        <?php
            $userlist = getUserList();
            foreach($userlist as $user)
            {
                echo ("
                <tr>
                    <td>" . $user['Username'] . " </td>
                    <td>". $user['First Name'] . "</td>
                    <td>". $user['Last Name'] ."</td>
                    <td>". $user['RankName'] ."</td>");

                if($viewProfiles){
                    echo "<td><a href='/profile.php?UID=" . $user['UserID'] . "'> User Profile</a></td>";
                }

                echo "</tr>";
            }
        ?>
        </table>
    </div>
</body>