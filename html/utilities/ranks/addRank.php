<?php
session_start();
include_once("../permissions.php");
include_once("../errorReporting.php");

function addRank($Name, $Abbreviation, $ImageURL) {
    if(getPermValue($_SESSION['UserID'], "rankAdministration") and 
        isset($Name, $Abbreviation, $ImageURL)
    )
    {
        try{
            include("../dbConfig.php");

            $sql = $db_conn->prepare("INSERT INTO `Ranks`(`Name`, `Abbreviation`, `ImageURL`) VALUES (?,?,?)");
            $sql->bind_param("sss", $Name, $Abbreviation, $ImageURL); 

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
if( isset(  $_POST['Name'] , $_POST['Abbreviation'], $_POST['ImageURL'])   ) {
    $result = addRank($_POST['Name'], $_POST['Abbreviation'], $_POST['ImageURL']);
    echo $result;
}
?>