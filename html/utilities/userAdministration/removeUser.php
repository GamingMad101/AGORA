<?php 
    session_start();
    include_once("../permissions.php");
    
    
    // This utility page handles the removal of user accounts.
    // Checks should be made to ensure this is intended action before this is called.
    function removeUser($UserID){
        if( getPermValue($_SESSION['UserID'], "userAdministration") and
            isset($UserID)
        ){
            try{
           
                include("../dbConfig.php");
    
                $sql = $db_conn->prepare("DELETE FROM `Users` WHERE `Users`.`UserID` = ?");
                $sql->bind_param("i", $UserID); 
             
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

<?php // Handle Post Requests

    if(isset($_POST['UserID'])){
        $result = removeUser($_POST['UserID']);
        echo $result;
    }
?>