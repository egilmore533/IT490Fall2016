<?php
$servername = "localhost";
$username = "it490";
$password = "whoGivesaFuck!490";
$dbname = "fightHistory";

//Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
//Check connection
if($conn->connect_error){
	die("Connection failed: " . $conn->connect_error);

}

?>