<?php 
session_start();
include_once("../permissions.php");

// Remove Text
ob_start();
    include_once("../misc.php");
ob_get_clean();


function removeOperation($operationID)
{
    if( getPermValue($_SESSION['UserID'], "operationAdministration") and 
        isset($operationID)
        )
    {   
        try{
            include("../dbConfig.php");

            $sql = $db_conn->prepare("DELETE FROM `OperationInfo` WHERE `OperationID` = ?");
            $sql->bind_param("i", $operationID);
            $result = $sql->execute();

            if(!$result) {
                return ("Error: " . $db_conn->error);
            } else{
                echo "Success!";
            }
        } catch (Exception $ex)
        {        
            return "Error: " . $ex->getMessage(); 
        }
        finally{
            $db_conn->close();
        }
    } else {
        return "Insufficient Permissions/Invalid Input";
    } 
}
?>


<?php // Post Request Handling
    if( isset($_POST['OperationID']) ) {
        removeOperation($_POST['OperationID']);
    }
?>