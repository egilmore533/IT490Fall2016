#!/usr/bin/php
<?php
include 'move_data_collection.php';
include '/var/lib/rpc/MySQLLib.php';


$pokemonid = 0;
$trainerid = 0;

$pokemon_type_table = array();

$start_url = 'Walkthrough';
$url_base = 'http://strategywiki.org/wiki/Pok%C3%A9mon_FireRed_and_LeafGreen/';

$url_data = file_get_contents($url_base . $start_url);

//this will gain the web addresses for the entire walktrough
$url_locations_regex = '/<div style="-moz-col(.+)<div style="/sU';
$url_table_regex = '/href="\/wiki\/Pok%C3%A9mon_FireRed_and_LeafGreen\/(.+)" title/U';
preg_match($url_locations_regex,$url_data,$url_data);
preg_match_all($url_table_regex,$url_data[1],$url_array);

//go through each page 
foreach($url_array[1] as $url_tag)
{

//these two web pages are so different from the rest that I can't use them without 
//making a new file to handle them so we will be skipping them
if($url_tag == 'Route_22' || $url_tag == 'Pok%C3%A9mon_League_Rematch')
{
	continue;
}

$final_array = array();

echo "\n\n" . $url_tag. "\n\n";

$data = file_get_contents($url_base . $url_tag);

//grab each table that has trainers in it, sometimes more than one
$trainer_table_regex = '/>1st<\/th>(.+)<\/table>/sU';
preg_match_all($trainer_table_regex,$data,$trainer_tables);

//keep track of position in final array throughout the multiple tables
$position = 0;
$j = 0;

        //MySQL Connection
	$servername = "localhost";
	$DBuser = "it490";
	$DBpass = "whoGivesaFuck!490";
	$database = "Trainer";
	
	//Create Connection
	$conn = new mysqli($servername, $DBuser, $DBpass, $database);
	
	//Check Connection
	if($conn->connect_error){
		die("Connection failed: " . $conn->connect_error);
	}
	else
	{
		$s = "SELECT * FROM info";
		($result = mysqli_query($conn, $s)) or die (mysqli_error());
		echo "Connected Successfully\n";
	}
	//MySQL Connection

//go through each table
foreach($trainer_tables[1] as $trainer_table)
{

//grab the individual trainers
$trainer_regex = '/<td(.+)<\/tr>/sU';
preg_match_all($trainer_regex,$trainer_table,$trainers);

//grab each trainer's type and store them seperately
$trainer_type_regex = '/<img alt="Pok.+mon.FRLG.(.+)\.png"/U';
$trainer_types = array();
$i = 0;
foreach($trainers[0] as $trainer)
{
	preg_match($trainer_type_regex,$trainer,$trainer_types[$i]);
	//here we use the type_change.php file to switch the strange trainer types with ones I defined in type_changes.php
	$trainer_types[$i][1] = type_switch($trainer_types[$i][1]);
	$final_array[$i+$position]['trainer_type'] = trim($trainer_types[$i][1]);
	$i++;
}

//some trainers have their info stored slightly differently and we don't 
//like that so we grab it then replace it, here we grab the names
$trainer_name_regex = '/\/><\/a>(?=[<br \/>]?)(\s*(.+))<\/td>/sU';
$trainer_names = array();
$i = 0;
foreach($trainers[0] as $trainer)
{
	preg_match($trainer_name_regex,$trainer,$trainer_names[$i]);
	$trainer_names[$i][1] = amp_replace($trainer_names[$i][1]);
	$trainer_names[$i][1] = html_jank_replace($trainer_names[$i][1]);
	$final_array[$i+$position]['trainer_name'] = trim($trainer_names[$i][1]);
	$i++;
}

//this will grab each pokemon from each individual trainer, Nidoran family tree is a bit weird so we have to swap out their info using type_change.php again
$trainer_pokemon_regex = '/"bulbapedia:(.+) \(/U';
$trainer_pokemons = array();
$trainer_levels = array();
$i = 0;
$pokemon_num = 1;
foreach($trainers[0] as $trainer)
{
	preg_match_all($trainer_pokemon_regex,$trainer,$trainer_pokemons[$i]);
	
	$trainer_pokemons_levels = array();
	foreach($trainer_pokemons[$i][1] as $pokemon)
	{
		preg_match_all("/$pokemon<\/a> ([0-9][0-9]?)<\/td>/",$trainer,$trainer_pokemons_levels[$pokemon]);
		if(count($trainer_pokemons_levels[$pokemon][1]) == 0)
		{
			preg_match_all("/$pokemon<\/a>([0-9][0-9]?)<\/td>/",$trainer,$trainer_pokemons_levels[$pokemon]);
		}
		if(count($trainer_pokemons_levels[$pokemon][1]) == 0)
		{
			preg_match_all("/$pokemon<\/a> ([0-9][0-9]?)\n<p><br \/><\/p>\n<\/td>/s",$trainer,$trainer_pokemons_levels[$pokemon]);
		}
        	if(count($trainer_pokemons_levels[$pokemon][1]) == 0)
        	{
                	preg_match_all("/$pokemon<\/a><br \/>\n([0-9]+)<\/td>/sU",$trainer,$trainer_pokemons_levels[$pokemon]);
        	}
        	if(count($trainer_pokemons_levels[$pokemon][1]) == 0)
        	{
                	preg_match_all('/\(lvl. ([0-9]+)\)<\/td>/U',$trainer,$trainer_pokemons_levels[$pokemon]);
        	}
	}

	$insert_reg = array();
	$final_array[$i+$position]['Pokemon_Count'] = count($trainer_pokemons[$i][1]);  
	foreach($trainer_pokemons[$i][1] as $pokemon)
	{

		$pokemon_old = $pokemon;
		if(!isset($insert_reg[$pokemon_old]))
		{
			$insert_reg[$pokemon_old] = 0;
		}
		$insert_reg[$pokemon_old]++;

		//some pokemon have leading/trailing whitespace so we just need to trim that here, whilst we fix the nidoran names
		$pokemon = name_change(trim($pokemon));
		$final_array[$i+$position]["pokemon$pokemon_num"]['name'] = ($pokemon);
		$final_array[$i+$position]["pokemon$pokemon_num"]['level'] = ($trainer_pokemons_levels[$pokemon_old][1][($insert_reg[$pokemon_old] - 1)]);
		if(isset($pokemon_type_table[$pokemon]))
		{
			$final_array[$i+$position]["pokemon$pokemon_num"]['types'] = $pokemon_type_table[$pokemon];
		}
		else
		{
			$temp_types = get_pokemon_types($pokemon);
			$final_types = array();
			$final_types[0] = $temp_types[0];
			if(isset($temp_types[1]))
			{
				$final_types[1] = $temp_types[1];
				if(!isset($final_types[1]))
					$final_types[1] = "";
			}
			$final_array[$i+$position]["pokemon$pokemon_num"]['types'] = $final_types;
			$pokemon_type_table[$pokemon] = $final_types;
		}
		
		$pokemon_num++;
		
	}
	//here we need to fill the rest of the trainer's pokemon slots with empty strings that way we can insert the trainers properly into the database
	for($pokemon_num; $pokemon_num + 1 < 8; $pokemon_num++)
	{
		$final_array[$i+$position]["pokemon$pokemon_num"]['name'] = "";
	}
	$pokemon_num = 1;
	$i++;
}

//increment the position that way for the next table we will be adding them appropiately into the final array
$position = $i + $position;
$j++;

}//end of loop for seperate trainer tables

var_dump($final_array);

//make insert statements for each trainer
foreach($final_array as $trainer)
{
        $trainerid++;
	$pokemonidArray = array();


	$name = $trainer['trainer_type'] .' ' . $trainer['trainer_name'];
	$salary = 0;
	for($pokemon_num = 1; $pokemon_num < 7; $pokemon_num++)
	{
		$pokemonidArray[$pokemon_num] = $pokemonid++;
		if($trainer["pokemon$pokemon_num"]["name"] == "")
		{
			continue;
		}

		$sql_pokemon = "INSERT INTO pokemon (pokemonid, name, type1, type2, level) VALUES ($pokemonidArray[$pokemon_num], ".'"'.$trainer["pokemon$pokemon_num"]['name'].'"'.", '".$trainer["pokemon$pokemon_num"]['types'][0]."', '".$trainer["pokemon$pokemon_num"]['types'][1]."', ".$trainer["pokemon$pokemon_num"]['level'].");";
		
		$salary +=  $trainer["pokemon$pokemon_num"]['level'];	
		$pokemon_moves = get_pokemon_moves($trainer["pokemon$pokemon_num"]['name'], $trainer["pokemon$pokemon_num"]['level']);
                
                $sql_moves = "INSERT INTO moves (pokemonid, move1, move2, move3, move4) VALUES ($pokemonidArray[$pokemon_num], '$pokemon_moves[0]', '$pokemon_moves[1]', '$pokemon_moves[2]', '$pokemon_moves[3]');";

		echo MySQLLib::makeDBSelection($sql_pokemon,'Trainer');
		echo MySQLLib::makeDBSelection($sql_moves,'Trainer'); 		

	}

	$sql_trainer = "INSERT INTO info (trainerid, name, pokemon1id, pokemon2id, pokemon3id, pokemon4id, pokemon5id, pokemon6id, salary) VALUES ($trainerid, '$name', $pokemonidArray[1], $pokemonidArray[2], $pokemonidArray[3], $pokemonidArray[4], $pokemonidArray[5], $pokemonidArray[6], $salary);";

		echo MySQLLib::makeDBSelection($sql_trainer,'Trainer'); 
}


}//end of url loop


?>

