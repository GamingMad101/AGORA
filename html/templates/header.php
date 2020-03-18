<div style="max-width: 1000px;height:70px; line-height:80px; border-bottom-left-radius: 0px; border-bottom-right-radius: 0px">
    <img src="/resources/logo.png" style="max-height: 70px; max-width: 100px; float:left" />
    <h1 style="padding-left: 5%"><?php echo $headerTitle ?></h1> 
</div> 
<?php 
// Checks if the user is logged in, and redirects if not.
if(!isset($_SESSION['UserID'])){
    header('Location:/');
}


?>
<div style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-top-style: none">
    <ul class="navBar">
        
        <!-- Nav Bar items (Left to right) -->
        <li class="navBar"><a class="navBar" href="/">Home</a></li>
        <li class="navBar"><a class="navBar" href="/myprofile.php">My Profile</a></li>
        <li class="navBar"><a class="navBar" href="/reports/upcomingevents.php">Upcoming Events</a></li>



        <!-- Nav Bar Items (Right to Left) -->
        <li class="navBar" style="float:right"><a class="navBar" href="/logout.php">Logout</a></li>
        <?php
        if( getPermValue($_SESSION['UserID'], "administration") )
        {   
            echo '<li class="navBar" style="float:right"><a class="navBar" href="/administration/">Admin Portal</a></li>';
        }
        ?>
    
    </ul>
</div>