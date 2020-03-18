<?php 



?>
<script>
    function addRecommendation(RecipientID, PointValue, Description){
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
        xhttp.open("POST", "/utilities/recommendations/addRecommendation.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("RecipientID=" + RecipientID + "&PointValue=" + PointValue + "&Description=" + Description);
    }

    function removeRecommendation(RecommendationID){
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
        xhttp.open("POST", "/utilities/recommendations/removeRecommendation.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("RecommendationID=" + RecommendationID);
    }


</script>