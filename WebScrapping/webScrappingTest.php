#!/usr/bin/php
<?php

$final_array = array();

$url = 'http://strategywiki.org/wiki/Pok%C3%A9mon_FireRed_and_LeafGreen/Mt._Moon';

$data = file_get_contents($url);

$trainer_table_regex = '/>Money(.+)<\/table>/sU';

preg_match_all($trainer_table_regex,$data,$trainer_tables);


$position = 0;
$j = 0;
foreach($trainer_tables[1] as $trainer_table)
{

$trainer_regex = '/<td (.+)<\/tr>/sU';

preg_match_all($trainer_regex,$trainer_table,$trainers);

$trainer_type_regex = '/Pokemon_FRLG_(.+).png/U';
$trainer_types = array();
$i = 0;
foreach($trainers[0] as $trainer)
{
	preg_match($trainer_type_regex,$trainer,$trainer_types[$i]);
	$final_array[$i+$position][0] = $trainer_types[$i][1];
	$i++;
}


$trainer_name_regex = '/\/><\/a>( ?[A-Z][a-z]+)<\/td>/';
$trainer_names = array();
$i = 0;
foreach($trainers[0] as $trainer)
{
	preg_match($trainer_name_regex,$trainer,$trainer_names[$i]);
	$final_array[$i+$position][1] = $trainer_names[$i][1];
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
		$final_array[$i+$position][$pokemon_num + 2] = $pokemon;
		$pokemon_num++;
	}
	$pokemon_num = 0;
	$i++;
}

$position = $i;
$j++;

}//end of loop for seperate trainer tables

var_dump($final_array);

?>

