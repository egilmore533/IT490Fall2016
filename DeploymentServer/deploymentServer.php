#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function deploy($versionNum)
{
    $ipaddress = '127.0.0.1';
    $localLocation = '/var/packages';
    $QALocation = '/var/packages';

    //get versionNum
        
	shell_exec("scp $localLocation root@$ipaddress:$QALocation");
}

function install()
{
        return array ("success" => '1', 'message'=>"Please Install Package");
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
