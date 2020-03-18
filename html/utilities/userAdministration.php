<?php 
    function getRankList(){
        // This function is used to retrieve a list of all members of the group with a specific groupID.
        include("dbConfig.php");
    
        $sql = $db_conn->prepare("SELECT `RankID`, `Name` FROM `Ranks` ORDER BY `RankID` ASC");
        $sql->execute();
        $result = $sql->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);

        return $rows;
    }
?>
<script>
    
    function addUser(Username, Password, RankID, FirstName, LastName){
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
        xhttp.open("POST", "/utilities/userAdministration/addUser.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("Username=" + Username + "&Password=" + Password + "&RankID=" + RankID + "&FirstName=" + FirstName + "&LastName=" + LastName);
    }

    function removeUser(UserID){
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
        xhttp.open("POST", "/utilities/userAdministration/removeUser.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("UserID=" + UserID);
    }

</script>