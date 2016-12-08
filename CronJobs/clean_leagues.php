#!/usr/bin/php
<?php
include 'path.inc';
include 'MySQLLib.php';

function pay_league_winners($leagueID)
{

	$leagueConn = MySQLLib::makeDBConnection('League');
	$highestPoints = 0;
	$winnersArray = array();
	$winner_select = "select * from teams where leagueid=$leagueID ORDER BY points desc limit 2";
	
	$position = 1;
	$winnerResult = MySQLLib::makeSelection($winner_select, $leagueConn);
	while($row=mysqli_fetch_array($winnerResult))
	{
		$winnerArray[$position] = $row;
		echo "$position place: ".$row['username']."\n";
		$position++;
	}
	//get the total money for the league
	$pool_select = "select pool from info where leagueid=$leagueID";
	$poolResult = MySQLLib::makeSelection($pool_select,$leagueConn);
	$row=mysqli_fetch_array($poolResult);
	$pool = $row['pool'];
	$payout = 3 * ($pool/4);
	foreach($winnerArray as $winner)
	{
		$payout_select = "update info set funds=funds+$payout where username = '".$winner['username']."'";
		$payout_result = MySQLLib::makeDBSelection($payout_select,'Accounts');		
		if($payout_result)
		{
			echo "Succesfully payed ".$winner['username']." $payout\n";
		}
		$payout = $pool/4;
	}

	$league_remove = "delete from info where leagueid=$leagueID";

	$removeResult = MySQLLib::makeSelection($league_remove,$leagueConn);
	if($removeResult)
	{
		echo "Succesfully removed $leagueID\n";
	}
}

pay_league_winners(1);

