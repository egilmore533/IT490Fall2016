!usrbinphp
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
  "Team Rocket Grunt",
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
  "Team Rocket Grunt",
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
  "Pokémon Ranger",
  "Pokémon Ranger",
  "Cooltrainer",
  "Cool Couple",
  "",
  "",
  "",
  "",
  "Ruin Maniac",
  "Psychic",
  "Pokémon Breeder",
);

$return_string = $type_name;
$pos = 0;
$array_length = count($replacements);
while($pos < $array_length)
{
	$return_string = preg_replace($patterns[$pos],$replacements[$pos],$return_string);
	$pos++;
}

return $return_string;

}

?>

