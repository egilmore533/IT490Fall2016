#!/usr/bin/php
<?php

    ///MySQL Connection
	$servername = "localhost";
	$DBuser = "it490";
	$DBpass = "whoGivesaFuck!490";
	$database = "Schedule";
	$database2 = "Trainer";
	$database3 = "fightHistory";	

	//Create Connection
	$conn = new mysqli($servername, $DBuser, $DBpass, $database);
	$conn2 = new mysqli($servername, $DBuser, $DBpass, $database2);
	$conn3 = new mysqli($servername, $DBuser, $DBpass, $database3);	

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

	if($conn2->connect_error){
		die("Connection failed: " . $conn2->connect_error);
	}
	else
	{
		$s = "SELECT * FROM info";
		($result2 = mysqli_query($conn2, $s)) or die (mysqli_error());
		echo "Connected Successfully";
	}

	if($conn3->connect_error){
                die("Connection failed: " . $conn3->connect_error);
        }
        else
        {
                $h = "SELECT * FROM history";
                ($result3 = mysqli_query($conn3, $h)) or die (mysqli_error());
                echo "Connected Successfully";
        }

	//MySQL Connection

    $date = "0";
    $fightnum = "0";
    $trainer1id = "0";
    $trainer2id = "0";
    $name1 = "";
    $name2 = "";
    $fightid = 0;
		
        $hours = 8;
        $minutes = 60;
        $timestamp = $hours . ":" . $minutes . $minutes;

	while($row=mysqli_fetch_array($result))
	{
		$fightid = $row['fightid'];
		$date = $row['time'];
	}

	if($date != date("mdy"))
	{
		$sqldel = "DELETE FROM schedule";
		if($conn->query($sqldel) === TRUE)
		{
			echo "\nCleared the Schedule Database\n";
		}
		else
			echo "Error: " . $sqldel . "\n";
	}
    while($date != date("mdy"))
    {
        while($fightnum != 40)
        { 
	    $fightid += 1;

            $trainer1id = rand(1, 414);
            $trainer2id = rand(1, 414);
            
            if($trainer1id == $trainer2id)
            {
                $trainer2id -= 1;
                if($trainer2id == 0)
                    $trainer2id += 2;
            }
	
	while($row=mysqli_fetch_array($result2))
	{
		if($trainer1id == $row['trainerid'])
		{	
			echo "\nGetting Trainer Name";
			$name1 = $row['name'];
		}
	}

	($result2 = mysqli_query($conn2, $s)) or die (mysqli_error());	

	while($row2=mysqli_fetch_array($result2))
	{
		if($trainer2id == $row2['trainerid'])
		{
			echo "\nGetting Trainer Name\n";
			$name2 = $row2['name'];
		}
	}

	($result2 = mysqli_query($conn2, $s)) or die (mysqli_error());

            $date = date("mdy");
            var_dump($date);
	    var_dump($fightid);
            echo $trainer1id . " " . $name1 . "\n";
	    echo $trainer2id . " " . $name2 . "\n";
            $fightnum += 1;

        if($minutes == 60)
	{
            $hours += 1;
            $minutes = 00;
            $timestamp = $hours . ":" . $minutes . $minutes;
	}
	else
	{
            $timestamp = $hours . ":" . $minutes;
        }
            
	$sqlSchedule = "INSERT INTO schedule (fightid, trainer1, trainer1id, trainer2, trainer2id, odds, time, timestamp) VALUES ('$fightid', '$name1', '$trainer1id', '$name2', '$trainer2id', '1.0', '$date', '$timestamp')";
        
        $minutes+=15;
	
	if($conn->query($sqlSchedule) ===TRUE)
	{
		echo "New Match Scheduled!\n";
	}
	else
		echo "Error: " . $sqlSchedule . "\n";
        }
    }


?>
