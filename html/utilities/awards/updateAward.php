<?php
session_start();
include_once("../permissions.php");
include_once("../errorReporting.php");

function updateAward($AwardID, $Name, $Type, $ImageURL) {
    if(getPermValue($_SESSION['UserID'], "awardAdministration") and 
        isset( $AwardID, $Name, $Type, $ImageURL )
    )
    {
        try{
            include("../dbConfig.php");

            $sql = $db_conn->prepare("UPDATE `Awards` SET `AwardID`=?,`Name`=?,`Type`=?,`ImageURL`=? WHERE `AwardID`=?");
            $sql->bind_param("isssi", $AwardID, $Name, $Type, $ImageURL, $AwardID); 

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
if( isset( $_POST['AwardID'], $_POST['Name'] , $_POST['Type'], $_POST['ImageURL'])   ) {
    $result = updateAward($_POST['AwardID'],$_POST['Name'], $_POST['Type'], $_POST['ImageURL']);
    echo $result;
}
?>