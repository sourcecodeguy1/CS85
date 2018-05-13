<?php
/**
 * Created by PhpStorm.
 * User: JULIO
 * Date: 5/8/2018
 * Time: 5:57 PM
 */

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Show Guest Book</title>
</head>
<body>
    <?php
    // Set variables for database connection.
        $user = "root";
        $password = "";
        $host = "localhost";

        // Connect to the database.
        $DBConnect = mysqli_connect($host, $user, $password);

        if($DBConnect === FALSE){
            echo "<p>Unable to connect to the database server.</p>" . "<p>Error code " . mysqli_errno() . ": " . mysqli_error() . "</p>";
        }else{
            $DBName = "guestbook";
            if(!mysqli_select_db($DBConnect, $DBName)){
                echo "<p>There are no entries in the guest book!</p>";
            }else{
                $TableName = "visitors";
                $SQLstring = "SELECT * FROM $TableName";
                $QueryResult = mysqli_query($DBConnect, $SQLstring);
                if(mysqli_num_rows($QueryResult) == 0){
                    echo "<p>There are no entries in the guest book!</p>";
                }else{
                    echo "<p>The following visitors have signed our guest book:</p>";
                    echo "<table width='100%' border='1'>";
                    echo "<tr><th>First Name</th><th>Last Name</th></tr>";
                    while($Row = mysqli_fetch_array($QueryResult)){
                        echo "<tr><td>{$Row['first_name']}</td>";
                        echo "<td>{$Row['last_name']}</td></tr>";
                    }
                }

                // Output the result
                mysqli_free_result($QueryResult);
            }
            // Close the connection.
            mysqli_close($DBConnect);
        }
    ?>
</body>
</html>
