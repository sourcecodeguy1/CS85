<?php
/**
 * Created by PhpStorm.
 * User: JULIO
 * Date: 5/8/2018
 * Time: 5:52 PM
 */

// Check if the input fields are empty.
if(empty($_POST['iname']) || empty($_POST['pos']) || empty($_POST['dofin']) || empty($_POST['cdname']) || empty($_POST['cabilities']) || empty($_POST['papp']) || empty($_POST['compskill']) || empty($_POST['bkno']) || empty($_POST['icomm'])){
    echo "<p>You must complete all form input fields! Click your browser's Back button to return to the registration form.</p>";
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
        $DBName = "register_candidate";

        if(!mysqli_select_db($DBConnect,$DBName)){// Check if the database is not selected.
            $SQLstring = "CREATE DATABASE $DBName";
            $QueryResult = mysqli_query($DBConnect, $SQLstring);

            if($QueryResult === FALSE) { // Check if the query returns false. Meaning there are no records in the database.
                echo "<p>Unable to execute the query.</p>" . "<p>Error code " . mysqli_errno($DBConnect) . ": " . mysqli_error($DBConnect) . "</p>";
            }else{
                echo "<p>You are the first candidate to be registered!</p>"; // Otherwise, there is at least one record in the database.
            }
        }
        mysqli_select_db($DBConnect, $DBName); // Select the database.

        // Create visitors table.

        $TableName = "registered_candidates";
        $SQLstring = "SHOW TABLES LIKE '$TableName'";
        $QueryResult = mysqli_query($DBConnect, $SQLstring);


        if(mysqli_num_rows($QueryResult) == 0){ // Checking if the num rows returns 0 meaning there are no rows to be return because it doesn't exist yet.
            $SQLstring = "CREATE TABLE $TableName (
                                                    candidateID SMALLINT NOT NULL AUTO_INCREMENT PRIMARY KEY, 
                                                    iname VARCHAR(40), pos VARCHAR(40),
                                                    dofin VARCHAR(40), cdname VARCHAR(40),
                                                    cabilities VARCHAR(40), papp VARCHAR(40),
                                                    compskill VARCHAR(40), bkno VARCHAR(40),
                                                    icomm VARCHAR(40))";
            $QueryResult = mysqli_query($DBConnect, $SQLstring);
            if($QueryResult === FALSE){ // Checks to see if the result returns false. Meaning something went wrong.
                echo "<p>Unable to create the table.</p>" . "<p>Error code " . mysqli_errno($DBConnect) . ": " . mysqli_error($DBConnect) . "</p>";
            }
        }


        // Sanitize input fields.
        $interviewer_name = stripslashes($_POST['iname']);
        $position = stripslashes($_POST['pos']);
        $date_of_interview = stripslashes($_POST['dofin']);
        $candidates_name = stripslashes($_POST['cdname']);
        $communicationab = stripslashes($_POST['cabilities']);
        $professionalap = stripslashes($_POST['papp']);
        $compskills = stripslashes($_POST['compskill']);
        $businessknd = stripslashes($_POST['bkno']);
        $inter_comment = stripslashes($_POST['icomm']);

        $SQLstring = "INSERT INTO $TableName VALUES(NULL, '$interviewer_name', '$position', '$date_of_interview', '$candidates_name', '$communicationab', '$professionalap', '$compskills', '$businessknd', '$inter_comment')";
        $QueryResult = mysqli_query($DBConnect, $SQLstring);

        if($QueryResult === FALSE){ // Checks if last name and first are inserted into the table other wise return false.
            echo "<p>Unable to execute the query.</p>" . "<p>Error code " . mysqli_errno($DBConnect) . ": " . mysqli_error($DBConnect) . "</p>";
        }else{
            echo "<h1>Thank you for registering!</h1>"; // Data inserted successfully!!
        }

        // Close the mysql connection.
        mysqli_close($DBConnect);
    }
}

