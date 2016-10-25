#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function doLogin($username,$password)
{
<<<<<<< HEAD
	
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
=======

///MySQL Connection
$servername = "localhost";
$DBuser = "it490";
$DBpass = "whoGivesaFuck!490";
$database = "userlogin";

//Create Connection
$conn = new mysqli($servername, $DBuser, $DBpass, $database);

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
//MySQL Connection

$checkDB = 0;

// lookup username and password in database
while($r=mysqli_fetch_array($result))
{
	$usernameDB = $r["username"];
	$passwordDB = $r["password"];
	var_dump($username);
	var_dump($password);

	if($username == $usernameDB && sha1($password) == $passwordDB)
>>>>>>> 738a043e885a297315cbfb7dde4e5dbb5d4047bb
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
<<<<<<< HEAD
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
	
=======
}

$conn->close();

if($checkDB == 0)
        return array("success" => '0', 'message'=>"Server received request and processed");
                //return false if not valid
>>>>>>> 738a043e885a297315cbfb7dde4e5dbb5d4047bb
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
<<<<<<< HEAD
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
=======
		$checkDB = 1;
}

if($checkDB == 1)
{
>>>>>>> 738a043e885a297315cbfb7dde4e5dbb5d4047bb
	
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
	
<<<<<<< HEAD
	if($checkDB == 1)
=======
	//Non-Sha password insert
	//$reg = "INSERT INTO userlogin (username, password) VALUES('$username', '$password')";
	if($conn->query($reg) === TRUE)
>>>>>>> 738a043e885a297315cbfb7dde4e5dbb5d4047bb
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
	
<<<<<<< HEAD
=======
	echo "Error: " . $reg . "<br>" . $conn->error;
	var_dump($username);
	var_dump($password);
	}
>>>>>>> 738a043e885a297315cbfb7dde4e5dbb5d4047bb
}

<<<<<<< HEAD
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

=======
$conn->close();

if($checkDB == 1)
	return array("success" => true, 'message'=>"Server received request and processed");
else
	return array("success" => '0', 'message'=>"Server received request and processed");
>>>>>>> 738a043e885a297315cbfb7dde4e5dbb5d4047bb
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
	}
	return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$server = new rabbitMQServer("testRabbitMQ.ini","testServer");
$server->process_requests('requestProcessor');
exit();
?>
