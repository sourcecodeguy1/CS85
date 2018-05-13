<?php
/**
 * Created by PhpStorm.
 * User: JULIO
 * Date: 5/8/2018
 * Time: 5:52 PM
 */

// Check if the input fields are empty.
if(empty($_POST['first_name']) || empty($_POST['last_name'])){
    echo "<p>You must enter your first and last name! Click your browser's Back button to return to the Guest Book form.</p>";
}else{
    // Set variables for database connection.
    $user = "root";
    $password = "";
    $host = "localhost";

    // Connect to the database.
    $DBConnect = mysqli_connect($host, $user, $password);
    if($DBConnect === FALSE){ // Check if the connection returns false.
        echo "<p>Unable to connect to the database server.</p>" . "<p>Error code " . mysqli_errno() . ": " . mysqli_error() . "</p>";
    }else{ // Return result if it doesn't return false.

        // Initialize database name variable.
        $DBName = "guestbook";

        if(!mysqli_select_db($DBConnect,$DBName)){// Check if the database is not selected.
            $SQLstring = "CREATE DATABASE $DBName";
            $QueryResult = mysqli_query($DBConnect, $SQLstring);

            if($QueryResult === FALSE) { // Check if the query returns false. Meaning there are no records in the database.
                echo "<p>Unable to execute the query.</p>" . "<p>Error code " . mysqli_errno($DBConnect) . ": " . mysqli_error($DBConnect) . "</p>";
            }else{
                echo "<p>You are the first visitor!</p>"; // Otherwise, there is at least one record in the database.
            }
        }
        mysqli_select_db($DBConnect, $DBName); // Select the database.

        // Create visitors table.

        $TableName = "visitors";
        $SQLstring = "SHOW TABLES LIKE '$TableName'";
        $QueryResult = mysqli_query($DBConnect, $SQLstring);


        if(mysqli_num_rows($QueryResult) == 0){ // Checking if the num rows returns 0 meaning there are no rows to be return because it doesn't exist yet.
            $SQLstring = "CREATE TABLE $TableName (countID SMALLINT NOT NULL AUTO_INCREMENT PRIMARY KEY, last_name VARCHAR(40), first_name VARCHAR(40))";
            $QueryResult = mysqli_query($DBConnect, $SQLstring);
            if($QueryResult === FALSE){ // Checks to see if the result returns false. Meaning something went wrong.
                echo "<p>Unable to create the table.</p>" . "<p>Error code " . mysqli_errno($DBConnect) . ": " . mysqli_error($DBConnect) . "</p>";
            }
        }


        // Sanitize input fields.
        $LastName = stripslashes($_POST['last_name']);
        $FirstName = stripslashes($_POST['first_name']);
        $SQLstring = "INSERT INTO $TableName VALUES(NULL, '$LastName', '$FirstName')";
        $QueryResult = mysqli_query($DBConnect, $SQLstring);

        if($QueryResult === FALSE){ // Checks if last name and first are inserted into the table other wise return false.
            echo "<p>Unable to execute the query.</p>" . "<p>Error code " . mysqli_errno($DBConnect) . ": " . mysqli_error($DBConnect) . "</p>";
        }else{
            echo "<h1>Thank you for signing our guest book!</h1>"; // Data inserted successfully!!
        }

        // Close the mysql connection.
        mysqli_close($DBConnect);
    }
}

