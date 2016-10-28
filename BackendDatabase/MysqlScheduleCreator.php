#!/usr/bin/php
<?php

    ///MySQL Connection
	$servername = "localhost";
	$DBuser = "it490";
	$DBpass = "whoGivesaFuck!490";
	$database = "Schedule";
	
	//Create Connection
	$conn = new mysqli($servername, $DBuser, $DBpass, $database);
	
	//Check Connection
	if($conn->connect_error){
		die("Connection failed: " . $conn->connect_error);
	}
	else
	{
		$s = "SELECT * FROM schedule";
		($result = mysqli_query($conn, $s)) or die (mysqli_error());
		echo "Connected Successfully";
	}
	//MySQL Connection

    $date = "0";
    $fightnum = "0";
    $trainer1id = "0";
    $trainer2id = "0";

    while($date != date("mdy"))
    {
        while($fightnum != 40)
        {
            $trainer1id = rand(1, 414);
            $trainer2id = rand(1, 414);

            if($trainer1id == $trainer2id)
            {
                $trainer2id -= 1;
                if($trainer2id == 0)
                    $trainer2id += 2;
            }

            $date = date("mdy");
            var_dump($date);
            var_dump($trainer1id);
            var_dump($trainer2id);
            $fightnum += 1;
        }
    }


?>
