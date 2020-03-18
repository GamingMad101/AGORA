<?php 
    function getAwards(){
        // This function is used to retrieve a list of all members of the group with a specific groupID.
        include("dbConfig.php");
    
        $sql = $db_conn->prepare("SELECT `AwardID`, `Name`, `Type`, `ImageURL` FROM `Awards` ORDER BY `Type` DESC, `Name` ASC");
        $sql->execute();
        $result = $sql->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);

        return $rows;
    }

    function getAwardInfo($AwardID){
        // This function is used to retrieve a list of all members of the group with a specific groupID.
        include("dbConfig.php");
    
        $sql = $db_conn->prepare("SELECT `AwardID`, `Name`, `Type`, `ImageURL` FROM `Awards` WHERE `AwardID` = ?");
        $sql->bind_param("i", $AwardID);
        $sql->execute();
        $result = $sql->get_result();
        $row = $result->fetch_assoc();

        return $row;
    }

    function getAwardUsers($AwardID){
        // This function is used to retrieve a list of all members of the group with a specific groupID.
        include("dbConfig.php");
    
        $sql = $db_conn->prepare("SELECT CONCAT(`Ranks`.`Name` , ' ', `Users`.`Last Name`) as `RankName`, `Users`.`UserID` FROM `Users`, `Ranks`, `UserAwards` WHERE `Users`.`UserID` = `UserAwards`.`UserID` AND `Ranks`.`RankID` = `Users`.`RankID` AND `UserAwards`.`AwardID` = ?");
        $sql->bind_param("i", $AwardID);
        $sql->execute();
        $result = $sql->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);

        return $rows;
    }



?>
<script>
    function addAward(Name, Type, ImageURL){
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
        xhttp.open("POST", "/utilities/awards/addAward.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("Name=" + Name + "&Type=" + Type + "&ImageURL=" + ImageURL);
    }

    function updateAward(AwardID, Name, Type, ImageURL){
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
        xhttp.open("POST", "/utilities/awards/updateAward.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("AwardID=" + AwardID +"&Name=" + Name + "&Type=" + Type + "&ImageURL=" + ImageURL);
    }

    function removeAward(AwardID){
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
        xhttp.open("POST", "/utilities/awards/removeAward.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("AwardID=" + AwardID);
    }
    function addAwardToUser(AwardID, UserID){
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
        xhttp.open("POST", "/utilities/awards/addAwardToUser.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("AwardID=" + AwardID + "&UserID=" + UserID);
    }

    function removeAwardFromUser(AwardID, UserID){
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
        xhttp.open("POST", "/utilities/awards/removeAwardFromUser.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("AwardID=" + AwardID + "&UserID=" + UserID);
    }
</script>