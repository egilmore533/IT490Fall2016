#!/usr/bin/php
<?php
include 'type_change.php';


$start_url = 'Walkthrough';
$url_base = 'http://strategywiki.org/wiki/Pok%C3%A9mon_FireRed_and_LeafGreen/';

$url_data = file_get_contents($url_base . $start_url);

//this will gain the web addresses for the entire walktrough
$url_locations_regex = '/<div style="-moz-col(.+)<div style="/sU';
$url_table_regex = '/href="\/wiki\/Pok%C3%A9mon_FireRed_and_LeafGreen\/(.+)" title/U';
preg_match($url_locations_regex,$url_data,$url_data);
preg_match_all($url_table_regex,$url_data[1],$url_array);

$trainerid = 0;

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
		echo "Connected Successfully";
	}
	//MySQL Connection

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
	$final_array[$i+$position][0] = trim($trainer_types[$i][1]);
	$i++;
}

//some trainers have their info stored slightly differently and we don't 
//like that so we grab it then replace it, here we grab the names
$html_pattern = '/<br \/>\n/';
$html_replace = '';
$amp_pattern = '/&amp;/';
$amp_replace = '&';
$trainer_name_regex = '/\/><\/a>(?=[<br \/>]?)(\s*(.+))<\/td>/sU';
$trainer_names = array();
$i = 0;
foreach($trainers[0] as $trainer)
{
	preg_match($trainer_name_regex,$trainer,$trainer_names[$i]);
	$trainer_names[$i][1] = preg_replace($amp_pattern, $amp_replace, $trainer_names[$i][1]);
	$trainer_names[$i][1] = preg_replace($html_pattern, $html_replace, $trainer_names[$i][1]);
	$final_array[$i+$position][1] = trim($trainer_names[$i][1]);
	$i++;
}

//this will grab each pokemon from each individual trainer, these are all normal so we don't need to do any messing with them
$trainer_pokemon_regex = '/"bulbapedia:(.+) \(/U';
$trainer_pokemons = array();
$i = 0;
$pokemon_num = 0;
foreach($trainers[0] as $trainer)
{
	preg_match_all($trainer_pokemon_regex,$trainer,$trainer_pokemons[$i]);
	foreach($trainer_pokemons[$i][1] as $pokemon)
	{
		//some pokemon have leading/trailing whitespace so we just need to trim that here
		$final_array[$i+$position][$pokemon_num + 2] = trim($pokemon);
		$pokemon_num++;
	}
	//here we need to fill the rest of the trainer's pokemon slots with empty strings that way we can insert the trainers properly into the database
	for($pokemon_num; $pokemon_num + 2 < 8; $pokemon_num++)
	{
		$final_array[$i+$position][$pokemon_num + 2] = "";
	}
	$pokemon_num = 0;
	$i++;
}

//increment the position that way for the next table we will be adding them appropiately into the final array
$position = $i + $position;
$j++;

}//end of loop for seperate trainer tables

//this to check or output is good
var_dump($final_array);

//make insert statements for each trainer
foreach($final_array as $trainer)
{
	$trainerid++;

	if($trainer[0] == "")
	{
		$sql = "INSERT INTO info (trainerid, name, pokemon1, pokemon2, pokemon3, pokemon4, pokemon5, pokemon6) VALUES ('$trainerid','$trainer[1]', '$trainer[2]', '$trainer[3]', '$trainer[4]', '$trainer[5]', '$trainer[6]', '$trainer[7]' )";
		var_dump($sql);
	}
	else
	{
		$sql = "INSERT INTO info (trainerid, name, pokemon1, pokemon2, pokemon3, pokemon4, pokemon5, pokemon6) VALUES ('$trainerid', CONCAT('$trainer[0] ', '$trainer[1]'), '$trainer[2]', '$trainer[3]', '$trainer[4]', '$trainer[5]', '$trainer[6]', '$trainer[7]' )";
		var_dump($sql);
	}

	if($conn->query($sql) === TRUE)
	{			
		echo "New Trainer created";
	}
	else 
	{	
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
}

}//end of url loop

$conn->close();
?>
