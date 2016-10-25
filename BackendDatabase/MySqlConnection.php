#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require_once('mysqllogin.php');

function doLogin($username,$password)
{	
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
			return array("success" => true, 'message'=>"Server received request and processed");
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
		case "validate_session":
		      return doValidate($request['sessionId']);
	}
	return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$server = new rabbitMQServer("testRabbitMQ.ini","testServer");
$server->process_requests('requestProcessor');
exit();
?>
