<?php 
    function getProfileInfo($userID){
        include("./utilities/dbConfig.php");

        $sql = $db_conn->prepare("
        SELECT 
            `Users`.`First Name`, 
            `Users`.`Last Name`,
            `Ranks`.`Name` as `RankName`,
            `Ranks`.`Abbreviation`,
            `Ranks`.`ImageURL`
        FROM
            `Users`, `Ranks`
        WHERE
            `Users`.`RankID` = `Ranks`.`RankID` AND
            `Users`.`UserID` = ?
        ");
        
        $sql->bind_param("i", $_GET['UID']);
        $sql->execute();
        $result = $sql->get_result();
      
        $row = $result->fetch_assoc();
        
        return $row;
    }

    function getUserAwards($userID){
        // This function is used to retrieve a list of all operations the user was expected to attend.
        include("dbConfig.php");

        $sql = $db_conn->prepare("SELECT `Awards`.`AwardID`, `Awards`.`Name`, `Awards`.`Type`, `Awards`.`ImageURL` FROM `Awards`, `UserAwards` WHERE `Awards`.`AwardID` = `UserAwards`.`AwardID` AND `UserAwards`.`UserID` = ?");
        $sql->bind_param("i", $userID);  
        $sql->execute();
        $result = $sql->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);

        return $rows;
    }

    function getUserRecommendations($userID){
        // This function is used to retrieve a list of all operations the user was expected to attend.
        include("dbConfig.php");

        $sql = $db_conn->prepare("SELECT `Recommendations`.`RecommendationID`, `Recommendations`.`RecipientID`, `Recommendations`.`GiverID`, `Recommendations`.`PointValue`, `Recommendations`.`Description` FROM `Recommendations` WHERE `Recommendations`.`RecipientID` = ?");
        $sql->bind_param("i", $userID);  
        $sql->execute();
        $result = $sql->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);

        return $rows;
    }

    function getUserOperations($userID){
        // This function is used to retrieve a list of all operations the user was expected to attend.
        include("dbConfig.php");
    
        $sql = $db_conn->prepare("SELECT `OperationAttendance`.`ExpectedAttendance`,  `OperationAttendance`.`RealAttendance`, `OperationInfo`.`Name` as `OperationName` FROM `OperationAttendance`, `OperationInfo` WHERE `UserID` = ? AND `OperationAttendance`.`ExpectedAttendance`='Yes' AND `OperationAttendance`.`OperationID` = `OperationInfo`.`OperationID`");
        $sql->bind_param("i", $userID);  
        $sql->execute();
        $result = $sql->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);

        return $rows;
    }


    function getUserGroups($userID){
        // This function is used to retrieve a list of all groups the user is a part of.
        include("dbConfig.php");
    
        $sql = $db_conn->prepare("SELECT `Groups`.`GroupID`, `Groups`.`Name` FROM `Groups`, `GroupUsers` WHERE `GroupUsers`.`GroupID` = `Groups`.`GroupID` AND `GroupUsers`.`UserID` = ?");
        $sql->bind_param("i", $userID);  
        $sql->execute();
        $result = $sql->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);

        return $rows;
    }


    function getUserOperationCount($userID){
        // This function is used to retrieve an integer value of the amount of operations a user has attended
        include("dbConfig.php");

        $sql = $db_conn->prepare("SELECT COUNT(*) as `Value` FROM `OperationAttendance` WHERE `OperationAttendance`.`UserID` = ? AND `OperationAttendance`.`RealAttendance` = 'Yes'");
        $sql->bind_param("i", $userID);  
        $sql->execute();
        $result = $sql->get_result();
        $row = $result->fetch_assoc();

        return $row['Value'];
    }

    function getUserRecommendationSum($userID){
        // This function is used to retrieve an integer value of the amount of operations a user has attended
        include("dbConfig.php");

        $sql = $db_conn->prepare("SELECT SUM(`Recommendations`.`PointValue`) as `Value` FROM `Recommendations` WHERE `Recommendations`.`RecipientID` = ?");
        $sql->bind_param("i", $userID);  
        $sql->execute();
        $result = $sql->get_result();
        $row = $result->fetch_assoc();

        return $row['Value'];
    }
    

    function getUserRankName($userID){

        // This function is used to retrieve an integer value of the amount of operations a user has attended
        include("dbConfig.php");

        $sql = $db_conn->prepare("SELECT CONCAT(`Ranks`.`Name` , ' ', `Users`.`Last Name`) as `RankName` FROM `Users`,`Ranks` WHERE `Users`.`RankID` = `Ranks`.`RankID` AND `Users`.`UserID` = ?");
        $sql->bind_param("i", $userID);  
        $sql->execute();
        $result = $sql->get_result();
        $row = $result->fetch_assoc();

        return $row['RankName'];
    }
?>