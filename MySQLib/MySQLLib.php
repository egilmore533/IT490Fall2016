#!/usr/bin/php
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
            echo "Connected Succesfully\n";
            return $conn;
    }

    function makeDBSelection($select_statement,$database)
    {
            $conn = self::makeDBConnection($database);
            ($result = mysqli_query($conn, $select_statement)) or die (mysqli_error());
            echo "Succesful lookup\n";
            return $result;
    }
}
?>
