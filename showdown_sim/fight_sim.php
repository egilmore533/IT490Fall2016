#!/usr/bin/php
<?php
require_once 'path.inc';
require_once 'MySQLLib.php.inc';
require_once 'make_team.php.inc';

$conn = MySQLLib::makeConnection();

$fight_array = array();
$winner = '';
$s = 'select * from Schedule.schedule';
$result = MySQLLib::makeSelection($s,$conn);
while($r=mysqli_fetch_array($result))
{

	$fight_array = array($r['trainer1id'],$r['trainer2id']);
	
	TrainerFiles::makeTrainerFile($r['trainer1id'],1);
	TrainerFiles::makeTrainerFile($r['trainer2id'],2);
	shell_exec('./fight.coffee > battle.txt');

	$fight_data = file_get_contents('./battle.txt');
	$winner_regex = '/(.+) defeated/';
	$loser_regex = '/defeated (.+)!/';

	preg_match($winner_regex,$fight_data,$winner_data);
	preg_match($loser_regex,$fight_data,$loser_data);

	$winner = $winner_data[1];

	//$fight_array = array($r['trainer1'],$r['trainer2']);
	var_dump($fight_array);
	//$winner = randomly_choose_winner($fight_array);
	if($r['trainer1'] == $winner)
	{
		$winnerID = $r['trainer1id'];
		$oddspayout = $r['odds'];
	}
	if($r['trainer2'] == $winner)
        {
                $winnerID = $r['trainer2id'];
                $oddspayout = $r['odds2'];
        }

	var_dump($winner);
	var_dump($r['trainer1']);
	var_dump($r['trainer2']);

	$s = 'select * from betHistory.history where fightid='.$r['fightid'];
	$payout_total = 0;
	$result2 = MySQLLib::makeSelection($s,$conn);
	while($r2=mysqli_fetch_array($result2))
	{
		$payout = $r2['trainer1_bet'];
		if($payout <= 0)
		{
			$payout = $r2['trainer2_bet'];
		}
		
		$s = 'select * from Accounts.info where username="'.$r2['username'].'"';
		$result3 = MySQLLib::makeSelection($s3,$conn);
		while($r3=mysqli_fetch_array($result3))
		{
			echo $winner."\n";
			var_dump($r2);
			var_dump($r3);
			if( ($r['trainer1']==$winner && $r2['trainer1_bet'] > 0) || ($r['trainer2']==$winner && $r2['trainer2_bet'] > 0) )
			{
				$s='update Accounts.info set funds='.($payout * $oddspayout + $r3['funds']).', wincount=wincount+1 where username="'.$r2['username'].'"';
			}
			else
			{
				$s="update Accounts.info set funds='".$r3['funds']."', losecount=losecount+1 where username='".$r2['username']."'";
			}
			echo $s."\n";
			if(mysqli_query($conn,$s))
			{
				echo $r2['username']." succesfully paid\n";
			}
			else { echo "payout failed to ".$r2['username']; }
		}
		(int)$payout_total += $oddspayout * $payout;//this where oddspayout is going
		if( ($r['trainer1']==$winner && $r2['trainer1_bet'] > 0) || ($r['trainer2']==$winner && $r2['trainer2_bet'] > 0) )
		{
			$s = 'update betHistory.history set winnings='.($payout * $oddspayout).' where fightid='.$r['fightid'].' and username="'.$r2['username'].'"';
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


	//league updates
	$s = "update League.teams set points=points+1 where (trainer1id=$winnerID)";
	for($count = 2; $count < 7; $count++)
	{
		$s.=" or (trainer".$count."id=$winnerID)";
	}
	echo $s . "\n";
	if($result2 = MySQLLib::makeSelection($s,$conn))
	{
		echo "Succesfully updated League teams\n";
	}

	break;
}

echo "\nWinner: $winner\n\n\n";


function get_winner()
{

}

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

