<?php 
    function getRanks(){
        // This function is used to retrieve a list of all members of the group with a specific groupID.
        include("dbConfig.php");
    
        $sql = $db_conn->prepare("SELECT `RankID`, `Name`, `Abbreviation`, `ImageURL` FROM `Ranks` ORDER BY `RankID` ASC");
        $sql->execute();
        $result = $sql->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);

        return $rows;
    }

    function getRankInfo($RankID){
        // This function is used to retrieve a list of all members of the group with a specific groupID.
        include("dbConfig.php");
    
        $sql = $db_conn->prepare("SELECT `RankID`, `Name`, `Abbreviation`, `ImageURL` FROM `Ranks` WHERE `RankID` = ? LIMIT 1");
        $sql->bind_param("i", $RankID);
        $sql->execute();
        $result = $sql->get_result();
        $row = $result->fetch_assoc();

        return $row;
    }
?>
<script>
    function addRank(Name, Abbreviation, ImageURL){
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
        xhttp.open("POST", "/utilities/ranks/addRank.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("Name=" + Name + "&Abbreviation=" + Abbreviation + "&ImageURL=" + ImageURL);
    }

    function updateRank(RankID, Name, Abbreviation, ImageURL){
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
        xhttp.open("POST", "/utilities/ranks/updateRank.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("RankID=" + RankID +"&Name=" + Name + "&Abbreviation=" + Abbreviation + "&ImageURL=" + ImageURL);
    }

    function removeRank(RankID){
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
        xhttp.open("POST", "/utilities/ranks/removeRank.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("RankID=" + RankID);
    }
</script>