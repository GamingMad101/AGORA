<?php
session_start();
include_once("../permissions.php");
include_once("../errorReporting.php");

function updateRank($RankID, $Name, $Abbreviation, $ImageURL) {
    if(getPermValue($_SESSION['UserID'], "rankAdministration") and 
        isset( $RankID, $Name, $Abbreviation, $ImageURL )
    )
    {
        try{
            include("../dbConfig.php");

            $sql = $db_conn->prepare("UPDATE `Ranks` SET `RankID`=?,`Name`=?,`Abbreviation`=?,`ImageURL`=? WHERE `RankID`=?");
            $sql->bind_param("isssi", $RankID, $Name, $Abbreviation, $ImageURL, $RankID); 

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
if( isset( $_POST['RankID'], $_POST['Name'] , $_POST['Abbreviation'], $_POST['ImageURL'])   ) {
    $result = updateRank($_POST['RankID'],$_POST['Name'], $_POST['Abbreviation'], $_POST['ImageURL']);
    echo $result;
}
?>