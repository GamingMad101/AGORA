<?php 
    session_start();
    include_once("../utilities/misc.php");
    include_once("../utilities/permissions.php");
    include_once("../utilities/usergroups.php");


    // User must be in a group with operationAdministration Privlilages
    if(!getPermValue($_SESSION['UserID'], "groupAdministration")){
        header('Location:/administration/');
    };

    // Becomes true if user is an admin (not a moderator)
    // Used to show/hide certain buttons for a more intuatuve UI.
    $admin = getPermValue($_SESSION['UserID'], "groupAdministration");

    $groupInfo = getGroupInfo($_GET['GroupID']);
    if($groupInfo == null){
        header('Location:/administration/usergroups.php');
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
    <title>Overview: <?php echo $groupInfo['Name']?></title>
</head>
<body>
    <?php //Include Header
        $headerTitle = "Group Overview: " . $groupInfo['Name'];
        include("../templates/header.php");
    ?>
    <br/>
    <div>
        <h1><?php echo($groupInfo['Name']);?></h1>
        <table>
            <tr>
                <th colspan="2" style="text-align: left">
                    <p>Basic Information:</p>
                </th>
            </tr>
            <tr>
                <td>Group Id</td>
                <td><?php echo($groupInfo['GroupID']) ?></td>
            </tr>
            <tr>
                <td>Members</td>
                <td><?php echo($groupInfo['UserCount']) ?></td>
            </tr>
            <tr>
                <td colspan="2"><button onclick="openPopup('updateGroupPopup')">Change Permissions</button></td>
            </tr>
        </table>
        <br/>
        <h2> Group Users </h2>
        <table>
            <tr>
                <th>Member Name</th>
                <th>Profile</th>
                <th></th>
            </tr>
            <?php
                $users = getGroupUsers($_GET['GroupID']);

                foreach($users as $user){
                    echo("<tr>");
                        echo("<td>" . $user['RankName'] . "</td>");
                        echo("<td><a href='/profile.php?UID=" . $user['UserID'] . "'>Profile</a></td>");
                        echo("<td><a href=\"#\" onclick=\"
                        if(confirm('Are you sure?')){
                            removeUserFromGroup(" . $user['UserID'] . "," . $_GET['GroupID'] .");
                        };
                       \"><img src='/resources/delete.png' style='height: 16px; width: 16px'/></a></td>");
                    echo("</tr>");
                }

            ?>

            <tr>
                <td colspan="5">
                    <a href='#' onclick="openPopup('addUserToGroup')">Add user to group</a>
                </td>
            </tr>
        </table>
        <?php if($admin) {
            echo "
        <br/>
        <a href=\"#\" onclick=\"
            if(confirm('Are you sure?')){
               removeGroup(" . $_GET['GroupID'] .");
            };
           \">Delete Group</a>";
        }
        ?>
    </div>


    <!-- This is the popup for adding new users to the group -->
    <div id="addUserToGroup" class=hidden style="max-width: 500px; padding-right:10px; padding-left:10px">
        <div class=discrete>
            <h3 style="text-align:center">Add new user to group</h3>

            <label for="userID">User to add</label>
                <select id="userID"><br/>
                    <?php
                        $userlist = getUserList();

                        foreach($userlist as $user){
                            echo("<option value=" . $user['UserID']. ">" . $user['RankName'] . " " . $user['Last Name'] . "</option>");
                        }
                    ?>
                </select>
            <br/>
        </div>
        <div class=discrete>
            <button onclick="addUserToGroup(<?php echo $_GET['GroupID'];?>, geid('userID').value);">Submit</button>
            <button onclick="closePopup('addUserToGroup')">Cancel</button>
        </div>
    </div>
    
    
    <!-- This is the popup for updating group permissions -->
    <div id="updateGroupPopup" class=hidden style="max-width: 500px; padding-right:10px; padding-left:10px">
        <div class=discrete>
            <h3 style="text-align:center">Update Group</h3>
            <table>
                <tr>
                    <th>Permission</th>
                    <th>Value</th>
                </tr>
                <?php
                    $permissions = getPermissions();
                    foreach($permissions as $permission) {
                        $value;
                        if( getGroupPermValue($_GET['GroupID'], $permission['PermissionID']) ){ 
                            $value = "true";
                        } else {
                            $value = "false";
                        }
                        echo "<tr>";
                            echo "<td><label for='". $permission['PermissionID']."' title='". $permission['Description'] ."'>".$permission['Name']."</label></td>";
                            echo "<td><input class='permission' id='".$permission['PermissionID']."' type='checkbox' " . (getGroupPermValue($_GET['GroupID'], $permission['PermissionID']) ? 'checked="checked"':'') ." /></td>";
                        echo "</tr>";
                    }
                ?>
                <script>
                    function UpdatePermissions(){
                        var permissions_list = document.getElementsByClassName('permission');
                        var permissions = new Array();
                        var success = true;
                        for(var i = 0; i < permissions_list.length; i++){
                            // Bool variable is used to convert from true/false to 1/0
                            var bool = 0;
                            if(permissions_list[i].checked) { bool = 1; } 

                            addPermToGroup(<?php echo $_GET['GroupID']?>, permissions_list[i].id, bool);
                        }
                        if(success) {
                            alert("Success!");
                        }
                        location.reload();
                    }
                </script>
            </table>
        </div>
        <div class=discrete>
                <button onclick="UpdatePermissions()">Submit</button>
                <button onclick="closePopup('updateGroupPopup')">Cancel</button>
        </div>
    </div>

</body>