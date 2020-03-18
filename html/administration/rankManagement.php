<?php 
    session_start();
    include_once("../utilities/misc.php");
    include_once("../utilities/permissions.php");
    include_once("../utilities/rankManagement.php");

    // Set this permissionID to the one requires to view this page
    if(!getPermValue($_SESSION['UserID'], "rankAdministration")){
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
    <title>Rank Management</title>
</head>
<body>
      <?php //Include Header
        $headerTitle = "Rank Management";
        include("../templates/header.php");
    ?>
    <br/>
    <div>
        <h1>Ranks</h1>
        <table>
            <tr>
                <th>Abbreviation</th>
                <th>Rank Name</th>
                <th>Image</th>
                <th/>
                <th/>
            </tr>
            <?php 
                $ranks = getRanks();

                foreach($ranks as $rank){
                    echo "<tr>";
                    echo "<td>" . $rank['Abbreviation'] . "</td>";
                    echo "<td>" . $rank['Name'] . "</td>";
                    echo "<td style='text-align: center'><a href='" . $rank['ImageURL'] . "' target='_BLANK'><img style='max-width:24px; max-height:24px' src='" . $rank['ImageURL'] . "' alt='Image for ". $rank['Name'] ."' /></a></td>";
                    echo "<td><a href='./rankOverview.php?RankID=". $rank['RankID'] ."' ><img style='max-width:16px; max-height:16px' src='/resources/modifySymbol.png' alt='Overview'/></a></td>";
                    echo "<td><a href='#' onclick='removeRank(" . $rank['RankID'] . ");'><img style='max-width:16px; max-height:16px' src='/resources/delete.png' alt='Delete'/></a></td>";
                    echo "</tr>";
                }

            ?>
            <tr>
                <td colspan=5><a href='#' onclick="openPopup('addRankPopup')">Add Rank</a></td>
            </tr>
        </table>
    </div>

    <!-- This is the popup for adding ranks -->
    <div id="addRankPopup" class=hidden style="max-width: 500px; padding-right:10px; padding-left:10px">
        <div class=discrete>
        <br/>
        <table>
            <tr>
                <td colspan=2>
                    <p style="text-align:center">Add new Rank</p>
                </td>
            </tr>
            <tr>
                <td><label for="rank_Name">Rank Name<label></td>
                <td><input id="rank_Name" type="text" value=""/></td>
            </tr>
            <tr>
                <td><label for="rank_Abbreviation">Abbreviation</label></td>
                <td><input id="rank_Abbreviation" type="text" value=""/></td>
            </tr>
            <tr>
                <td><label for="rank_Image">Image URL</label></td>
                <td><input id="rank_Image" type="text" value=""/></td>
            </tr>
        </table>
        </div>
        <div class=discrete>
            <button onclick="addRank( geid('rank_Name').value, geid('rank_Abbreviation').value, geid('rank_Image').value)">Submit</button>
            <button onclick="closePopup('addRankPopup')">Cancel</button>
        </div>
    </div>
</body>