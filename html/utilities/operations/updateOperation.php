<?php 
session_start();
include_once("../permissions.php");
include_once("../addUserToOperation.php");

// Remove Text
ob_start();
    include_once("../misc.php");
ob_get_clean();


function updateOperation($OperationID, $Name, $StartDT,$EndDT, $ExAttendance)
{
    if( getPermValue($_SESSION['UserID'], "operationAdministration") and 
        isset($OperationID, $Name, $StartDT,$EndDT, $ExAttendance)
        )
    {   
        try{
            include("../dbConfig.php");

            $sql = $db_conn->prepare("UPDATE `OperationInfo` SET `Name`=?, `StartDateTime`=?,`EndDateTime`=?,`ExpectedAttendance`=? WHERE `OperationID` = ?");
            $sql->bind_param("ssssi", $Name, $StartDT, $EndDT, $ExAttendance, $OperationID);
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

if( isset($_POST['OperationID'], $_POST['Name'], $_POST['StartDT'], $_POST['EndDT'], $_POST['exAttendance']) ) {
    $result = updateOperation($_POST['OperationID'], $_POST['Name'], $_POST['StartDT'], $_POST['EndDT'], $_POST['exAttendance']);
    echo $result;
}

?>