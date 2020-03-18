<?php 
    session_start();
    include_once("../utilities/misc.php");
    include_once("../utilities/permissions.php");
    include_once("../utilities/awardManagement.php");

    // Set this permissionID to the one requires to view this page
    if(!getPermValue($_SESSION['UserID'], "awardAdministration")){
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
    <title>Award Management</title>
</head>
<body>
      <?php //Include Header
        $headerTitle = "Award Management";
        include("../templates/header.php");
    ?>
    <br/>
    <div>
        <h1>Awards</h1>
        <table>
            <tr>
                <th>Type</th>
                <th>Award Name</th>
                <th>Image</th>
            </tr>
            <?php 
                $awards = getAwards();

                foreach($awards as $award){
                    echo "<tr>";
                    echo "<td>" . $award['Type'] . "</td>";
                    echo "<td>" . $award['Name'] . "</td>";
                    echo "<td style='text-align: center'><a href='" . $award['ImageURL'] . "' target='_BLANK'><img style='max-width:60px; max-height:30px' src='" . $award['ImageURL'] . "' alt='Image for ". $award['Name'] ."' /></a></td>";
                    echo "<td><a href='./awardOverview.php?AwardID=". $award['AwardID'] ."' ><img style='max-width:16px; max-height:16px' src='/resources/modifySymbol.png' alt='Overview'/></a></td>";
                    echo "<td><a href='#' onclick='removeAward(" . $award['AwardID'] . ");'><img style='max-width:16px; max-height:16px' src='/resources/delete.png' alt='Delete'/></a></td>";
                    echo "</tr>";
                }

            ?>
            <tr>
                <td colspan=5><a href='#' onclick="openPopup('addAwardPopup')">Add Award</a></td>
            </tr>
        </table>
    </div>

    <!-- This is the popup for adding Awards -->
    <div id="addAwardPopup" class=hidden style="max-width: 500px; padding-right:10px; padding-left:10px">
        <div class=discrete>
        <br/>
        <table>
            <tr>
                <td colspan=2>
                    <p style="text-align:center">Add new Award</p>
                </td>
            </tr>
            <tr>
                <td><label for="Award_Name">Award Name<label></td>
                <td><input id="Award_Name" type="text" value=""/></td>
            </tr>
            <tr>
                <td><label for="Award_Type">Abbreviation</label></td>
                <td><select id="Award_Type">
                    <option value='Medal'>Medal</option>
                    <option value='Badge'>Badge</option>
                </select></td>    
            </tr>
            <tr>
                <td><label for="Award_Image">Image URL</label></td>
                <td><input id="Award_Image" type="text" value=""/></td>
            </tr>
        </table>
        </div>
        <div class=discrete>
            <button onclick="addAward( geid('Award_Name').value, geid('Award_Type').value, geid('Award_Image').value)">Submit</button>
            <button onclick="closePopup('addAwardPopup')">Cancel</button>
        </div>
    </div>
</body>