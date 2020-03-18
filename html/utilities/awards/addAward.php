<?php
session_start();
include_once("../permissions.php");
include_once("../errorReporting.php");

function addAward($Name, $Type, $ImageURL) {
    if(getPermValue($_SESSION['UserID'], "awardAdministration") and 
        isset($Name, $Type, $ImageURL)
    )
    {
        try{
            include("../dbConfig.php");

            $sql = $db_conn->prepare("INSERT INTO `Awards`(`Name`, `Type`, `ImageURL`) VALUES (?,?,?)");
            $sql->bind_param("sss", $Name, $Type, $ImageURL); 

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
if( isset(  $_POST['Name'] , $_POST['Type'], $_POST['ImageURL'])   ) {
    $result = addAward($_POST['Name'], $_POST['Type'], $_POST['ImageURL']);
    echo $result;
}
?>