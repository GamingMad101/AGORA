<?php 
session_start();
include_once("../permissions.php");

if(isset($_POST['OperationID'], $_POST['UserID'])){
    fprint(removeUserFromOperation($_POST['OperationID'], $_POST['UserID']));
}


function removeUserFromOperation($OperationID, $UserID){
    if(getPermValue($_SESSION['UserID'], "operationAdministration") and isset( $OperationID, $UserID) )
    {
        try {
            include("../dbConfig.php");
            
            $sql = $db_conn->prepare("DELETE FROM `OperationAttendance` WHERE `UserID` = ? AND `OperationID` = ?");
            $sql->bind_param("ii", $UserID, $OperationID);
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