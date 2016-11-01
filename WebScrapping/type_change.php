#!/usr/bin/php
<?php

function type_switch($type_name)
{

$patterns = array(

  "/BugCatcher/",
  "/Camper/",
  "/Brock/",
  "/Lass/",
  "/Youngster/",
  "/SuperNerd/",
  "/Hiker/",
  "/TRGrunt/",
  "/Rival/",
  "/Swimmer♂/",
  "/Picnicker/",
  "/Misty/",
  "/Sailor/",
  "/Engineer/",
  "/Gentleman/",
  "/Surge/",
  "/Fisherman/",
  "/Gamer/",
  "/Pokemaniac/",
  "/Twins/",
  "/Biker/",
  "/Team Rocket Grunt M/",
  "/Beauty/",
  "/Cooltrainer♀/",
  "/Erika/",
  "/Boss Giovanni/",
  "/Channeler/",
  "/Black Belt/",
  "/PsychicM/",
  "/Sabrina/",
  "/Scientist/",
  "/Juggler/",
  "/Young Couple/",
  "/Cue Ball/",
  "/Birdkeeper/",
  "/Tamer/",
  "/Koga/",
  "/Rocker/",
  "/Crushkin/",
  "/SisandBro/",
  "/SwimmerF/",
  "/Burglar/",
  "/Blaine/",
  "/Aroma Lady/",
  "/Tuber/",
  "/Crush Girl/",
  "/Pokémon Ranger F/",
  "/Pokémon Ranger M/",
  "/Cooltrainer♂/",
  "/Cool Couple/",
  "/Lorelei/",
  "/Bruno/",
  "/Agatha/",
  "/Lance/",
  "/Ruin Maniac/",
  "/PsychicF/",
  "/Pokémon Breeder/",
);


$replacements = array(

  "Bug Catcher",
  "Camper",
  "",
  "Lass",
  "Youngster",
  "Super Nerd",
  "Hiker",
  "Team Rocket",
  "",
  "Swimmer",
  "Picnicker",
  "",
  "Sailor",
  "Engineer",
  "Gentleman",
  "",
  "Fisherman",
  "Gamer",
  "Pokemaniac",
  "Twins",
  "Biker",
  "Team Rocket",
  "Beauty",
  "Cooltrainer",
  "",
  "",
  "Channeler",
  "Black Belt",
  "Psychic",
  "",
  "Scientist",
  "Juggler",
  "Young Couple",
  "Cue Ball",
  "Birdkeeper",
  "Tamer",
  "",
  "Rocker",
  "Crushkin",
  "Sis and Bro",
  "Swimmer",
  "Burglar",
  "",
  "Aroma Lady",
  "Tuber",
  "Crush Girl",
  "Pokemon Ranger",
  "Pokemon Ranger",
  "Cooltrainer",
  "Cool Couple",
  "",
  "",
  "",
  "",
  "Ruin Maniac",
  "Psychic",
  "Pokemon Breeder",
);

return preg_array_replace($type_name, $patterns, $replacements);

}

function preg_array_replace($string, $patt, $repl)
{
	$return_string = $string;
	$pos = 0;
	$array_length = count($repl);
	while($pos < $array_length)
	{
		$return_string = preg_replace($patt[$pos],$repl[$pos],$return_string);
		$pos++;
	}

	return $return_string;
}



function name_change($name)
{
	$patterns= array(
		"/Nidoran♀/",
		"/Nidoran♂/",
		"/Nidorino/",
		"/Nidorina/",
		"/Nidoqueen/",
		"/Nidoking/",
		"/Exxegcute/"
		
	);

	$replacements = array(
		"Nidoran-F (F)",
		"Nidoran-M (M)",
		"Nidorino (M)",
		"Nidorina (F)",
		"Nidoqueen (F)",	
		"Nidoking (M)",
		"Exeggcute"
	);

	return preg_array_replace($name, $patterns, $replacements);		
}

function pokemon_name_change_back($pokemon_name)
{
	$patterns = array(
		'/Mr. Mime/',
		'/Nidoran-F \(F\)/',
		'/Nidoran-M \(M\)/',
		'/Nidorino \(M\)/',
		'/Nidorina \(F\)/',
		'/Nidoqueen \(F\)/',
		'/Nidoking \(M\)/',
		"/Farfetch'd/"
	);

	$replacements = array(
		"Mr._Mime",
		"Nidoran♀",
		"Nidoran♂",
		"Nidorino",
		"Nidorina",
		"Nidoqueen",
		"Nidoking",
		"Farfetch%27d"		
		
	);
	return preg_array_replace($pokemon_name,$patterns,$replacements);	
}

?>

