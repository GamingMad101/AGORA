<?php 
session_start();
include_once("../permissions.php");

function removeUserFromGroup($UserID, $GroupID) {
    if(getPermValue($_SESSION['UserID'], "groupAdministration") and 
        isset($UserID, $GroupID)
    )
    {
        try{
            include("../dbConfig.php");

            $sql = $db_conn->prepare("DELETE FROM `GroupUsers` WHERE `GroupUsers`.`UserID` = ? AND `GroupUsers`.`GroupID` = ?");
            $sql->bind_param("ii", $UserID, $GroupID);
            $result = $sql->execute();
            
            if(!$result){
                return "Error: " . $db_conn->error;
            } else {
                echo "Success!";
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


if( isset(  $_POST['UserID'], $_POST['GroupID']  )   ) {
    $result = removeUserFromGroup($_POST['UserID'], $_POST['GroupID']);
    echo $result;
}

?>