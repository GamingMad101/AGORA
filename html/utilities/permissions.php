<?php 
    function getPermValue($UserID, $PermissionID){
        /* 
        
        This function is used to test if a user has a certain permission based off a permissionID string.
        The output defaults to false, but if any group has it as true, it will override any others.

        */
        $output = false;
        $groups = getUserPermGroups($UserID);
        
        foreach($groups as $groupID){
            // Makes the output become the groups value
            $output2 = getGroupPermValue($groupID, $PermissionID);
            if($output or $output2){
                $output = true;
            }
        }
        
        return $output;
    }

    function getUserPermGroups($UserID) {
        // This function is used to retrieve an array of all the user groups are in.
        include("dbConfig.php");
       
        $sql = $db_conn->prepare("SELECT `GroupUsers`.`GroupID` FROM `GroupUsers` WHERE `GroupUsers`.`UserID` = ?");
        $sql->bind_param("i", $UserID);
        $sql->execute();
        $result = $sql->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        
        // Gets only the values of the column GroupID as an array.
        $output = array_column($rows, "GroupID");
        return $output;
    }

    function getGroupPermValue($GroupID, $PermissionID){
        // Returns the permission value for a certain group
        include("dbConfig.php");

        $sql = $db_conn->prepare("SELECT `PermissionValues`.`Value` FROM `PermissionValues` WHERE (`PermissionValues`.`GroupID` = ?) AND (`PermissionValues`.`PermissionID` = ?)");
        $sql->bind_param("is", $GroupID, $PermissionID);
        $sql->execute();
        $result = $sql->get_result();
        $row = $result->fetch_assoc();
        if($row['Value'] == 1){
            $value = true;
        }
        else{
            $value = false;
        }
        return $value;
    }
?>