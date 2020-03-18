<?php
   session_start();
   include_once("../permissions.php");
   
   function removeAward($AwardID) {
    if(getPermValue($_SESSION['UserID'], "awardAdministration") and 
        isset($AwardID)
    )
    {
        try{
           
            include("../dbConfig.php");

            $sql = $db_conn->prepare("DELETE FROM `Awards` WHERE `Awards`.`AwardID` = ?");
            $sql->bind_param("i", $AwardID); 
  
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

if( isset(  $_POST['AwardID'])   ) {
    $result = removeAward($_POST['AwardID']);
    echo $result;
}
?>
