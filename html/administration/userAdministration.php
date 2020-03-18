<?php 
    session_start();
    include_once("../utilities/misc.php");
    include_once("../utilities/permissions.php");
    include_once("../utilities/userAdministration.php");


    // Set this permissionID to the one requires to view this page
    if(!getPermValue($_SESSION['UserID'], "userAdministration")){
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
    <title>User Administration</title>
</head>
<body>
    <?php //Include Header
        $headerTitle = "User Administration";
        include("../templates/header.php");
    ?>
    <br/>
    <div>
        <h1>User List</h1>
        <table>
            <tr>
                <th>Rank/Name</th>
                <th>Username</th>
                <th>First Name</th>
                <th>Last Name</th>
            </tr>
            <?php
                $userList = getUserList();

                foreach($userList as $user){
                    echo "<tr>";
                    echo "<td>". $user['RankAbbreviation'] . " " . $user['Last Name'] ."</td>";
                    echo "<td>". $user['Username'] ."</td>";
                    echo "<td>". $user['First Name'] ."</td>";
                    echo "<td>". $user['Last Name'] ."</td>";
                    echo "<td><a href='/profile.php?UID=" . $user['UserID'] . "'><img src='/resources/modifySymbol.png' style='width:16px; height:16px'/></a></td>";
                    echo "<td><a href='#' onclick='if(confirm(\"Are you sure?\")){ removeUser(" . $user['UserID'] . ")}'><img src='/resources/delete.png' style='width:16px; height:16px'/></a></td>";
                    echo "</tr>";
                }

            ?>
            <tr>
                <td colspan=6><a href='#' onclick='openPopup("newUserPopup")'>Add New User</a></td>
            </tr>
        </table>
    </div>

    <!-- Add User Popup -->
    <div id="newUserPopup" class=hidden style="max-width:350px; text-align:center">
        <h3 style='text-align: center'>Add New User</h3>
        <table>
            <tr>
                <td><label for="newUser_username">Username</label></td>
                <td><input id="newUser_username" type="text" value=""/></td>
            </tr>
            <tr>
                <td><label for="newUser_password">Password</label></td>
                <td><input id="newUser_password" type="password" value=""/></td>
            </tr>
            <tr>
                <td><label for="newUser_rank">Rank</label></td>
                <td><select id="newUser_rank">
                    <?php
                        $rankList = getRankList();
                        
                        foreach($rankList as $rank){
                            echo "<option value='" . $rank['RankID'] . "'>" . $rank['Name'] . "</option>";
                        }
                    ?>   
                </select></td>
            </tr>
            <tr>
                <td><label for="newUser_firstName">First Name</label></td>
                <td><input id="newUser_firstName" type="text" value=""/></td>
            </tr>
            <tr>
                <td><label for="newUser_lastName">Last Name</label></td>
                <td><input id="newUser_lastName" type="text" value=""/></td>
            </tr>
        </table>
        <script>
            function submitForm(){
                addUser(
                    geid("newUser_username").value,
                    geid("newUser_password").value,
                    geid("newUser_rank").value,
                    geid("newUser_firstName").value,
                    geid("newUser_lastName").value
                );
            }
        </script>
        <div class=discrete>
                <button onclick="submitForm()">Submit</button>
                <button onclick="closePopup('newUserPopup')">Cancel</button>
        </div>
    </div>
</body>