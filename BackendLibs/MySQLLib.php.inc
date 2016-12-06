<?php

class MySQLLib 
{
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

    function makeDBSelection($select_statement,$dbconn)
    {
        ($result = mysqli_query($dbconn, $select_statement)) or die (mysqli_error($dbconn));
        return $result;
    }
}
?>