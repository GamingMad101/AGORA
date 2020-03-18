<?php 
session_start();
include_once("../permissions.php");

function addPermToGroup($GroupID, $PermissionID, $Value) {
    if( getPermValue($_SESSION['UserID'], "groupAdministration") and 
        isset($GroupID, $PermissionID, $Value)
    )   
    {
        try{
            include("../dbConfig.php");

            $sql = $db_conn->prepare("INSERT INTO `PermissionValues` (`PermissionValues`.`GroupID`, `PermissionValues`.`PermissionID`, `PermissionValues`.`Value`) VALUES (?,?,?) ON DUPLICATE KEY UPDATE `PermissionValues`.`Value` = ?;");
            $sql->bind_param("isii",$GroupID, $PermissionID, $Value, $Value);
            $result = $sql->execute();
            
            if(!$result){
                return "DB Error: " . $db_conn->error;
            } else {
                return "Success";
            }
        } catch(Exception $ex){
            return "Error: " . $ex->getMessage();
        } finally {
            $db_conn->close();
        }
    } else {
        return "Insufficient Permissions/Invalid Input";
    }
}
?>


<?php // Post Request Handling
if( isset(  $_POST['GroupID'], $_POST['PermissionID'], $_POST['Value']  )   ) {
    $result = addPermToGroup($_POST['GroupID'], $_POST['PermissionID'], $_POST['Value']);
    echo $result;
}

?>