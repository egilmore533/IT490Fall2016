<?php

class MySQLLib 
{
    function makeConnection()
    {
	$servername = 'localhost';
	$username = 'it490';
	$password = 'whoGivesaFuck!490';

	$conn = new mysqli($servername, $username, $password);

	if($conn->connect_error)
	{
            die("Connection attempt failed: ".$conn->connect_error);
	}
	return $conn;
	
    }

    function makeSelection($select_statement, $conn)
    {
	($result = mysqli_query($conn, $select_statement)) or die (mysqli_error($conn));
        return $result;
    }

    function makeDBConnection($database)
    {
        //MySQL Connection
        $servername = "localhost";
        $DBuser = "it490";
        $DBpass = "whoGivesaFuck!490";

        //Create Connection
        $conn = new mysqli($servername, $DBuser, $DBpass, $database);

        //Check Connection
        if($conn->connect_error){
                die("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }

    function makeDBSelection($select_statement,$dbname)
    {
	$dbconn = MySQLLib::makeDBConnection($dbname);
        ($result = mysqli_query($dbconn, $select_statement)) or die (mysqli_error($dbconn));
        
        $dbconn->close();
        return $result;
    }
}
?>
