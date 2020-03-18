<?php 
function getGroups() {
    // This function is used to retrieve a list of all groups.
    include("dbConfig.php");
   
    $sql = $db_conn->prepare("SELECT `Groups`.`GroupID`, `Groups`.`Name`, (SELECT COUNT(`UserID`) FROM `GroupUsers` WHERE `GroupUsers`.`GroupID` = `Groups`.`GroupID`) as `UserCount` FROM `Groups` ORDER BY `GroupID` ASC");
    $sql->execute();
    $result = $sql->get_result();
    $rows = $result->fetch_all(MYSQLI_ASSOC);

    return $rows;
}

function getGroupInfo( $GroupID ) {
    // This function is used to retrieve a list of all info for one group.
    include("dbConfig.php");
   
    $sql = $db_conn->prepare("SELECT `Groups`.`GroupID`, `Groups`.`Name`, (SELECT COUNT(`UserID`) FROM `GroupUsers` WHERE `GroupUsers`.`GroupID` = `Groups`.`GroupID`) as `UserCount` FROM `Groups` WHERE `Groups`.`GroupID` = ?");
    $sql->bind_param("i", $GroupID);
    $sql->execute();
    $result = $sql->get_result();
    $row = $result->fetch_assoc();  

    return $row;
}

function getGroupUsers( $GroupID ) {
    // This function is used to retrieve a list of all members of the group with a specific groupID.
    include("dbConfig.php");
   
    $sql = $db_conn->prepare("SELECT CONCAT((SELECT `Ranks`.`Name` FROM `Ranks` WHERE `Ranks`.`RankID` = `Users`.`RankID` LIMIT 1),' ' ,`Users`.`Last Name`) as `RankName`, `Users`.`UserID` FROM `Users`, `GroupUsers` WHERE `Users`.`UserID` = `GroupUsers`.`UserID` AND `GroupUsers`.`GroupID` = ?");
    $sql->bind_param("i", $GroupID);
    $sql->execute();
    $result = $sql->get_result();
    $rows = $result->fetch_all(MYSQLI_ASSOC);

    return $rows;
}

function getPermissions() {
    // This function is used to retrieve a list of all permissions.
    include("dbConfig.php");
   
    $sql = $db_conn->prepare("SELECT `PermissionID`, `Name`, `Description` FROM `Permissions` ORDER BY `Name` ASC");
    $sql->execute();
    $result = $sql->get_result();
    $rows = $result->fetch_all(MYSQLI_ASSOC);

    return $rows;
}

?>

<script>
    function addGroup(name){
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
        xhttp.open("POST", "/utilities/usergroups/addGroup.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("Name=" + name);
    }

    function updateGroup(ID, PermissionsJSON){
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
        xhttp.open("POST", "/utilities/usergroups/addGroup.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("GroupID=" + ID + "&PermissionsJSON=" + PermissionsJSON);
    }
    
    function removeGroup(GroupID){
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
        xhttp.open("POST", "/utilities/usergroups/removeGroup.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("GroupID=" + GroupID);
    }

    function removeUserFromGroup(UserID, GroupID){
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
        xhttp.open("POST", "/utilities/usergroups/removeUserFromGroup.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("GroupID=" + GroupID + "&UserID=" + UserID);    
    }
    
    function addUserToGroup(GroupID, UserID){
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
        xhttp.open("POST", "/utilities/usergroups/addUserToGroup.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("GroupID=" + GroupID + "&UserID=" + UserID);    
    }

    function addPermToGroup(GroupID, PermissionID, Value){
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if(this.readyState == 4 && this.status == 200){
                //alert(this.responseText); // Commented out to avoid spam
                //location.reload();
                return true;
            }
            else if(this.readyState == 4 && this.status == 500){
                alert("Server Error");
                return false;
            }
        }
        xhttp.open("POST", "/utilities/usergroups/addPermToGroup.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("GroupID=" + GroupID + "&PermissionID=" + PermissionID + "&Value=" + Value);    
    }

</script>