#!/usr/bin/php
<?php

function randomly_choose_winner($trainers)
{
	if(count($trainers) < 2)
	{
		echo "not given two trainers\n";
		return NULL;
	}
	if(count($trainers) > 3)
	{
		echo "given to many trainers\n";
		return NULL;
	}
	$winner = array_rand($trainers);
	return $trainers[$winner];
}

$test = array('Bobby Tables', 'Youngster Joey');
var_dump(randomly_choose_winner($test));

?>

