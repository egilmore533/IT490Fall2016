<?php
require_once('mysqlschedule.php');

$sql = "SELECT * FROM history";
$result = $conn->query($sql);

if($result->num_rows > 0){
    echo "<style>table, th, td{border: 1px solid black; float:center;}</style>";
	echo "<table><tr><th>ID</th><th>Trainer 1</th><th>Trainer 2</th><th>Payout</th><th>Winner
</th><th>Odds</th></tr>";
		//output data of each row
	while($row = $result->fetch_assoc()){
		echo "<tr><td>".$row["fightid"]."</td><td><bb title='Pikachu \nBulbasaur'><font color='blue'>".$row["trainer1id"]."</font></bb></td><td><c title='Absol \nPikachu'><font color='blue'>".$row["trainer2id"]."</font></c></td><td>".$row["payout"]."</td><td>".$row["winner"]."</td><td>".$row["odds"]."</td></tr>";
}
	echo "</table>";
}else {
	echo "0 results";
}

$conn -> close();
?>
