<?php 

include("errorReporting.php");


function msgBox($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
}

function getUserList() {
    include("dbConfig.php");

    $sql = $db_conn->prepare("SELECT `Users`.`username` as `Username`, `Users`.`UserID`, `Users`.`First Name`,`Users`.`Last Name`,`Ranks`.`Name` as `RankName`, `Ranks`.`Abbreviation` as `RankAbbreviation`FROM `Users`, `Ranks` WHERE `Ranks`.`RankID` = `Users`.`RankID` ORDER BY `Users`.`RankID` DESC, `Users`.`Last Name` ASC");
    $sql->execute();
    $result = $sql->get_result();
    $rows = $result->fetch_all(MYSQLI_ASSOC);

    return $rows;
}

function getUpcomingEvents() {
    include("dbConfig.php");

    $sql = $db_conn->prepare("SELECT `OperationID`, `Name`, `StartDateTime`, `EndDateTime`, `ExpectedAttendance` FROM `OperationInfo` WHERE `StartDateTime` > (SELECT NOW()) ORDER BY `StartDateTime` ASC");
    $sql->execute();
    $result = $sql->get_result();
    $rows = $result->fetch_all(MYSQLI_ASSOC);

    return $rows;
}


?>
<script> // This script handles requests to open/close popups.
        function openPopup(popupID) {
            document.getElementById(popupID).style.display = "grid";
        }

        function closePopup(popupID) {
            document.getElementById(popupID).style.display = "none";
        }

        function geid(id) {
            return document.getElementById(id)
        } 
</script>