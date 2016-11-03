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
	($result2 = mysqli_query($conn,$s) or die (mysqli_error()));
	while($r2=mysqli_fetch_array($result2))
	{
		$payout = $r2['trainer1_bet'];
		if($payout <= 0)
		{
			$payout = $r2['trainer2_bet'];
		}
		
		$s = 'select * from Accounts.info where username="'.$r2['username'].'"';
		($result3= mysqli_query($conn,$s) or die (mysqli_error()));
		while($r3=mysqli_fetch_array($result3))
		{
			$s='update Accounts.info set funds='.($payout + $r3['funds']).' where username="'.$r2['username'].'"';
			echo $s."\n";
			if(mysqli_query($conn,$s))
			{
				echo $r2['username']." succesfully paid\n";
			}
			else { echo "payout failed to ".$r2['username']; }
		}
		$payout_total += ((int)$r2['trainer1_bet'] + (int)$r2['trainer2_bet']);
		if( ($r2['trainer1']==$winner && $r2['trainer1_bet'] > 0) || ($r2['trainer2']==$winner && $r2['trainer2_bet'] > 0) )
		{
			$s = 'update betHistory.history set winnings='.$payout.' where fightid='.$r['fightid'].' and username="'.$r2['username'].'"';
		}
		else 
		{
			$s = 'update betHistory.history set winnings=0 where fightid='.$r['fightid'].' and username="'.$r2['username'].'"';
		}
		if(mysqli_query($conn,$s))
		{
			echo "Succesfully updated betHistory for fightid: ".$r['fightid']." username: ".$r2['username']."\n";
		}
		else
		{	
			echo "Failed to Update betHistory for fight: ".$r['fightid'].
" username: ".$r2['username']."\n";	
		}
	}
        $s = 'insert into fightHistory.history values ("'.$r['fightid']."\",\"".$r['trainer1']."\",".$r['trainer1id'].",\"".$r['trainer2']."\",".$r['trainer2id'].",".$payout_total.",\"".$winner."\",". 1.0. ','.$r['time'] .')';
	var_dump($s);
	if(mysqli_query($conn,$s))
	{
		echo "Fight History Row Added Succesfully\n";
	}
	else
	{
		echo "Failed to Add Row to Fight History\n";
	}
	$s = 'delete from Schedule.schedule where fightid='.$r['fightid'];
	if(mysqli_query($conn,$s))
	{
		echo "Schedule Row Updated Succesfully\n";
	}
	else
	{
		echo "Schedule Row Failed to Update\n";
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

