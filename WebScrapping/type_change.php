!usrbinphp
 <?php

function type_switch($type_name)
{

$patterns = array(

  '/BugCatcher/',
  '/Camper/',
  '/Brock/',
  '/Lass/',
  '/Youngster/',
  '/SuperNerd/',
  '/Hiker/',
  '/TRGrunt/',
  '/Rival/',
  '/Swimmer♂/',
  '/Picnicker/',
  '/Misty/',
  '/Sailor/',
  '/Engineer/',
  '/Gentleman/',
  '/Surge/',
  '/Fisherman/',
  '/Gamer/',
  '/Pokemaniac/',
  '/Twins/',
  '/Biker/',
  '/Team Rocket Grunt M/',
  '/Beauty/',
  '/Cooltrainer♀/',
  '/Erika/',
  '/Boss Giovanni/',
  '/Channeler/',
  '/Black Belt/',
  '/PsychicM/',
  '/Sabrina/',
  '/Scientist/',
  '/Juggler/',
  '/Young Couple/',
  '/Cue Ball/',
  '/Birdkeeper/',
  '/Tamer/',
  '/Koga/',
  '/Rocker/',
  '/Crushkin/',
  '/SisandBro/',
  '/SwimmerF/',
  '/Burglar/',
  '/Blaine/',
  '/Aroma Lady/',
  '/Tuber/',
  '/Crush Girl/',
  '/Pokémon Ranger F/',
  '/Pokémon Ranger M/',
  '/Cooltrainer♂/',
  '/Cool Couple/',
  '/Lorelei/',
  '/Bruno/',
  '/Agatha/',
  '/Lance/',
  '/Ruin Maniac/',
  '/PsychicF/',
  '/Pokémon Breeder/',
);


$replacements = array(

  'Bug Catcher',
  'Camper',
  '',
  'Lass',
  'Youngster',
  'Super Nerd',
  'Hiker',
  'Team Rocket Grunt',
  '',
  'Swimmer',
  'Picnicker',
  '',
  'Sailor',
  'Engineer',
  'Gentleman',
  '',
  'Fisherman',
  'Gamer',
  'Pokemaniac',
  'Twins',
  'Biker',
  'Team Rocket Grunt',
  'Beauty',
  'Cooltrainer',
  '',
  '',
  'Channeler',
  'Black Belt',
  'Psychic',
  '',
  'Scientist',
  'Juggler',
  'Young Couple',
  'Cue Ball',
  'Birdkeeper',
  'Tamer',
  '',
  'Rocker',
  'Crushkin',
  'Sis and Bro',
  'Swimmer',
  'Burglar',
  '',
  'Aroma Lady',
  'Tuber',
  'Crush Girl',
  'Pokémon Ranger',
  'Pokémon Ranger',
  'Cooltrainer',
  'Cool Couple',
  '',
  '',
  '',
  '',
  'Ruin Maniac',
  'Psychic',
  'Pokémon Breeder',
);

$return_string;
$replace_pos = 0;
$replace_count = count($replacements);
foreach($patterns as $pattern)
{


	$return_string = preg_replace($pattern,$replacements[$replace_pos],$type_name);
	$replace_pos++;
	if($replace_pos >= $replace_count)
	{
		$replace_pos = 0;
	}
}



$return_string = preg_replace("/BugCatcher/","Bug Catcher",$type_name);
var_dump($return_string);
return $return_string;
}

?>

