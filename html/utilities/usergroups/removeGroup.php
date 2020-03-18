<?php 
session_start();
include_once("../permissions.php");

function removeGroup($GroupID) {
    if(getPermValue($_SESSION['UserID'], "groupAdministration") and 
        isset($GroupID)
    )
    {
        try{
            include("../dbConfig.php");

            $sql = $db_conn->prepare("DELETE FROM `Groups` WHERE `GroupID` = ?");
            $sql->bind_param("i", $GroupID);
            $result = $sql->execute();
            
            if(!$result){
                return "Error: " . $db_conn->error;
            } else {
                return "Success!";
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


if( isset(  $_POST['GroupID'])   ) {
    $result = removeGroup($_POST['GroupID']);
    echo $result;
}

?>