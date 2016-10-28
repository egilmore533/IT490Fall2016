#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function doLogin($username,$password)
{
	
	///MySQL Connection
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
	
	$checkDB = 0;
	
	// 	lookup username and password in database
	while($r=mysqli_fetch_array($result))
	{
		$usernameDB = $r["username"];
		$passwordDB = $r["password"];
		
		var_dump($username);
		var_dump($password);
		
		if($username == $usernameDB && $password == $passwordDB)
			{
			$sd = sha1(strval(date(DATE_ATOM)));
			echo "\n\n" . $sd . "\n\n";
			echo "Access Granted";
			$checkDB = 1;
			while($a=mysqli_fetch_array($result2))
			{
				if($username == $a["username"])
				{
					$balance = $a["funds"];
					$wins = $a["wincount"];
					echo "\nbalance and wins stored";
				}
				else
				{
					echo "\nusername not found!?";
				}
			
			}
			echo "\nbalance and wins sent\n";
			return array("success" => true, 'message'=>"Server received request and processed", 'balance'=>$balance, 'wins'=>$wins);
			//return false if not valid
					break;
		}
		else 
			{
			echo "Access Denied";
			$checkDB = 0;
			//return array("success" => false, 'message'=>"Server received request and processed");
			//return false if not valid
		}
	}
	
	$conn->close();
	
	if($checkDB == 0)
	        return array("success" => '0', 'message'=>"Server received request and processed");
	//return false if not valid
	
}

function register($username, $password)
{
	
	$checkDB = 1;
	
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
	
	// 	lookup username and password in database
	while($r=mysqli_fetch_array($result))
	{
		
		if($username == $r['username']){
			$checkDB = 0;
			break;
		}
		else
				$checkDB = 1;
		
	}
	
	if($checkDB == 1)
	{
		
		$sp = $password;
		$reg = "INSERT INTO userlogin (username, password) VALUES('$username','$sp' )";
		
		//N		on-Sha password insert
			//$		reg = "INSERT INTO userlogin (username, password) VALUES('$username', '$password')";
		
		if($conn->query($reg) === TRUE)
			{
			
			echo "New user name created";
			var_dump($username);
			var_dump($password);
			
		}
		else {
			
			echo "Error: " . $reg . "<br>" . $conn->error;
			var_dump($username);
			var_dump($password);
		}
		
		$date = date("Y/m/d H:i:s");
		$reg = "INSERT INTO info (username, funds, wincount, avg_odds, flagged, email, dateReg) VALUES('$username','0.0', '0', '0.0', '0', '@@@', '$date')";
		
		if($conn2->query($reg) === TRUE)
			{
			
			echo "New user info created";
			
		}
		else {
			
			echo "Error: " . $reg . "<br>" . $conn->error;
		}
	}
	else
		echo "Username Taken.";
	
	
	$conn->close();
	
	if($checkDB == 1)
		return array("success" => true, 'message'=>"Server received request and processed");
	else
		return array("success" => '0', 'message'=>"Server received request and processed");
	
}

function addfunds($username, $add)
{
	//MySQL Connection
	$servername = "localhost";
	$DBuser = "it490";
	$DBpass = "whoGivesaFuck!490";
	$database2 = "Accounts";
	
	//Create Connection
	$conn2 = new mysqli($servername, $DBuser, $DBpass, $database2);
	
	//Check Connection
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

	var_dump($username);
	$f = 0;
	while($a=mysqli_fetch_array($result2))
	{
		if($username == $a["username"])
		{
			$f = $a['funds']; 
			$f = $f+$add;
			$reg = "UPDATE info SET funds='$f' WHERE username='$username'";
		
		
		if($conn2->query($reg) === TRUE)
		{
			echo "\nFunds added to database\n";
		}
		else {
			
			echo "Error: " . $reg . "<br>" . $conn2->error;
		}
			echo "Funds Added!" . "<br>";
			$conn2->close();
			return array("success" => true, 'message'=>$f);

		}
		else{
			echo "error no username";
			$conn2->close();
			return array("success" => '0', 'message'=>"Error with adding funds");
		}
			
	}

}

function fightHistory()
{
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

	$sql = "SELECT * FROM history";
	$result = $conn->query($sql);
	$tablestring = "";

	if($result->num_rows > 0)
	{	
		//$tablestring .= "<style>table, th, td{border: 1px solid black; float:center;}</style>";
		$tablestring .= "<table><tr><th>ID<th>Trainer 1<th>Trainer 2<th>Payout<th>Winner<th>Odds";
			//output data of each row
		while($row = $result->fetch_assoc())
		{
			echo "tablestring created\n";
			$tablestring .= "<tr><td>".$row["fightid"]."<td>".$row["trainer1id"]."<td>".$row["trainer2id"]."<td>".$row["payout"]."<td>".$row["winner"]."<td>".$row["odds"]."";
		}
			echo "tablestring sent\n";
			return array("success" => true, 'message'=>$tablestring);	
	}
	else 
	{
		$tablestring = "0 results";
		echo "no data to create table\n";
		return array("success" => '0', 'message'=>$tablestring);
	}

	$conn -> close();
}

function betHistory($username)
{

	//MySQL Connection
	$servername = "localhost";
	$DBuser = "it490";
	$DBpass = "whoGivesaFuck!490";
	$database = "betHistory";
	
	//Create Connection
	$conn = new mysqli($servername, $DBuser, $DBpass, $database);
	
	//Check Connection
	if($conn->connect_error){
		die("Connection failed: " . $conn->connect_error);
	}
	else
	{
		$s = "SELECT * FROM history";
		($result = mysqli_query($conn, $s)) or die (mysqli_error());
		echo "Connected Successfully";
	}
	//MySQL Connection

	$tablestring = "";
	//$tablestring .= "<style>table, th, td{border: 1px solid black; float:center;}</style>";
	$tablestring .= "<table><tr><th>FightID<th>Trainer 1 Bet<th>Trainer 2 Bet<th>Winnings";
	//output data of each row

	while($row=mysqli_fetch_array($result))
	{
		if($username == $row["username"])
		{
			echo "\nbet history found\n";
			$tablestring .= "<tr><td>".$row["fightid"]."<td>"."$".$row["trainer1_bet"]."<td>"."$".$row["trainer2_bet"]."<td>"."$".$row["winnings"]."";
		
			echo "bet history gathered and sent" . "\n";
			$conn->close();
			return array("success" => true, 'message'=>$tablestring);

		}
		else{
			echo "error no username";
			$conn->close();
			return array("success" => '0', 'message'=>"Error with getting bet history");
		}
			
	}

}

function schedule()
{
	//MySQL Connection
        $servername = "localhost";
        $DBuser = "it490";
        $DBpass = "whoGivesaFuck!490";
        $database = "Schedule";
	$database2 = "Trainer";

        //Create Connection
        $conn = new mysqli($servername, $DBuser, $DBpass, $database);
	$conn2 = new mysqli($servername, $DBuser, $DBpass, $database2);

        //Check Connection
        if($conn->connect_error){
                die("Connection failed: " . $conn->connect_error);
        }
        else
        {
                $s = "SELECT * FROM schedule";
                ($result = mysqli_query($conn, $s)) or die (mysqli_error());
                echo "Connected Successfully";
        }
	//Check Connection
        if($conn2->connect_error){
                die("Connection failed: " . $conn2->connect_error);
        }
        else
        {
                $i = "SELECT * FROM info"; 
                ($result2 = mysqli_query($conn2, $i)) or die (mysqli_error());
                echo "Connected Successfully";
        }

        //MySQL Connection
	
	$tablestring = "";
	$pokestring1 = "";
	$pokestring2 = "";

	if($result->num_rows > 0)
	{
	//$tablestring .= "<style>table, th, td{border: 1px solid black; float:center;}</style>";
        $tablestring .= "<table><tr><th>ID<th>Trainer 1<th>Trainer 2<th>Odds<th>Date";
       
	 //output data of each row
        while($row = $result->fetch_assoc())
	{
		while($row2 = $result2->fetch_assoc())
                {
                        if($row["trainer1id"] == $row2["trainerid"])
                        {
                                $pokestring1 = $row2["pokemon1"] . $row2["pokemon2"] . $row2["pokemon3"] . $row2["pokemon4"] . $row2["pokemon5"] . $row2["pokemon6"];           
                        }
                        if($row["trainer2id"] == $row2["trainerid"])
                        {
                                $pokestring2 = $row2["pokemon1"] . $row2["pokemon2"] . $row2["pokemon3"] . $row2["pokemon4"] . $row2["pokemon5"] . $row2["pokemon6"];
                        }
                }
		

		echo "tablestring created\n";
        	$tablestring .= "<tr><td>".$row["fightid"]."<td><bb title=$pokestring1><font color='blue'>".$row["trainer1"]."<td><cc title=$pokestring2><font color='blue'>".$row["trainer2"]."<td>".$row["odds"]."<td>".$row["time"]."";

		$pokestring1 = "";
                $pokestring2 = "";
                $result2 = $conn2->query($i);
	}
        	echo "tablestring sent\n";
		return array("success" => true, 'message' =>$tablestring); 
	}else {
		$tablestring = "0 results";
        	echo "0 results\n";
		return array("success" => '0', 'message'=>$tablestring);
	}

	$conn -> close();
	

}

function requestProcessor($request)
{
	echo "received request".PHP_EOL;
	
	if(!isset($request['type']))
	  {
		return "ERROR: unsupported message type";
	}
	switch ($request['type'])
	  {
		case "login":
		      return doLogin($request['username'],$request['password']);
		case "register":
		      return register($request['username'],$request['password']);
		case "addfunds":
			  return addfunds($request['username'], $request['funds']);
		case "validate_session":
		      return doValidate($request['sessionId']);
		case "fh":
		      return fightHistory();
		case "bh":
		      return betHistory($request['user']);
		case "sched":
		      return schedule();
	}
	return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$server = new rabbitMQServer("testRabbitMQ.ini","pokeServer");
$server->process_requests('requestProcessor');
exit();
?>
