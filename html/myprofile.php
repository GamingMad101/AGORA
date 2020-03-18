<?php 
    session_start();
    // Redirects to user profile based off session UserID
    header("Location:profile.php?UID=" . $_SESSION['UserID']);
?>