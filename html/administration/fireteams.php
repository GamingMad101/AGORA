<?php 
    session_start();
    include_once("../utilities/misc.php");
    include_once("../utilities/permissions.php");
    include_once("../utilities/fireteams.php");
    

    // User must be a fireteam administrator to view this page.
    if(!getPermValue($_SESSION['UserID'], "fireteamAdministration")){
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
    <title>Fireteam Management</title>
</head>
<body>
    <?php //Include Header
        $headerTitle = "Fireteam Management";
        include("../templates/header.php");
    ?>
    <br/>
    <div>
        <h1>Fireteam List</h1>
        <ul class='fireteam'>
            <?php
                $rootTeams = getRootTeams();
                foreach($rootTeams as $RTeam){
                    echoTeam($RTeam);
                }
            ?>
        </ul>

        <a href='#' onclick="openPopup('newFireteamPopup')">Add Fireteam</a>
    </div>

    <?php 

        function echoTeam($Team){
            echoTeamRow($Team);
            $children = getFireteamChildren($Team['FireteamID']);
            
            echo"<ul class='fireteam'>";
                foreach($children as $child){
                    echoTeam($child);
                }
            echo"</ul>";
        }
            
        function echoTeamRow($Team){
            echo "<a href='/administration/fireteamOverview.php?fireteamID=". $Team['FireteamID'] ."'><li>". $Team['Name'] . "</li></a>";
        }

    ?>

   <!-- This is the popup for adding new fireteams -->
   <div id="newFireteamPopup" class=hidden style="max-width: 500px; padding-right:10px; padding-left:10px">
        <div class=discrete>
            <h3 style="text-align:center">Add new fireteam</h3>
            <table>
                <tr>
                    <td><label for="newFireteam_Name">Fireteam Name </label></td>
                    <td><input id="newFireteam_Name" type="text" value=""/></td>
                </tr>
                <tr>
                    <td>Parent Team</td>
                    <td>
                    <select id="newFireteam_parentID"><br/>
                        <option>None</option>
                        <?php
                            $rootTeams = getRootTeams();
                            foreach($rootTeams as $RTeam){
                                addTeamOption($RTeam, "");
                            }
                        
                            function addTeamOption($Team, $Prefix){
                                addTeamOptionRow($Team, $Prefix);
                                $children = getFireteamChildren($Team['FireteamID']);
                                
                                $Prefix = $Prefix . "-";
                                foreach($children as $child){
                                    addTeamOption($child, $Prefix);
                                }
                            }
                                
                            function addTeamOptionRow($Team, $Prefix){
                                echo "<option value=" . $Team['FireteamID']. ">" . $Prefix . $Team['Name'] . "</option>";
                            }
                        ?>
                    </select>
                    </td>
                </tr>
            </table>
            <div class=discrete>
                <button onclick="addFireteam(geid('newFireteam_Name').value, geid('newFireteam_parentID').value);">Submit</button>
                <button onclick="closePopup('newFireteamPopup')">Cancel</button>
            </div>
        </div>
    </div>


</body>