<?php 
    session_start();
    include_once("./utilities/permissions.php");
    include_once("./utilities/misc.php");
    include_once("./utilities/profiles.php");
    include_once("./utilities/recommendations.php");

    // If not the logged in user, or if user lacks viewProfiles Permission, Redirect to the index.
    /* 

    Access Logic:
                | Perm | No Perm
    isUser      | yes  |   yes
    isNotUser   | yes  |   no
    
    */
    if(
        ($_GET['UID'] != $_SESSION['UserID']) and
        !getPermValue($_SESSION['UserID'], "viewProfiles")
    ) 
    {
        header('Location:index.php');
    }

    $profileInfo = getProfileInfo($_GET['UID']);
   
    if(!isset($profileInfo)){
        header('Location:index.php');
    }

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel = "stylesheet"
        type = "text/css"
        href = "style.css" />
    <title><?php 
        if($_GET['UID'] == $_SESSION['UserID']) {
            echo "My Profile";
        } else {
            echo $profileInfo['Last Name'] . "'s Profile";
        }
    ?></title>
</head>
<body>

    <?php //Include Header
        $headerTitle = $profileInfo['RankName'] . " " . $profileInfo['Last Name'] . "'s Profile";
        include("./templates/header.php");
    ?>
    <br/>
    <div> 
        <h1><?php echo $profileInfo['First Name'], " ", $profileInfo['Last Name'];?></h1><br/>
        <h2>Information</h2>
        <table>
            <tr>
                <td>Rank</td>
                <td style="border-right-style: none">
                    <?php echo $profileInfo['RankName']?>
                </td>
                <td style="width: 32px; height: 32px; text-align: center; border-left-style: none">
                    <a href='<?php echo $profileInfo['ImageURL']?>' target="_BLANK">
                    <img 
                    src='<?php echo $profileInfo['ImageURL'] ?>'
                    style="max-height: 24px; max-width:24px"
                    />
                    </a>
                </td>
            </tr>
            <tr>
                <td>Recommendation Points</td>
                <td colspan=2><?php echo getUserRecommendationSum($_GET['UID'])?></td>
            </tr>
            <tr>
                <td>Operations Attended</td>
                <td colspan=2><?php echo getUserOperationCount($_GET['UID']) ?></td>
            </tr>
        </table>
        <br/>
        <table style="border-style:none; width: 100%">
            <tr>
                <td style="border-style:none; width:50%; height:100%">
                    <h2>Awards</h2>
                    <table>
                        <tr>
                            <th>Type</th>
                            <th>Name</th>
                            <th>Image</th>
                        </tr>
                        <?php
                            $awards = getUserAwards($_GET['UID']);

                            foreach($awards as $award){
                                echo "<tr>";
                                echo "<td>" . $award['Type'] . "</td>";
                                echo "<td>" . $award['Name'] . "</td>";
                                echo "<td><a href='" . $award['ImageURL']. "' target='_BLANK'><img src='" . $award['ImageURL'] . "' style='max-width:60px; max-height:30px'/></a></td>";
                                echo "</tr>";                                
                            }
                        ?>
                    </table>
                </td>
                
                <td style="border-style:none; width:50%; height:100%">
                    <h2>Recommendation Points</h2>
                    <table>
                        <tr>
                            <th>Giver</th>
                            <th>Point Value</th>
                            <th>Description</th>
                        </tr>
                        <?php // Populate Table 
                            $recommendations = getUserRecommendations($_GET['UID']);
                            $showDelete = getPermValue($_SESSION['UserID'],"recommendationManagement");
        
                            foreach($recommendations as $recommendation){
                                echo "<tr>";
                                    echo "<td>". getUserRankName($recommendation['GiverID']) ."</td>";
                                    echo "<td>". $recommendation['PointValue'] ."</td>";
                                    echo "<td>". $recommendation['Description'] ."</td>";
                                    if($showDelete){
                                        echo("<td><a href='#' onclick='
                                        if(confirm(\"Are you sure you want to delete this operation?\")){ 
                                        removeRecommendation(". $recommendation['RecommendationID'] .");
                                        }'><img src='/resources/delete.png' style='width:16px; height:16px' /></a></td>");
                                    }
                                echo "</tr>";
                            }
                        ?>
                        <?php // If user has permission add the show popup button.
                        if(getPermValue($_SESSION['UserID'],"recommendationManagement")){
                            echo "<tr>
                                <td colspan=4><a href='#' onclick='openPopup(\"addRecommendation\")'>Add New Reccomendation</a></td>
                            </tr>";
                        }
                        ?>
                    </table>
                </td>
            <tr>
        </table>
        <br/>
        <h2>Operation Attendance</h2>
        <table>
            <tr>
                <th>Operation Name</th>
                <th>Attendance</th>
            </tr>
            <?php 
                $operations = getUserOperations($_GET['UID']);
                
                foreach($operations as $operation){
                    echo "<tr>";
                    echo "<td>" . $operation['OperationName'] . "</td>";
                    //echo "<td>" . $operation['ExpectedAttendance'] . "</td>";
                    echo "<td>" . $operation['RealAttendance'] . "</td>";
                    echo "</tr>";
                }

            ?>
        </table>

    </div>

    <?php
    // If user has userAdministration Privilages, give them the option to delete users.
    if( getPermValue($_SESSION['UserID'], "userAdministration") or
        getPermValue($_SESSION['UserID'], "groupAdministration")
    ){
        echo "<br/>";
        echo "<div>";
        if(getPermValue($_SESSION['UserID'], "userAdministration")){
            echo "<h2>User Administration</h2><br/>";
            echo "<td><a href='#' onclick='if(confirm(\"Are you sure?\")){ removeUser(" . $_GET['UID'] . ")}'>Remove User</a></td><br/>";
        }
        if(getPermValue($_SESSION['UserID'], "groupAdministration")){
            echo "<h2>Permission Groups</h2><br/>";
            echo "<table>";
            echo "<tr> 
                <th>Group Name</th>
            </tr>";
            
            $groups = getUserGroups($_GET['UID']);
            foreach($groups as $group){
                echo "<tr>";
                echo "<td>" . $group['Name'] . "</td>";
                echo "<td><a href=/administration/groupOverview.php?GroupID=" . $group['GroupID'] ."><img src='/resources/modifySymbol.png' style='width:16px; height:16px'></a></td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        echo "</div>";
    }
    ?>

     <!-- This is the popup for updating ranks -->
     <div id="addRecommendation" class=hidden style="max-width: 500px; padding-right:10px; padding-left:10px">
        <div class=discrete>
            <br/>
            <table>
                <tr>
                    <td colspan=2>
                        <p style="text-align:center">Add Recommendation</p>
                    </td>
                </tr>
                <tr>
                    <td><label for="point_value">Point Value</label></td>
                    <td><input id="point_value" type="number" value=1 /></td>
                </tr>
                <tr>
                    <td><label for="description">Description</label></td>
                    <td><input id="description" type="text"/></td>
                </tr>
            </table>
        </div>
        <div class=discrete>
            <button onclick="addRecommendation(<?php echo $_GET['UID']?>, geid('point_value').value, geid('description').value)">Submit</button>
            <button onclick="closePopup('addRecommendation')">Cancel</button>
        </div>
    </div>

</body>
