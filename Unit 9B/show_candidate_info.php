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
    $DBName = "register_candidate";
    if(!mysqli_select_db($DBConnect, $DBName)){
        echo "<p>There are no candidates registered!</p>";
    }else{
        $TableName = "registered_candidates";
        $SQLstring = "SELECT * FROM $TableName";
        $QueryResult = mysqli_query($DBConnect, $SQLstring);
        if(mysqli_num_rows($QueryResult) == 0){
            echo "<p>There are no candidates registered at the moment!</p>";
        }else{
            echo "<p>The following candidates are registered:</p>";
            echo "<table width='100%' border='1'>";
            echo "<tr><th>Interviewer&#039;s name</th><th>Position</th><th>Date of interview</th><th>Candidate&#039;s Name</th><th>Communication Abilities</th><th>Professional Appearance</th><th>Computer Skills</th><th>Business Knowledge</th><th>Interviewer&#039;s Comment</th></tr>";
            while($row = mysqli_fetch_array($QueryResult)){
                echo "<tr><td>{$row['iname']}</td>";
                echo "<td>{$row['pos']}</td>";
                echo "<td>{$row['dofin']}</td>";
                echo "<td>{$row['cdname']}</td>";
                echo "<td>{$row['cabilities']}</td>";
                echo "<td>{$row['papp']}</td>";
                echo "<td>{$row['compskill']}</td>";
                echo "<td>{$row['bkno']}</td>";
                echo "<td>{$row['icomm']}</td></tr>";
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
