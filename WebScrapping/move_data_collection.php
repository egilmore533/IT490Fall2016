#!/usr/bin/php
<?php


function get_pokemon_moves($pokemon_name)
{

$moves = array();

$start_url = 'https://bulbapedia.bulbagarden.net/wiki/'.$pokemon_name.'_(Pok%C3%A9mon)/Generation_|||_learnset';

$data = file_get_contents($start_url);

$move_table_regex = '/Generation || learnset"><span style="color:#000;">||<\/span><\/a>&#160;-&#160;<a href="\/wiki\/'.$pokemon_name.'_(Pok%C3%A9mon\)\/Generation_IV_learnset(.+)<\/td><\/tr><\/table>/sU';

preg_match($move_table_regex,$data,$data);

var_dump($data);

/*preg_match_all($move_regex,$data,$moves_temp);

$pos = 0;
foreach($moves_temp[1] as $move)
{
	$moves[$pos] = $move;
}
*/
return $moves;

}

get_pokemon_moves('Geodude');

?>

