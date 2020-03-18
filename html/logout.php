<?php 
// Removes all session variables and redirects to the index page.
session_start();
session_unset();
session_destroy();
header("Location: index.php");
?>