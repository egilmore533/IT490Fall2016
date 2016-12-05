#!/usr/bin/php

<?php

include "/var/lib/rpc/MySQLCreate.php";

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
	$resultsTrainer = MySQLLib::makeDBSelection($trainer_select,$database);
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
                	$resultsPokemon = MySQLLib::makeDBSelection($pokemon_select,"Trainer");
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

makeTrainerFile(213);

?>
