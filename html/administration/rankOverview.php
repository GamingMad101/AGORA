<?php 
    session_start();
    include_once("../utilities/misc.php");
    include_once("../utilities/permissions.php");
    include_once("../utilities/rankManagement.php");


    // Set this permissionID to the one requires to view this page
    if(!getPermValue($_SESSION['UserID'], "rankAdministration")){
        header('Location:/administration/rankManagement.php');
    }

    $rankInfo = getRankInfo($_GET['RankID']);
   
    if(!isset($rankInfo)){
        header('Location:/administration/rankManagement.php');
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
        $headerTitle = "Rank Info: " . $rankInfo['Name'];
        include("../templates/header.php");
    ?>
    <br/>
    <div>
        <h1><?php echo $rankInfo['Name']?></h1>

        <table>
            <tr>
                <td>Image</td>
                <td style='text-align: center'><a href='<?php echo $rankInfo['ImageURL'] ?>' target='_BLANK'><img src='<?php echo $rankInfo['ImageURL'] ?>' style='display:inline; max-height:64px; max-width:64px'/></a></td>
            </tr>
            <tr>
                <td>Name</td>
                <td><?php echo $rankInfo['Name'] ?></td>
            </tr>
            <tr>
                <td>Abbreviation</td>
                <td><?php echo $rankInfo['Abbreviation'] ?></td>
            </tr>
            <tr>
                <td colspan=2><a href='#' onclick='openPopup("updatePopup")'>Update Info</a></td>
            </tr>
        </table>
    </div>

    <!-- This is the popup for updating ranks -->
    <div id="updatePopup" class=hidden style="max-width: 500px; padding-right:10px; padding-left:10px">
        <div class=discrete>
            <br/>
            <table>
                <tr>
                    <td colspan=2>
                        <p style="text-align:center">Update Rank Information</p>
                    </td>
                </tr>
                <tr>
                    <td><label for="rank_Name">Rank Name<label></td>
                    <td><input id="rank_Name" type="text" value="<?php echo $rankInfo['Name'] ?>"/></td>
                </tr>
                <tr>
                    <td><label for="rank_Abbreviation">Abbreviation</label></td>
                    <td><input id="rank_Abbreviation" type="text" value="<?php echo $rankInfo['Abbreviation']?>"/></td>
                </tr>
                <tr>
                    <td><label for="rank_Image">Image URL</label></td>
                    <td><input id="rank_Image" type="text" value="<?php echo $rankInfo['ImageURL']?>"/></td>
                </tr>
            </table>
        </div>
        <div class=discrete>
            <button onclick="updateRank(<?php echo $_GET['RankID']?>  , geid('rank_Name').value, geid('rank_Abbreviation').value, geid('rank_Image').value)">Submit</button>
            <button onclick="closePopup('updatePopup')">Cancel</button>
        </div>
    </div>
</body>