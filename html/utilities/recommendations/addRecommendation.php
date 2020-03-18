<?php 
session_start();
include_once("../permissions.php");

function addRecommendation( $RecipientID, $PointValue, $Description ) {
    if(getPermValue($_SESSION['UserID'], "recommendationManagement") and 
        isset(  $RecipientID, $PointValue, $Description  )
    )
    {
        try{
           
            include("../dbConfig.php");

            $username_lower = strtolower($Username); // makes the username case independant
            $passhash = hash("sha256", $Password); // hashes the password using a sha256 hash    

            $sql = $db_conn->prepare("INSERT INTO `Recommendations`(`GiverID`, `RecipientID`, `PointValue`, `Description`) VALUES (?,?,?,?)");
            $sql->bind_param("iiss", $_SESSION['UserID'], $RecipientID, $PointValue, $Description); 
         
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
if(isset($_POST['RecipientID'], $_POST['PointValue'], $_POST['Description'])){
    $result = addRecommendation($_POST['RecipientID'], $_POST['PointValue'], $_POST['Description']);
    echo $result;
}
?>