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

	$winnerResult = MySQLLib::makeSelection($winner_select, $leagueConn);
	while($row=mysqli_fetch_array($winnerResult))
	{
		var_dump($row);
	}
}

pay_league_winners(1);

