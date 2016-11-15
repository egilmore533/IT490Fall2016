#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function bundle($versionName)
{
	
	//MySQL Connection
	$servername = "localhost";
	$DBuser = "it490";
	$DBpass = "whoGivesaFuck!490";
	$database = "Files";
	
	//Create Connection
	$conn = new mysqli($servername, $DBuser, $DBpass, $database);
	
	//Check Connection
	if($conn->connect_error){
		die("Connection failed: " . $conn->connect_error);
	}
	else
	{
		$s = "SELECT * FROM files";
		($result = mysqli_query($conn, $s)) or die (mysqli_error());
		echo "Connected Successfully";
	}
	//MySQL Connection
	
	// 	lookup versionName and versionNum in database
	

                $verNum = 00;
		while($r=mysqli_fetch_array($result))
                {
                    if($verNum == $r['versionNum'])
                            $verNum+=0.1; 
                }
		

	
	
	$conn->close();
	
		return array("success" => true, 'version_number'=>"$verNum");

}

function insertBundle($versionName)
{
    $checkDB = 1;
	
	//MySQL Connection
	$servername = "localhost";
	$DBuser = "it490";
	$DBpass = "whoGivesaFuck!490";
	$database = "Files";
	
	//Create Connection
	$conn = new mysqli($servername, $DBuser, $DBpass, $database);
	
	//Check Connection
	if($conn->connect_error){
		die("Connection failed: " . $conn->connect_error);
	}
	else
	{
		$s = "SELECT * FROM files";
		($result = mysqli_query($conn, $s)) or die (mysqli_error());
		echo "Connected Successfully";
	}
	//MySQL Connection
	
	// 	lookup versionName and versionNum in database
	while($r=mysqli_fetch_array($result))
	{
		
		if($versionName == $r['versionName']){
			$checkDB = 0;
			break;
		}
		else
				$checkDB = 1;
		
	}
	
	if($checkDB == 1)
	{
                $verNum = 00;
		while($r=mysqli_fetch_array($result))
                {
                    if($verNum == $r['versionNum'])
                            $verNum+=0.1; 
                }
		$reg = "INSERT INTO files (versionNum, versionName) VALUES('$verNum','$versionName' )";
		
		if($conn->query($reg) === TRUE)
                {
			
			echo "New Package created";
			var_dump($versionName);
			var_dump($verNum);
			
		}
		else {
			
			echo "Error: " . $reg . "<br>" . $conn->error;
			var_dump($versionName);
			var_dump($verNum);
		}
		
	}
	else
		echo "File Name Taken";
	
	
	$conn->close();
	
	if($checkDB == 1)
		return array("success" => true, 'message'=>"File Successfully put in DB, $verNum");
	else
		return array("success" => '0', 'message'=>"File Name is Taken, please rename");
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
		case "bundle":
		      return insertBundle($request['version_name']);
                case "version_number":
		      return bundle($request['version_name']);
		
	}
	return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$server = new rabbitMQServer("testRabbitMQ.ini","deploymentServer");
$server->process_requests('requestProcessor');
exit();
?>
