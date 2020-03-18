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
    // Used to show/hide certain buttons for a more intuatuve UI.
    $admin = getPermValue($_SESSION['UserID'], "operationAdministration");

    $operationInfo = getOperationInfo($_GET['operationID']);
    if($operationInfo == null){
        header('Location:/administration/operations.php');
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
    <title><?php echo $operationInfo['Name']?></title>
</head>
<body>
    <?php //Include Header
        $headerTitle = "Operation Overview: " . $operationInfo['Name'];
        include("../templates/header.php");
    ?>
    <br/>
    <div>
        <h1><?php echo($operationInfo['Name']);?></h1>
        <table>
            <tr>
                <th colspan="2" style="text-align: left">
                    <p>Basic Information:</p>
                </th>
            </tr>
            <tr>
                <td>Start Time</td>
                <td><?php echo($operationInfo['StartDateTime']);?></td>
            </tr>
            <tr>
                <td>End Date/Time</td>
                <td><?php echo($operationInfo['EndDateTime']);?></td>
            </tr>
            <tr>
                <td>Expected Attendance</td>
                <td><?php echo($operationInfo['ExpectedAttendance']);?></td>
            </tr>
            <?php
            if($admin) {
                echo "
            <tr>
                <td colspan=\"2\">
                    <a href='#' onclick=\"openPopup('updateOperationInfo')\">Update Operation Info</a>
                </td>
            </tr>";
            }
            ?>
        </table>
        <br/>
        <h2> Members in attendance </h2>
        <table>
            <tr>
                <th>Member Name</th>
                <th>Expected Attendance</th>
                <th>Actual Attendance</th>
                <th>Profile</th>
            </tr>
            <?php
                $users = getOperationUsers($_GET['operationID']);

                foreach($users as $user){
                    echo("<tr>");
                    echo("<td>" . $user['RankName'] . "</td>");
                    echo("<td>" . $user['ExpectedAttendance'] . "</td>");
                    echo("<td>" . $user['RealAttendance'] . "</td>");
                    echo("<td><a href='/profile.php?UID=" . $user['UserID'] . "'>Profile</a></td>");
                    echo("<td><a href='#' onclick='userID=". $user['UserID'].";openPopup(\"updateUser\");'><img src='/resources/modifySymbol.png' style='height: 16px; width: 16px'/></a></td>");
                    echo("</tr>");
                }

            ?>

            <tr>
                <td colspan="5">
                    <a href='#' onclick="openPopup('addUserToOp')">Add user to operation</a>
                </td>
            </tr>
        </table>
        <?php if($admin) {
            echo "
        <br/>
        <a href=\"#\" onclick=\"
            if(confirm('Are you sure?')){
                removeOperation(" . $_GET['operationID'] .");
            };
           \">Delete Operation</a>";
        }
        ?>
    </div>


    <!-- This is the popup for adding new users to operations -->
    <div id="addUserToOp" class=hidden style="max-width: 500px; padding-right:10px; padding-left:10px">
        <div class=discrete>
            <h3 style="text-align:center">Add new user to operation</h3>

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
            <label for="exAttendance">Expected Attendance</label>
                <select id="exAttendance"><br/>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
            <br/>
            <label for="reAttendance">Real Attendance</label>
                <select id="reAttendance"><br/>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                    <option value="Unsure">Unsure</option>
                </select>
        </div>
        <div class=discrete>
            <button onclick="addUserToOperation(<?php echo $_GET['operationID'];?>, geid('userID').value, geid('exAttendance').value, geid('reAttendance').value );">Submit</button>
            <button onclick="closePopup('addUserToOp')">Cancel</button>
        </div>
    </div>

    <!-- This is the popup for updating users information operations -->
    <div id="updateUser" class=hidden style="max-width: 500px; padding-right:10px; padding-left:10px">
    <div class=discrete>
        <h3 style="text-align:center">Update User Information</h3>
        <br/>
        <label for="exAttendanceNew">Expected Attendance</label>
            <select id="exAttendanceNew"><br/>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
        <br/>
        <label for="reAttendanceNew">Real Attendance</label>
            <select id="reAttendanceNew"><br/>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
                <option value="Unsure">Unsure</option>
            </select>
    </div>
    <div class=discrete>
        <button onclick="updateUserOperation(<?php echo $_GET['operationID'];?>, userID, geid('exAttendanceNew').value, geid('reAttendanceNew').value );">Submit</button>
        <button onclick="closePopup('updateUser')">Cancel</button>
    </div>
</div>


    <!-- This is the popup for updating Operation Information -->
    <div id="updateOperationInfo" class=hidden style="max-width: 500px; padding-right:10px; padding-left:10px">
        <div class=discrete>
            <h3 style="text-align:center">Update Operation Information</h3>

            <label for="operation_Name">Operation Name </label>
                <input id="operation_Name" type="text" value="<?php echo $operationInfo['Name']?>"/><br/>

            <p>Use the format YYYY-MM-DD HH:MM:SS for Date/Time values</p>
            <label for="operation_StartDT">Operation Start Date/Time</label>
                <input id="operation_StartDT" type="text" value="<?php echo $operationInfo['StartDateTime'] ?>"/><br/>

            <label for="operation_EndDT">Operation Start Date/Time</label>
                <input id="operation_EndDT" type="text" value="<?php echo $operationInfo['EndDateTime'] ?>"/><br/>

            <label for="operation_ExpectedAttendance">Expected attendance</label>
                <select id="operation_ExpectedAttendance"><br/>
                                                <?php // The following PHP changes the default value to the current one. ?>
                    <option value="Mandatory"   <?php if($operationInfo['ExpectedAttendance']=="Mandatory"){echo "selected";}?>>Mandatory</option>
                    <option value="Optional"    <?php if($operationInfo['ExpectedAttendance']=="Optional"){echo "selected";}?>>Optional</option>
                    <option value="None"        <?php if($operationInfo['ExpectedAttendance']=="None"){echo "selected";}?>>None</option>
                </select>
        </div>
        <div class=discrete>
            <button onclick="updateOperation( <?php echo $_GET['operationID'];?> ,geid('operation_Name').value, geid('operation_StartDT').value, geid('operation_EndDT').value, geid('operation_ExpectedAttendance').value    )">Submit</button>
            <button onclick="closePopup('updateOperationInfo')">Cancel</button>
        </div>
    </div>

</body>