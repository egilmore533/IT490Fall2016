<?php
//MySQL Connection
	$servername = "localhost";
	$DBuser = "it490";
	$DBpass = "whoGivesaFuck!490";
	$database = "userlogin";
	$database2 = "Accounts";
	
	//Create Connection
	$conn = new mysqli($servername, $DBuser, $DBpass, $database);
	$conn2 = new mysqli($servername, $DBuser, $DBpass, $database2);
	
	//Check Connection
	if($conn->connect_error){
		die("Connection failed: " . $conn->connect_error);
	}
	else
	{
		$s = "SELECT * FROM userlogin";
		($result = mysqli_query($conn, $s)) or die (mysqli_error());
		echo "Connected Successfully";
	}
	if($conn2->connect_error){
		die("Connection failed: " . $conn2->connect_error);
	}
	else
	{
		$s = "SELECT * FROM info";
		($result2 = mysqli_query($conn2, $s)) or die (mysqli_error());
		echo "Connected Successfully";
	}
	//MySQL Connection
?>