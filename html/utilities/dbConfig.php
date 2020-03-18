<?php 
    /* Store your database connection details in here.
    The variables in this document are inaccessable to users of the system, 
    and can only be accessed by the server */

    $DB_Host =  "localhost";
    $DB_Username = "agoraPHP";
    $DB_Password = "nkD9uIUzStWJAqQc";
    $DB_Database = "agora";

    // Create a connection to the database
    $db_conn = new mysqli($DB_Host, $DB_Username, $DB_Password, $DB_Database);

    // Print an error Message
    if ($db_conn->connect_errno) {
        echo "Failed to connect to MySQL: (" . $db_conn->connect_errno . ") " . $db_conn->connect_error;
    }
    
?>