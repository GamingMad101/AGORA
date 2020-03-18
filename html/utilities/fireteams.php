<?php 

    function getRootTeams(){
        // This function is used to retrieve a list of all fireteams without parents.
        include("dbConfig.php");
    
        $sql = $db_conn->prepare("SELECT `FireteamID`, `ParentID`, `Name` FROM `Fireteams` WHERE `ParentID` IS NULL;");
        $sql->execute();
        $result = $sql->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);

        return $rows;
    }
    
    function getFireteamChildren($FireteamID) { 
        // This function is used to retrieve a list of all fireteams with a specific parent.
        include("dbConfig.php");
    
        $sql = $db_conn->prepare("SELECT `FireteamID`, `ParentID`, `Name` FROM `Fireteams` WHERE `ParentID` = ?;");
        $sql->bind_param("i", $FireteamID);
        $sql->execute();
        $result = $sql->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        
        return $rows;
    }

    function getFireteamInfo($FireteamID) { 
        // This function is used to retrieve a list of all fireteams with a specific parent.
        include("dbConfig.php");
    
        $sql = $db_conn->prepare("SELECT `Fireteams`.`FireteamID`, `Fireteams`.`ParentID`, `Fireteams`.`Name`, (SELECT COUNT(`UserID`) FROM `FireteamMembers` WHERE `FireteamMembers`.`FireteamID` = `Fireteams`.`FireteamID`) AS `MemberCount` FROM `Fireteams` WHERE `Fireteams`.`FireteamID` = ?;");
        $sql->bind_param("i", $FireteamID);
        $sql->execute();
        $result = $sql->get_result();
        $row = $result->fetch_assoc();

        return $row;
    }

    function getFireteamMembers($FireteamID) { 
        // This function is used to retrieve a list of all fireteams with a specific parent.
        include("dbConfig.php");
    
        $sql = $db_conn->prepare("SELECT 
            CONCAT((SELECT `Ranks`.`Name` FROM `Ranks` WHERE `Ranks`.`RankID` = `Users`.`RankID` LIMIT 1),' ' ,`Users`.`Last Name`) as `RankName`,
            `FireteamMembers`.`UserID` as `UserID` 
        FROM 
            `Users`,
            `FireteamMembers` 
        WHERE 
            `Users`.`UserID` = `FireteamMembers`.`UserID` AND 
            `FireteamMembers`.`FireteamID` = ?;
        ");

        $sql->bind_param("i", $FireteamID);
        $sql->execute();
        $result = $sql->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);

        return $rows;
    }
?>

<script>


    function removeFireteam(FireteamID){
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
        xhttp.open("POST", "/utilities/fireteams/removeFireteam.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("FireteamID=" + FireteamID);
    }

    function addFireteam(FireteamName, ParentID = null){
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
        xhttp.open("POST", "/utilities/fireteams/addFireteam.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        if( ParentID === null){
            xhttp.send("Name=" + FireteamName);
        } else { 
            xhttp.send("Name=" + FireteamName + "&ParentID=" + ParentID);
        }

    }

    function removeUserFromFireteam(UserID, FireteamID){
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
        xhttp.open("POST", "/utilities/fireteams/removeUserFromFireteam.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("UserID=" + UserID + "&FireteamID=" + FireteamID);    
    }


    function addUserToFireteam(FireteamID, UserID){
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
        xhttp.open("POST", "/utilities/fireteams/addUserToFireteam.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("FireteamID=" + FireteamID + "&UserID=" + UserID);    
    }


</script>