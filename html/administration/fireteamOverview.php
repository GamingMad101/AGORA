<?php 
    session_start();
    include_once("../utilities/misc.php");
    include_once("../utilities/permissions.php");
    include_once("../utilities/fireteams.php");


    // User must be in a group with fireteamAdministration Privlilages
    if(!getPermValue($_SESSION['UserID'], "fireteamAdministration") or
        !isset($_GET['fireteamID'])
    ){
        header('Location:/administration/fireteams.php');
    };

    // Becomes true if user is an admin (not a moderator)
    // Used to show/hide certain buttons for a more intuatuve UI.
    $admin = getPermValue($_SESSION['UserID'], "fireteamAdministration");

    $fireteamInfo = getFireteamInfo($_GET['fireteamID']);
    if(!isset($fireteamInfo)){
        header('Location:/administration/fireteams.php');
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
    <title><?php echo "Overview: " . $fireteamInfo['Name']?></title>
</head>
<body>
    <?php //Include Header
        $headerTitle = "Fireteam Overview: " . $fireteamInfo['Name'];
        include("../templates/header.php");
    ?>
    <br/>
    <div>
        <h1><?php echo($fireteamInfo['Name']);?></h1>
        <table>
            <tr>
                <th colspan="2" style="text-align: left">
                    <p>Basic Information:</p>
                </th>
            </tr>
            <tr>
                <td>Parent Group</td>
                <td><?php 
                    if($fireteamInfo['ParentID']){
                        $parentInfo = getFireteamInfo($fireteamInfo['ParentID']);
                        echo "<a href='?fireteamID=" . $parentInfo['FireteamID'] . "'>" . $parentInfo['Name'] ."</a>";
                    }
                    else {
                        echo "None";
                    }
                    
                ?></td>
            </tr>
            <tr>
                <td>Members</td>
                <td><?php echo($fireteamInfo['MemberCount']) ?></td>
            </tr>
            <tr>
                <td style="vertical-align: top">Children</td>
                <td><?php
                    $children = getFireteamChildren($_GET['fireteamID']);
                    if( isset($children[0]) ){
                        foreach($children as $child){
                            echo "<a href='?fireteamID=" . $child['FireteamID'] . "'>" . $child['Name'] ."</a><br/>";
                        }
                    }
                    else{
                        echo "None";
                    }
                ?></td>
            </tr>
        </table>
        <br/>
        <h2> Fireteam Members </h2>
        <table>
            <tr>
                <th>Member Name</th>
                <th>Profile</th>
                <th></th>
            </tr>
            <?php
                $users = getFireteamMembers($_GET['fireteamID']);
                if( isset($users) ){

                    foreach($users as $user){
                        echo("<tr>");
                            echo("<td>" . $user['RankName'] . "</td>");
                            echo("<td><a href='/profile.php?UID=" . $user['UserID'] . "'>Profile</a></td>");
                            echo("<td><a href=\"#\" onclick=\"
                            if(confirm('Are you sure?')){
                                removeUserFromFireteam(" . $user['UserID'] . "," . $_GET['fireteamID'] .");
                            };
                        \"><img src='/resources/delete.png' style='height: 16px; width: 16px'/></a></td>");
                        echo("</tr>");
                    }

                }
            ?>

            <tr>
                <td colspan="5">
                    <a href='#' onclick="openPopup('addUserToFireteam')">Add user to fireteam</a>
                </td>
            </tr>
        </table>
        <?php if($admin) {
            echo "
        <br/>
        <a href=\"#\" onclick=\"
            if(confirm('Are you sure?')){
               removeFireteam(" . $_GET['fireteamID'] .");
            };
           \">Delete Fireteam</a>";
        }
        ?>
    </div>


    <!-- This is the popup for adding new users to the fireteam -->
    <div id="addUserToFireteam" class=hidden style="max-width: 500px; padding-right:10px; padding-left:10px">
        <div class=discrete>
            <h3 style="text-align:center">Add new user to the fireteam</h3>

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
            <button onclick="addUserToFireteam(<?php echo $_GET['fireteamID'];?>, geid('userID').value);">Submit</button>
            <button onclick="closePopup('addUserToFireteam')">Cancel</button>
        </div>
    </div>

</body>