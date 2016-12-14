#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require_once('requestClean.php.inc');
require_once('MySQLLib.php.inc');

function ipcall($machineName)
{
    $ini_array=parse_ini_file('hosts_addresses.ini');

    $ip = $ini_array[$machineName];
    
    return $ip;
}

function bundle($versionName)
{
	$conn = MySQLLib::makeDBConnection('Files');	
	
	$s = "SELECT * FROM files where versionName='$versionName'";
	($result = mysqli_query($conn, $s)) or die (mysqli_error());
	// 	lookup versionName and versionNum in database
        $verNum = 1;
	while($r=mysqli_fetch_array($result))
        {
   	     if($verNum == $r['versionNum'])
             $verNum+=1; 
        }	
	
	$conn->close();
	
	return array("success" => true, 'version_number'=>"$verNum");

}

function insertBundle($versionName)
{
    $checkDB = 1;
	$conn = MySQLLib::makeDBConnection('Files');
	
	$ipaddress = ipcall('stephen_dev');
	
	$s = "SELECT * FROM files where versionName='$versionName'";
	($result = mysqli_query($conn, $s)) or die (mysqli_error());
	
	($result = mysqli_query($conn, $s)) or die (mysqli_error());
        $verNum = 1;
	while($r=mysqli_fetch_array($result))
        {
	    if($verNum == (float)$r['versionNum'])
            {
	        $verNum+=1;
	    }  		
        }
	$reg = "INSERT INTO files (versionNum, versionName, full_package_name) VALUES('$verNum','$versionName', '$versionName$verNum')";
	$deploylocation = "/var/packages/$versionName/$verNum";	
	if($conn->query($reg) === TRUE)
        {		
		echo "New Package created \n";
		shell_exec("mkdir -p /var/packages/$versionName/$verNum");
		$test_string = "sshpass -p password scp it490@" . $ipaddress . ":" . $deploylocation . "/$versionName$verNum.tar.gz " . $deploylocation;
		var_dump($test_string);
		shell_exec($test_string);
		var_dump($versionName);
		var_dump($deploylocation);
		var_dump($verNum);
		var_dump($ipaddress);	
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

function deploy($versionName, $hostname, $config, $name)
{
	$conn = MySQLLib::makeDBConnection('Files');
		
	$bundlelocation = "/var/packages/$versionName.tar.gz";
	$QALocation = "/var/packages";
	
	$ipaddress = ipcall($hostname);
	
	$s = "SELECT * FROM files";
	($result = mysqli_query($conn, $s)) or die (mysqli_error());
	
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
			
			shell_exec("sshpass -p 'password' scp " . $localLocation . " it490@" . $ipaddress . ":" . $QALocation);
			
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
	
	$request = ArrayClean::multidimensionalArrayClean($request, MySQLLib::makeConnection());
	
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
		      return deploy($request['file_name'], $request['host_name'], $request['config'], $request['name']);
		
	}
	return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$server = new rabbitMQServer("testRabbitMQ.ini","deploymentServer");
$server->process_requests('requestProcessor');
exit();
?>

