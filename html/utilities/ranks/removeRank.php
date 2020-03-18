<?php
   session_start();
   include_once("../permissions.php");
   
   function removeRank($RankID) {
    if(getPermValue($_SESSION['UserID'], "rankAdministration") and 
        isset($RankID)
    )
    {
        try{
           
            include("../dbConfig.php");

            $sql = $db_conn->prepare("DELETE FROM `Ranks` WHERE `Ranks`.`RankID` = ?");
            $sql->bind_param("i", $RankID); 
  
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

if( isset(  $_POST['RankID'])   ) {
    $result = removeRank($_POST['RankID']);
    echo $result;
}
?>
