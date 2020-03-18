<?php 
session_start();
include_once("../permissions.php");

function updateUserOperation($OperationID, $UserID, $ExpectedAttendance, $RealAttendance){
    if( (   getPermValue($_SESSION['UserID'], "operationAdministration") or
            getPermValue($_SESSION['UserID'], "operationModeration")    )   and 
        isset( $OperationID, $UserID, $ExpectedAttendance, $RealAttendance ) )
    {
        try {
            include("../dbConfig.php");
            
            $sql = $db_conn->prepare("UPDATE `OperationAttendance` SET `ExpectedAttendance` = ?,`RealAttendance` = ? WHERE `OperationID` = ? AND `UserID` = ?");
            $sql->bind_param("ssii", $ExpectedAttendance, $RealAttendance, $OperationID, $UserID);
            $result = $sql->execute();

            if(!$result) {
                return ("Error: " . $db_conn->error);
            } else{
                echo "Success!";
            }
        } catch (Exception $ex){
            return "Error: " . $ex->getMessage();
        }
        finally{
            $db_conn->close();
        }


    } else {
        return "Insufficient Permissions/Invalid Input";
    } 
}

?>

<?php // Post Request Handling


if( isset($_POST['OperationID'], $_POST['UserID'], $_POST['ExpectedAttendance'], $_POST['RealAttendance']) ) {
    $result = updateUserOperation($_POST['OperationID'], $_POST['UserID'], $_POST['ExpectedAttendance'], $_POST['RealAttendance']);

    echo $result;
}

?>