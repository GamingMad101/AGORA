<?php 
session_start();
include_once("../permissions.php");

function addUserToFireteam($UserID, $FireteamID) {
    if(getPermValue($_SESSION['UserID'], "fireteamAdministration") and 
        isset($UserID, $FireteamID)
    )
    {
        try{
            include("../dbConfig.php");

            $sql = $db_conn->prepare("INSERT INTO `FireteamMembers`(`UserID`,`FireteamID`) VALUES(?,?)");
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
    $result = addUserToFireteam($_POST['UserID'], $_POST['FireteamID']);
    echo $result;
}

?>