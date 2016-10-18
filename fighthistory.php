#!/usr/bin/php
<?php
$servername = "localhost";
$username = "it490";
$password = "whoGivesaFuck!490";
$dbname = "fightHistory";

//Create connection
$conn = new mysqli($servername, $username, $password, %dbname);
//Check connection
if($conn->connect_error){
	die("Connection failed: " . $conn->connect_error);

}

$sql = "SELECT fightid, trainer1id, trainer2id, payout, winner, odds FROM history";
$result = $conn->query($sql);

if($result->num_rows > 0){
	echo "<table><tr><th>ID</th><th>Trainer 1</th><th>Trainer 2</th><th>Payout</th><th>Winner</th>
			<th>Odds</th></tr>";
			//output data of each row
	while($row = $result->fetch_assoc()){
		echo "<tr><td>".$row["fightid"]."</td><td>".$row[trainer1id]."</td><td>".$row[trainer2id]."</td><td>".$row[payout].
				"</td><td>".$row[winner]."</td><td>".$row[odds]."</td></tr>";
	}
	echo "</table>";
}else {
	echo "0 results";
}

$conn -> close();
?>
