#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function deploy($versionNum)
{

        //MySQL Connection
	$servername = "localhost";
	$DBuser = "it490";
	$DBpass = "whoGivesaFuck!490";
	$database = "Files";
	
	$bundlelocation = "/var/packages/" . $versionName;
	$deploylocation = "/var/packages";
	$ipaddress = "10.200.20.100";
	
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
		
		if($versionNum == $r['versionNum']){
			$localLocation = "/var/packages/" . $r['versionName'];
			$version_num = $r['versionNum'];
			$version_name = $r['versionName'];
			break;
		}
		
	}
	
    $ipaddress = '127.0.0.1';
    $QALocation = "/var/packages";
    
    var_dump($localLocation);
    var_dump($QALocation);

    //get versionNum
        
	shell_exec("sudo scp " . $localLocation . "it490@" . $ipaddress . ":" . $QALocation);
	return array ("success" => '1', 'message'=>"Please Install Package Version Number " . $version_num . " Version Name " . $version_name);
}

function install()
{
        
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
		case "deploy":
		      return deploy($request['versionNum']);
		case "install":
			  return install();
		
	}
	return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$server = new rabbitMQServer("testRabbitMQ.ini","pokeServer");
$server->process_requests('requestProcessor');
exit();
?>
