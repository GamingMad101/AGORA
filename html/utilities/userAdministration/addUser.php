<?php 
session_start();
include_once("../permissions.php");

function addUser( $Username, $Password, $RankID, $FirstName, $LastName ) {
    if(getPermValue($_SESSION['UserID'], "userAdministration") and 
        isset( $Username, $Password, $RankID, $FirstName, $LastName )
    )
    {
        try{
           
            include("../dbConfig.php");

            $username_lower = strtolower($Username); // makes the username case independant
            $passhash = hash("sha256", $Password); // hashes the password using a sha256 hash    

            $sql = $db_conn->prepare("INSERT INTO `Users`(`RankID`, `Username`, `Password`, `First Name`, `Last Name`) VALUES (?,?,?,?,?)");
            $sql->bind_param("issss", $RankID, $username_lower, $passhash, $FirstName, $LastName); 
         
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
if(isset($_POST['Username'], $_POST['Password'], $_POST['RankID'], $_POST['FirstName'], $_POST['LastName'])){
    $result = addUser($_POST['Username'], $_POST['Password'], $_POST['RankID'], $_POST['FirstName'], $_POST['LastName']);
    echo $result;
}
?>