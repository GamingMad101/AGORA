<?php 
session_start();
include_once("../permissions.php");

function removeUserFromFireteam($UserID, $FireteamID) {
    if(getPermValue($_SESSION['UserID'], "fireteamAdministration") and 
        isset($UserID, $FireteamID)
    )
    {
        try{
            include("../dbConfig.php");

            $sql = $db_conn->prepare("DELETE FROM `FireteamMembers` WHERE `FireteamMembers`.`UserID` = ? AND `FireteamMembers`.`FireteamID` = ?");
            $sql->bind_param("ii", $UserID, $FireteamID);
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


if( isset(  $_POST['UserID'], $_POST['FireteamID']  )   ) {
    $result = removeUserFromFireteam($_POST['UserID'], $_POST['FireteamID']);
    echo $result;
}

?>