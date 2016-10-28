#!/usr/bin/php
<?php


function get_pokemon_moves($pokemon_name)
{

$all_moves = array();

$start_url = 'http://bulbapedia.bulbagarden.net/wiki/'.$pokemon_name.'_(Pok%C3%A9mon)/Generation_III_learnset#By_leveling_up';

$data = file_get_contents($start_url);

$move_table_regex = '/Generation II learnset"><span style="color:#000;">II<\/span><\/a>&#160;-&#160;<a href="\/wiki\/'.$pokemon_name.'_\(Pok%C3%A9mon\)\/Generation_IV_learnset(.+)<\/td><\/tr><\/table>/sU';

preg_match($move_table_regex,$data,$data);


$move_regex = '/display:none">[0-9][0-9]<\/span>(.+)<\/span><\/a>/sU';
preg_match_all($move_regex,$data[1],$moves_temp);

$level_regex = '/(.+)<\/td>/sU';
$name_regex = '/title="(.+) \(move\)/';
$pos = 0;
foreach($moves_temp[1] as $move)
{
	preg_match($level_regex,$move,$temp);
	$temp = trim($temp[1]);
	$all_moves[$pos][0] = $temp;
	preg_match($name_regex,$move,$temp);
	$all_moves[$pos][1] = $temp[1];
	$pos++;
}

$final_moves = array();
foreach($all_moves as $move)
{
	
}

return $final_moves;


}

get_pokemon_moves('Geodude');

?>

