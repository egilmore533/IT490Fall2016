#!/usr/bin/php
<?php

$servername = 'localhost';
$username = 'it490';
$password = 'whoGivesaFuck!490';

$conn = new mysqli($servername, $username, $password);

if($conn->connect_error)
{
	die("Connection attempt failed: ".$conn->connect_error);
}
echo "Successful Connection\n";
$fight_array = array();
$winner = '';
$s = 'select * from Schedule.schedule';
($result = mysqli_query($conn, $s)) or die (mysqli_error());
while($r=mysqli_fetch_array($result))
{
	$fight_array = array($r['trainer1'],$r['trainer2']);
	var_dump($fight_array);
	$winner = randomly_choose_winner($fight_array);
	$s = 'select * from betHistory.history where fightid='.$r['fightid'];
	$payout_total = 0;
	var_dump($s);
	($result2 = mysqli_query($conn,$s) or die (mysqli_error()));
	while($r2=mysqli_fetch_array($result2))
	{
		var_dump($r2);
		$payout_total += ((int)$r2['trainer1_bet'] + (int)$r2['trainer2_bet']);
	}
	
	break;
}

echo "\nWinner: $winner\n\n\n";


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

?>

