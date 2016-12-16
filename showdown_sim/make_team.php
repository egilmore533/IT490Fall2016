#!/usr/bin/php

<?php

include "/var/lib/rpc/MySQLLib.php";

function makeFile($filename, $textArray)
{
	$the_file = fopen($filename, "w");
	foreach($textArray as $text)
	{
		fwrite($the_file, $text);
	}
	fclose($the_file);
}

function makeTrainerFile($trainerid,$trainer_num)
{
	$textArray = array();
	$trainer_select = "select * from info where trainerid=$trainerid";
	$database = "Trainer";
	$resultsTrainer = MySQLLib::makeDBSelection($trainer_select,$database);

	if($trainer_num == 1)
		$filename="trainer1.json";
	else
		$filename="trainer2.json";

	while($r=mysqli_fetch_array($resultsTrainer))
	{
		$linenum = 0;
        	$textArray[$linenum++] = "{\n";
		$textArray[$linenum++] = "\"name\": \"".$r['name']."\",\n";
		for($i = 1; $i < 7; $i++)
		{
			$pokemonid = $r["pokemon$i"."id"];

			$pokemon_select = "select * from pokemon where pokemonid=$pokemonid";
			$resultsPokemon = MySQLLib::makeDBSelection($pokemon_select,$database);

			$r2=mysqli_fetch_array($resultsPokemon);

			$textArray[$linenum++] = "\"pokemon$i\": \n";
			$textArray[$linenum++] = " { \"name\": \"".$r2['name']."\",\n";
			$textArray[$linenum++] = "   \"level\": \"".$r2['level']."\",\n";
			$move_select = "select * from moves where pokemonid=$pokemonid";

			$resultsMoves = MySQLLib::makeDBSelection($move_select,$database);

			$r3=mysqli_fetch_array($resultsMoves);
			for($j=1; $j < 5; $j++)
			{
				$text = "   \"move$j\": \"".$r3["move$j"];
				if($j + 1 >= 5)
				{
					if($i + 1 >= 7)
						$textArray[$linenum++] = $text . "\" \n}\n";
					else
						$textArray[$linenum++] = $text . "\" \n},\n";
				}
				else
					$textArray[$linenum++] = $text . "\", \n";
			}
		}
		$textArray[$linenum++] = "}\n";	
	}
	makeFile($filename,$textArray);
}

makeTrainerFile(366,1);

?>
