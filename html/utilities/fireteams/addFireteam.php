<?php 
session_start();
include_once("../permissions.php");

function addFireteam($Name, $ParentID) {
    if(getPermValue($_SESSION['UserID'], "groupAdministration") and 
        isset($Name)
    )
    {
        try{
           
            include("../dbConfig.php");

            if(isset($ParentID)){
                $sql = $db_conn->prepare("INSERT INTO `Fireteams`(`Name`, `ParentID`) VALUES (?, ?)");
                $sql->bind_param("si", $Name, $ParentID); 
            }else {
                $sql = $db_conn->prepare("INSERT INTO `Fireteams`(`Name`) VALUES (?)");
                $sql->bind_param("s", $Name);
            }
  
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

if( isset(  $_POST['Name'] , $_POST['ParentID'])   ) {

    $result = addFireteam($_POST['Name'], $_POST['ParentID']);
    echo $result;

}else if( isset(  $_POST['Name'] )   ) {

    $result = addFireteam($_POST['Name'], null);
    echo $result;

}

?>