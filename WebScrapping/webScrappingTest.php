#!/usr/bin/php
<?php
include 'type_change.php';


$start_url = 'Walkthrough';
$url_base = 'http://strategywiki.org/wiki/Pok%C3%A9mon_FireRed_and_LeafGreen/';

$url_data = file_get_contents($url_base . $start_url);

$url_locations_regex = '/<div style="-moz-col(.+)<div style="/sU';
$url_table_regex = '/href="\/wiki\/Pok%C3%A9mon_FireRed_and_LeafGreen\/(.+)" title/U';
preg_match($url_locations_regex,$url_data,$url_data);
preg_match_all($url_table_regex,$url_data[1],$url_array);


foreach($url_array[1] as $url_tag)
{

if($url_tag == 'Route_22' || $url_tag == 'Pok%C3%A9mon_League_Rematch')
{
	continue;
}

$final_array = array();

echo "\n\n" . $url_tag. "\n\n";

$data = file_get_contents($url_base . $url_tag);

$trainer_table_regex = '/>1st<\/th>(.+)<\/table>/sU';

preg_match_all($trainer_table_regex,$data,$trainer_tables);

$position = 0;
$j = 0;

foreach($trainer_tables[1] as $trainer_table)
{

$trainer_regex = '/<td(.+)<\/tr>/sU';

preg_match_all($trainer_regex,$trainer_table,$trainers);

$trainer_type_regex = '/<img alt="Pok.+mon.FRLG.(.+)\.png"/U';
$trainer_types = array();
$i = 0;

foreach($trainers[0] as $trainer)
{
	preg_match($trainer_type_regex,$trainer,$trainer_types[$i]);
	$trainer_types[$i][1] = type_switch($trainer_types[$i][1]);
	$final_array[$i+$position][0] = trim($trainer_types[$i][1]);
	$i++;
}

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


$trainer_pokemon_regex = '/"bulbapedia:(.+) \(/U';
$trainer_pokemons = array();
$i = 0;
$pokemon_num = 0;
foreach($trainers[0] as $trainer)
{
	preg_match_all($trainer_pokemon_regex,$trainer,$trainer_pokemons[$i]);
	foreach($trainer_pokemons[$i][1] as $pokemon)
	{
		$final_array[$i+$position][$pokemon_num + 2] = trim($pokemon);
		$pokemon_num++;
	}
	for($pokemon_num; $pokemon_num + 2 < 8; $pokemon_num++)
	{
		$final_array[$i+$position][$pokemon_num + 2] = "";
	}
	$pokemon_num = 0;
	$i++;
}

$position = $i + $position;
$j++;

}//end of loop for seperate trainer tables

var_dump($final_array);

foreach($final_array as $trainer)
{
	$sql = "INSERT INTO trainers (name, pokemon1, pokemon2, pokemon3, pokemon4, pokemon5, pokemon6) VALUES (CONCAT('$trainer[0] ', '$trainer[1]'), '$trainer[2]', '$trainer[3]', '$trainer[4]', '$trainer[5]', '$trainer[6]', '$trainer[7]' )";
	var_dump($sql);
}

}//end of url loop


?>

