<?php 
session_start();
include_once("../permissions.php");

function addGroup($GroupName) {
    if(getPermValue($_SESSION['UserID'], "groupAdministration") and 
        isset($GroupName)
    )
    {
        try{
            include("../dbConfig.php");

            $sql = $db_conn->prepare("INSERT INTO `Groups`(`Name`) VALUES (?)");
            $sql->bind_param("s", $GroupName);
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


if( isset(  $_POST['Name'] )   ) {
    $result = addGroup($_POST['Name'] );
    echo $result;
}

?>