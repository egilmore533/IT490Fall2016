#!/usr/bin/php
<?php
include 'replace_tools.php';

function get_pokemon_moves($pokemon_name, $level)
{

$pokemon_name = pokemon_name_change_back($pokemon_name);

$all_moves = array();

$start_url = 'http://bulbapedia.bulbagarden.net/wiki/'.$pokemon_name.'_(Pok%C3%A9mon)/Generation_III_learnset#By_leveling_up';

$data = file_get_contents($start_url);

$move_table_regex = '/Generation II learnset"><span style="color:#000;">II<\/span><\/a>&#160;-&#160;<a href="\/wiki\/'.$pokemon_name.'_\(Pok%C3%A9mon\)\/Generation_IV_learnset(.+)<\/td><\/tr><\/table>/sU';

preg_match($move_table_regex,$data,$data2);

if(empty($data2))
{
	$move_table_regex = '/Generation II learnset"><span style="color:#000;">II<\/span><\/a>&#160;-&#160;<a href="\/wiki\/Nidoran%E2%99%82_\(Pok%C3%A9mon\)\/Generation_IV_learnset(.+)<\/td><\/tr><\/table>/sU';
	preg_match($move_table_regex,$data,$data2);
	if(empty($data2))
	{
		$move_table_regex = '/Generation II learnset"><span style="color:#000;">II<\/span><\/a>&#160;-&#160;<a href="\/wiki\/Nidoran%E2%99%80_\(Pok%C3%A9mon\)\/Generation_IV_learnset(.+)<\/td><\/tr><\/table>/sU';
        	preg_match($move_table_regex,$data,$data2);
	}
}


$move_regex = '/display:none">[0-9][0-9]<\/span>(.+)<\/span><\/a>/sU';
preg_match_all($move_regex,$data2[1],$moves_temp);

$level_regex = '/([0-9]+)/';
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

$final_moves = array(
	0 => '',
	1 => '',
	2 => '',
	3 => ''
);
foreach($all_moves as $move)
{
	$flag = 1;
	foreach($final_moves as $final_move)
	{
		if($move[1] == $final_move)
		{
			$flag = 0;
			break;
		}
	}
	if($flag == 0)
	{
		continue;
	}
	if((int)$move[0] <= (int)$level)
	{
		$final_moves[3] = $final_moves[2];
		$final_moves[2] = $final_moves[1];
		$final_moves[1] = $final_moves[0];
		$final_moves[0] = $move[1];	
	}
}


return $final_moves;


}

function get_pokemon_types($name)
{
	$name = pokemon_name_change_back($name);
	$start_url = 'http://bulbapedia.bulbagarden.net/wiki/'.$name.'_(Pok%C3%A9mon)';
	$data = file_get_contents($start_url);

	if(!isset($data))
	{
		echo "No $start_url found\n";
	}

	$name = pokemon_name_bulb_change($name);
	preg_match("/<p><b>$name<\/b>(.+)<\/p>/sU",$data,$type_paragraph);

	if(!isset($type_paragraph[1]))
	{
		echo "No $name found in page\n";
	}
	
	preg_match_all('/href="\/wiki\/([A-Z][a-z]+)_\(type\)/sU',$type_paragraph[1],$types_array);
	
	return $types_array[1];
}

?>

