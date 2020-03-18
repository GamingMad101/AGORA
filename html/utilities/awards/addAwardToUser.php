<?php
session_start();
include_once("../permissions.php");
include_once("../errorReporting.php");

function addAwardToUser($AwardID, $UserID) {
    if(getPermValue($_SESSION['UserID'], "awardAdministration") and 
        isset($AwardID, $UserID)
    )
    {
        try{
            include("../dbConfig.php");

            $sql = $db_conn->prepare("INSERT INTO `UserAwards`(`AwardID`,`UserID`) VALUES (?,?)");
            $sql->bind_param("ii", $AwardID, $UserID); 

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
if( isset(  $_POST['AwardID'], $_POST['UserID'] )  ) {
    $result = addAwardToUser($_POST['AwardID'], $_POST['UserID']);
    echo $result;
}
?>