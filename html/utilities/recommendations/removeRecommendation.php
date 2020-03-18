<?php 
session_start();
include_once("../permissions.php");

function removeRecommendation( $RecommendationID ) {
    if(getPermValue($_SESSION['UserID'], "recommendationManagement") and 
        isset(  $RecommendationID  )
    )
    {
        try{
           
            include("../dbConfig.php");

            $username_lower = strtolower($Username); // makes the username case independant
            $passhash = hash("sha256", $Password); // hashes the password using a sha256 hash    

            $sql = $db_conn->prepare("DELETE FROM `Recommendations` WHERE `RecommendationID` = ?");
            $sql->bind_param("i", $RecommendationID); 
         
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
<?php // Post Request Handling
if(isset($_POST['RecommendationID'])){
    $result = removeRecommendation($_POST['RecommendationID']);
    echo $result;
}
?>