<?php 
    session_start();
    include_once("../utilities/misc.php");
    include_once("../utilities/permissions.php");
    include_once("../utilities/operations.php");


    // User must be in a group with operationAdministration Privlilages
    if(!(getPermValue($_SESSION['UserID'], "operationAdministration") or
        getPermValue($_SESSION['UserID'], "operationModeration") 
        )){
        header('Location:/administration/');
    };

    // Becomes true if user is an admin (not a moderator)
    // Used to show/hide certain buttons for a more intuative UI.
    $admin = getPermValue($_SESSION['UserID'], "operationAdministration");

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel = "stylesheet"
        type = "text/css"
        href = "/style.css" />
    <title>Operation Administration</title>
</head>
<body>

    <?php //Include Header
        $headerTitle = "Operation Administration";
        include("../templates/header.php");
    ?>
    <br/>
    <div>
        <h1>Operation List</h1>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Expected Attendance</th>
                <th></th>
                <th></th>
            </tr>
            <?php
                $rows = getOperations();
                
                foreach($rows as $row){
                    echo("<tr>");
                        echo("<td>" . $row['ID']            . "</td>");
                        echo("<td>" . $row['Name']          . "</td>");
                        echo("<td>" . $row['StartDateTime'] . "</td>");
                        echo("<td>" . $row['EndDateTime']   . "</td>");
                        echo("<td>" . $row['ExpectedAttendance'] . "</td>");
                        echo("<td><a href='/administration/operationOverview.php?operationID=" . $row['ID'] . "'><img src='/resources/modifySymbol.png' style='width:16px; height:16px'></a></td>");
                        if($admin){
                            echo("<td><a href='#' onclick='
                            if(confirm(\"Are you sure you want to delete this operation?\")){ 
                            removeOperation(" . $row['ID'] .  ");
                            }'><img src='/resources/delete.png' style='width:16px; height:16px'></a></td>");
                        }
                    echo("</tr>");
                }
            ?>
        </table>
        <?php
        if( $admin){
            echo "<hr/>
                <a href=\"#\" onclick=\"openPopup('newOperationPopup');\">Add New Operation</a>
                ";
        }
        ?>
    </div>

    <!-- This is the popup for adding new operations -->
    <div id="newOperationPopup" class=hidden style="max-width: 500px; padding-right:10px; padding-left:10px">
        <div class=discrete>
            <h3 style="text-align:center">Add new Operation</h3>

            <label for="operation_Name">Operation Name </label>
                <input id="operation_Name" type="text" value=""/><br/>

            <p>Use the format YYYY-MM-DD HH:MM:SS for Date/Time values</p>
            <label for="operation_StartDT">Operation Start Date/Time</label>
                <input id="operation_StartDT" type="text" value=""/><br/>

            <label for="operation_EndDT">Operation Start Date/Time</label>
                <input id="operation_EndDT" type="text" value=""/><br/>

            <label for="operation_ExpectedAttendance">Expected attendance</label>
                <select id="operation_ExpectedAttendance"><br/>
                    <option value="Mandatory">Mandatory</option>
                    <option value="Optional">Optional</option>
                    <option value="None">None</option>
                </select>
        </div>
        <div class=discrete>
            <button onclick="addOperation(  geid('operation_Name').value, geid('operation_StartDT').value, geid('operation_EndDT').value, geid('operation_ExpectedAttendance').value    )">Submit</button>
            <button onclick="closePopup('newOperationPopup')">Cancel</button>
        </div>
    </div>
</body>