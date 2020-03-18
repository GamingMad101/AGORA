<?php 
    session_start();
    include_once("../utilities/misc.php");
    include_once("../utilities/permissions.php");
    include_once("../utilities/usergroups.php");

    // User must be in a group with groupAdministration Privlilages
    if(!getPermValue($_SESSION['UserID'], "groupAdministration")){
        header('Location:/administration/');
    };

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel = "stylesheet"
        type = "text/css";
        href = "/style.css" />
    <title>User Groups</title>
</head>
<body>
    <?php //Include Header
        $headerTitle = "User Groups";
        include("../templates/header.php");
    ?>
    <br/>
    <div>
        <h1>Group List:</h1>
        <table>
            <tr>
                <th>Group ID</th>
                <th>Group Name</th>
                <th>Members</th>
            </tr>
            <?php
            $groups = getGroups();            
            
            foreach($groups as $groupinfo){
                echo "
                <tr>
                    <td>". $groupinfo['GroupID'] ."</td>
                    <td>". $groupinfo['Name']."</td>
                    <td>". $groupinfo['UserCount'] ."</td>
                    <td><a href='groupOverview.php?GroupID=" . $groupinfo['GroupID'] ."'><img src='/resources/modifySymbol.png' style='width:16px; height:16px'/></a></td>
                </tr>";
            }
            ?>
        </table>
        <a href="#" onclick="openPopup('newGroupPopup');">Add Group</a>
    </div>

    <!-- This is the popup for adding new groups -->
    <div id="newGroupPopup" class=hidden style="max-width: 500px; padding-right:10px; padding-left:10px">
        <div class=discrete>
            <h3 style="text-align:center">Add new Group</h3>
            <table>
                <tr>
                    <td><label for="newGroup_Name">Group Name </label></td>
                    <td><input id="newGroup_Name" type="text" value=""/></td>
                </tr>
            </table>
            <div class=discrete>
                <button onclick="addGroup(geid('newGroup_Name').value)">Submit</button>
                <button onclick="closePopup('newGroupPopup')">Cancel</button>
            </div>
        </div>
    </div>
</body>