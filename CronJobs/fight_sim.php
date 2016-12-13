#!/usr/bin/php
<?php
include 'path.inc';
include 'MySQLLib.php';

$conn = MySQLLib::makeConnection();

$fight_array = array();
$winner = '';
$s = 'select * from Schedule.schedule';
$result = MySQLLib::makeSelection($s,$conn);
while($r=mysqli_fetch_array($result))
{
	$fight_array = array($r['trainer1'],$r['trainer2']);
	var_dump($fight_array);
	$winner = randomly_choose_winner($fight_array);
	if($r['trainer1'] == $winner)
	{
		$winnerID = $r['trainer1id'];
	}
	if($r['trainer2'] == $winner)
        {
                $winnerID = $r['trainer2id'];
        }



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
				$s='update Accounts.info set funds='.($payout + $payout + $r3['funds']).' where username="'.$r2['username'].'"';
			}
			else
			{
				$s="update Accounts.info set funds='".$r3['funds']."' where username='".$r2['username']."'";
			}
			echo $s."\n";
			if(mysqli_query($conn,$s))
			{
				echo $r2['username']." succesfully paid\n";
			}
			else { echo "payout failed to ".$r2['username']; }
		}
		$payout_total += ((int)$r2['trainer1_bet'] + (int)$r2['trainer2_bet']);
		if( ($r['trainer1']==$winner && $r2['trainer1_bet'] > 0) || ($r['trainer2']==$winner && $r2['trainer2_bet'] > 0) )
		{
			$s = 'update betHistory.history set winnings='.($payout + $payout).' where fightid='.$r['fightid'].' and username="'.$r2['username'].'"';
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
