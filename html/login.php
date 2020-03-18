<?php 
    session_start();
    include_once("./utilities/misc.php");
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel = "stylesheet"
        type = "text/css"
        href = "style.css" />
    <title>Login</title>
</head>
<?php // The code to process login attempts
    $notificationText = "";
    // Redirect the user to the main page if currently logged in.
    if( isset($_SESSION['UserID']) ) { header("Location: index.php"); }

   
    if( ( isset($_POST['username']) ) and   // If a username has been input
        ( isset($_POST['password']) ) )    // and if a password has been input 
    {   
        include("./utilities/dbConfig.php");

        $username = strtolower($_POST['username']); // makes the username case independant
        $passhash = hash("sha256", $_POST['password']); // hashes the password using a sha256 hash.

        $sql = $db_conn->prepare("SELECT UserID,`Password`,`First Name`,`Last Name` FROM `Users` WHERE Username = ? LIMIT 1 ");
        $sql->bind_param("s", $username);
        $sql->execute();
        $result = $sql->get_result();
        $row = $result->fetch_assoc();
        if(null !==($db_passhash = $row['Password']) ) {
            if( $db_passhash == $passhash ) {
                $_SESSION['FirstName'] = $row['First Name'];
                $_SESSION['LastName'] = $row['Last Name'];
                $_SESSION['UserID'] = $row['UserID'];
                $_SESSION['Username'] = $username;
                header("Location: index.php");
            } 
            else {
                $notificationText = "Invalid Credentials";
            }
        }
        else
        {
            $notificationText = "Invalid Credentials";
        }
        
        
        $db_conn->close();

    }

?>
<body>
    <div class="center" style="max-width: 250px">
        <h1> Login </h1>
        <form action="login.php" method="post">
            Username: <br/>
            <input name="username" type="text" value="<?php echo (isset ($_POST['username'])) ? $_POST['username'] : ''; ?>"> <br/>
            Password: <br/>
            <input name="password" type="password" value=""> <br/>
            <?php echo "<p class='notificationText'>$notificationText</p>"; ?>
            <input type="submit" value="Submit"> <br/>
        </form>
    </div>
</body> 