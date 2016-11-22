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
		$s = "SELECT * FROM files where versionName='$versionName'";
		($result = mysqli_query($conn, $s)) or die (mysqli_error());
		echo "Connected Successfully \n";
	}
	//MySQL Connection
	
	// 	lookup versionName and versionNum in database
	

                $verNum = 0.1;
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
	
	$ipaddress = "10.200.20.62";
	
	//Create Connection
	$conn = new mysqli($servername, $DBuser, $DBpass, $database);
	
	//Check Connection
	if($conn->connect_error){
		die("Connection failed: " . $conn->connect_error);
	}
	else
	{
		$s = "SELECT * FROM files where versionName='$versionName'";
		($result = mysqli_query($conn, $s)) or die (mysqli_error());
		echo "Connected Successfully \n";
	}
	//MySQL Connection
	
	
		($result = mysqli_query($conn, $s)) or die (mysqli_error());
                $verNum = 0.1;
		while($r=mysqli_fetch_array($result))
                {
                    
		    if($verNum == $r['versionNum'])
                            $verNum+=0.1; 
                }
		$reg = "INSERT INTO files (versionNum, versionName, full_package_name) VALUES('$verNum','$versionName', '$versionName$verNum')";
		$deploylocation = "/var/packages/$versionName/$verNum";	
		if($conn->query($reg) === TRUE)
                {
			
			echo "New Package created \n";
			shell_exec("mkdir -p /var/packages/$versionName/$verNum");
			shell_exec("sudo sshpass -p 'password' scp it490@" . $ipaddress . ":" . $deploylocation . "/$versionName$verNum.tar.gz " . $deploylocation );
			var_dump($versionName);
			var_dump($deploylocation);
			var_dump($verNum);
			
		}
		else {
			
			echo "Error: " . $reg . "<br>" . $conn->error;
			var_dump($versionName);
			var_dump($verNum);
		}
		
	
	$conn->close();
	
	if($checkDB == 1)
		return array("success" => true, 'message'=>"File Successfully put in DB, $verNum");
	else
		return array("success" => '0', 'message'=>"File Name is Taken, please rename");
}

function deploy($versionName, $ipaddress, $config, $name)
{

        //MySQL Connection
	$servername = "localhost";
	$DBuser = "it490";
	$DBpass = "whoGivesaFuck!490";
	$database = "Files";
	
	$bundlelocation = "/var/packages/$versionName.tar.gz";
	$QALocation = "/var/packages";
	
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
		echo "Connected Successfully \n";
	}
	//MySQL Connection
	
	var_dump($versionName);
	
	// 	lookup versionName and versionNum in database
	while($r=mysqli_fetch_array($result))
	{
		
		if($versionName == $r['versionName']){
			$localLocation = "/var/packages/" . $r['versionName'].".tar.gz";
			$version_num = $r['versionNum'];
			$version_name = $r['versionName'];
			
                        var_dump($localLocation);
                        var_dump($QALocation);
			
			shell_exec("sudo sshpass -p 'password' scp " . $localLocation . " it490@" . $ipaddress . ":" . $QALocation);
			
			$request['type'] = "install";
                        $request['number'] = $version_num;
			$request['config'] = $config;
			$request['name'] = $name;
			
			$connect = new RabbitMQClient("deployment.ini","installServer");
                        return $connect->send_request($request);
			
			break;
		}
	}
	return array ("success" => '0', 'message'=>"Package File Name not found");
        
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
                case "deploy_and_install":
		      return deploy($request['file_name'], $request['ip_address'], $request['config'], $request['name']);
		
	}
	return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$server = new rabbitMQServer("testRabbitMQ.ini","deploymentServer");
$server->process_requests('requestProcessor');
exit();
?>
