<?php 
function getOperations() {
    // This function is used to retrieve a list of all operations.
    include("dbConfig.php");
   
    $sql = $db_conn->prepare("SELECT `OperationID` as `ID`, `Name`, `StartDateTime`, `EndDateTime`, `ExpectedAttendance` FROM `OperationInfo` WHERE StartDateTime > (SELECT NOW())");
    $sql->execute();
    $result = $sql->get_result();
    $rows = $result->fetch_all(MYSQLI_ASSOC);

    return $rows;
}

function getOperationInfo($operationID) {
    // This function is used to retrieve a list of all information about an operation.
    include("dbConfig.php");
   
    $sql = $db_conn->prepare("SELECT `OperationID` as `ID`, `Name`, `StartDateTime`, `EndDateTime`, `ExpectedAttendance` FROM `OperationInfo` WHERE `OperationID` = ? LIMIT 1");
    $sql->bind_param("i", $operationID);  
    $sql->execute();
    $result = $sql->get_result();
    $row = $result->fetch_assoc();

    return $row;
}

function getOperationUsers($operationID) {
    // This function is used to retrieve a list of all information about an operation.
    include("dbConfig.php");
   
    $sql = $db_conn->prepare("SELECT CONCAT(`Ranks`.`Name` , ' ', `Users`.`Last Name`) as `RankName`, `OperationAttendance`.`ExpectedAttendance` as `ExpectedAttendance`, `OperationAttendance`.`RealAttendance` as `RealAttendance`, `Users`.`UserID` FROM `OperationAttendance`, `Users`, `Ranks` WHERE `OperationAttendance`.`UserID` = `Users`.`UserID` AND `Ranks`.`RankID` = `Users`.`RankID` AND `OperationAttendance`.`OperationID` = ?");
    $sql->bind_param("i", $operationID);  
    $sql->execute();
    $result = $sql->get_result();
    $rows = $result->fetch_all(MYSQLI_ASSOC);

    return $rows;
}

?>
<script>
    function addOperation(name, startDT, endDT, exAttendance){
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if(this.readyState == 4 && this.status == 200){
                alert(this.responseText);
                location.reload();
            }
            else if(this.readyState == 4 && this.status == 500){
                alert("Server Error");
            }
        }

        xhttp.open("POST", "/utilities/operations/addOperation.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("Name=" + name +"&StartDT=" + startDT + "&EndDT=" + endDT + "&exAttendance=" + exAttendance);
    }

    function updateOperation(operationID ,name, startDT, endDT, exAttendance){
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if(this.readyState == 4 && this.status == 200){
                alert(this.responseText);
                location.reload();
            }
            else if(this.readyState == 4 && this.status == 500){
                alert("Server Error");
            }
        }

        xhttp.open("POST", "/utilities/operations/updateOperation.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("OperationID="+ operationID +"&Name=" + name +"&StartDT=" + startDT + "&EndDT=" + endDT + "&exAttendance=" + exAttendance);
    }

    function removeOperation(operationID){
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if(this.readyState == 4 && this.status == 200){
                alert(this.responseText);
                location.reload();
            }
            else if(this.readyState == 4 && this.status == 500){
                alert("Server Error");
            }
        }

        xhttp.open("POST", "/utilities/operations/removeOperation.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("OperationID=" + operationID);
    }

    function addUserToOperation(OperationID, UserID, ExpectedAttendance, RealAttendance){
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if(this.readyState == 4 && this.status == 200){
                alert(this.responseText);
                location.reload();
            }
            else if(this.readyState == 4 && this.status == 500){
                alert("Server Error");
            }
        }

        xhttp.open("POST", "/utilities/operations/addUserToOperation.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("OperationID=" + OperationID +"&UserID=" + UserID + "&RealAttendance=" + RealAttendance + "&ExpectedAttendance=" + ExpectedAttendance);
    }

    function updateUserOperation(OperationID, UserID, ExpectedAttendance, RealAttendance){
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if(this.readyState == 4 && this.status == 200){
                alert(this.responseText);
                location.reload();
            }
            else if(this.readyState == 4 && this.status == 500){
                alert("Server Error");
            }
        }

        xhttp.open("POST", "/utilities/operations/updateUserOperation.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("OperationID=" + OperationID +"&UserID=" + UserID + "&RealAttendance=" + RealAttendance + "&ExpectedAttendance=" + ExpectedAttendance);
    }

    function removeUserFromOperation(OperationID, UserID){
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if(this.readyState == 4 && this.status == 200){
                alert(this.responseText);
                location.reload();
            }
            else if(this.readyState == 4 && this.status == 500){
                alert("Server Error");
            }
        }

        xhttp.open("POST", "/utilities/operations/removeUserFromOperation.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("OperationID=" + OperationID +"&UserID=" + UserID);
    }
</script>