<?php 
    session_start();
    include_once("../utilities/misc.php");
    include_once("../utilities/permissions.php");
    include_once("../utilities/awardManagement.php");


    // Set this permissionID to the one requires to view this page
    if(!getPermValue($_SESSION['UserID'], "awardAdministration")){
        header('Location:/administration/awardManagement.php');
    }

    $awardInfo = getAwardInfo($_GET['AwardID']);
   
    if(!isset($awardInfo)){
        header('Location:/administration/awardManagement.php');
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
        $headerTitle = "Award Info: " . $awardInfo['Name'];
        include("../templates/header.php");
    ?>
    <br/>
    <div>
        <h1><?php echo $awardInfo['Name']?></h1>

        <table>
            <tr>
                <td>Image</td>
                <td style='text-align: center'><a href='<?php echo $awardInfo['ImageURL'] ?>' target='_BLANK'><img src='<?php echo $awardInfo['ImageURL'] ?>' style='display:inline; max-height:150px; max-width:300px'/></a></td>
            </tr>
            <tr>
                <td>Name</td>
                <td><?php echo $awardInfo['Name'] ?></td>
            </tr>
            <tr>
                <td>Type</td>
                <td><?php echo $awardInfo['Type'] ?></td>
            </tr>
            <tr>
                <td colspan=2><a href='#' onclick='openPopup("updatePopup")'>Update Info</a></td>
            </tr>
        </table>
        <br />
        <h2>Users With this Award</h2>
        <table>
            <tr>
                <th>Name</th>
                <th>Profile Link</th>
            </tr>
            <?php 
                $users = getAwardUsers($_GET['AwardID']);

                foreach($users as $user){
                    echo "<tr>";
                    echo "<td>" . $user['RankName'] ."</td>";
                    echo "<td><a href='/profile.php?UID=" . $user['UserID'] . "'>Profile</a></td>";
                    echo("<td><a href='#' onclick='removeAwardFromUser(". $_GET['AwardID'] .",". $user['UserID'] .")'><img src='/resources/delete.png' style='height: 16px; width: 16px'/></a></td>");
                    echo "</tr>";

                }
            
            ?>
            <tr>
                <td colspan=4><a href='#' onclick='openPopup("awardPlayerPopup")'>Award to another member</a></td>
            </tr>
        </table>
    </div>

    <!-- This is the popup for updating Awards -->
    <div id="updatePopup" class=hidden style="max-width: 500px; padding-right:10px; padding-left:10px">
        <div class=discrete>
            <br/>
            <table>
                <tr>
                    <td colspan=2>
                        <p style="text-align:center">Update Award Information</p>
                    </td>
                </tr>
                <tr>
                    <td><label for="Award_Name">Award Name<label></td>
                    <td><input id="Award_Name" type="text" value="<?php echo $awardInfo['Name'] ?>"/></td>
                </tr>
                <tr>
                    <td><label for="Award_Type">Abbreviation</label></td>
                    <td><select id="Award_Type" value="<?php echo $awardInfo['Abbreviation']?>">
                        <option value='Medal'>Medal</option>
                        <option value='Badge'>Badge</option>
                    </select></td>
                </tr>
                <tr>
                    <td><label for="Award_Image">Image URL</label></td>
                    <td><input id="Award_Image" type="text" value="<?php echo $awardInfo['ImageURL']?>"/></td>
                </tr>
            </table>
        </div>
        <div class=discrete>
            <button onclick="updateAward(<?php echo $_GET['AwardID']?>  , geid('Award_Name').value, geid('Award_Type').value, geid('Award_Image').value)">Submit</button>
            <button onclick="closePopup('updatePopup')">Cancel</button>
        </div>
    </div>

    <!-- This is the popup for awarding new user -->
    <div id="awardPlayerPopup" class=hidden style="max-width: 500px; padding-right:10px; padding-left:10px">
        <div class=discrete>
            <h3 style="text-align:center">Award to a new User</h3>

            <label for="userID">User to award to</label>
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
            <button onclick="addAwardToUser(<?php echo $_GET['AwardID'];?>, geid('userID').value);">Submit</button>
            <button onclick="closePopup('awardPlayerPopup')">Cancel</button>
        </div>
    </div>

</body>