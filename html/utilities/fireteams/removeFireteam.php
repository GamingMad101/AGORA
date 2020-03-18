<?php 
session_start();
include_once("../permissions.php");

function removeFireteam($FireteamID) {
    if(getPermValue($_SESSION['UserID'], "fireteamAdministration") and 
        isset($FireteamID)
    )
    {
        try{
            include("../dbConfig.php");

            $sql = $db_conn->prepare("DELETE FROM `Fireteams` WHERE `FireteamID` = ?");
            $sql->bind_param("i", $FireteamID);
            $result = $sql->execute();
            
            if(!$result){
                if($db_conn->errno == 1451){
                    return "Error: Group has children.";
                }else{
                    return  "Error:" . $db_conn->error;
                }
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

    if( isset(  $_POST['FireteamID'])   ) {
        $result = removeFireteam($_POST['FireteamID']);
        echo $result;
    }

?>