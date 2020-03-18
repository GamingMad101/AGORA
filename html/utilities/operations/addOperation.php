<?php 
session_start();
include_once("../permissions.php");

// Remove Text
ob_start();
    include_once("../misc.php");
ob_get_clean();


function addOperation($Name, $StartDT,$EndDT, $ExAttendance)
{
    if( getPermValue($_SESSION['UserID'], "operationAdministration") and 
        isset($Name, $StartDT,$EndDT, $ExAttendance)
        )
    {   
        try{
            include("../dbConfig.php");

            $sql = $db_conn->prepare("INSERT INTO `OperationInfo`(`Name`,`StartDateTime`,`EndDateTime`,`ExpectedAttendance`) VALUES (?,?,?,?)");
            $sql->bind_param("ssss", $Name, $StartDT, $EndDT, $ExAttendance);
            $result = $sql->execute();

            if(!$result) {
                return ("Error: " . $db_conn->error);
            } else{
                // Successfully added the operation.
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


if( isset($_POST['Name'], $_POST['StartDT'], $_POST['EndDT'], $_POST['exAttendance']) ) {
    $result = addOperation($_POST['Name'], $_POST['StartDT'], $_POST['EndDT'], $_POST['exAttendance']);
    echo $result;
}

?>