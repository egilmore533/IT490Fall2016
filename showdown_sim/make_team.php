#!/usr/bin/php
<?php

function makeFile($filename, $textArray)
{
	$the_file = fopen($filename, "w");
	foreach($textArray as $text)
	{
		fwrite($the_file, $text);
	}
	fclose($the_file);
}

function makeTrainerFile($trainerid)
{
	$textArray = array();
	$trainer_select = "select * from info where trainerid=$trainerid";
	$database = "Trainer";
	$resultsTrainer = makeDBSelection($trainer_select,$database);
	$filename = "";
	while($r=mysqli_fetch_array($resultsTrainer))
	{
		$filename = $r['name'].".txt";
		$linenum = 0;
		for($i = 1; $i < 7; $i++)
		{
			if($r["pokemon$i"] == "")
				break;

			$textArray[$linenum++] = $r["pokemon$i"]."\n";
			$pokemon_select = "select * from pokemoves where pokename='".$r['pokemon'.$i]."'";
                	$resultsPokemon = makeDBSelection($pokemon_select,"Trainer");
			while($r2=mysqli_fetch_array($resultsPokemon))
			{
				var_dump($r2);
				for($j = 1; $j < 5; $j++)
				{
					$textArray[$linenum++] = "-".$r2["move$j"]."\n";	
				}
				$textArray[$linenum++] = "\n";
				break;
			}
			
		}
		
	}
	makeFile($filename,$textArray);
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
	echo "Connected Succesfully\n";
	return $conn;
}

function makeDBSelection($select_statement,$database)
{
	$conn = makeDBConnection($database);
	($result = mysqli_query($conn, $select_statement)) or die (mysqli_error());
	echo "Succesful lookup\n";
	return $result;
}

makeTrainerFile(213);

?>
