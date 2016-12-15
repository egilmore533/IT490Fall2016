#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require_once('requestClean.php.inc');
require_once('deploymentRequestLib.php.inc');

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
		      return DeploymentRequest::insertBundle($request['version_name']);
                case "version_number":
		      return DeploymentRequest::bundle($request['version_name']);
                case "deploy_and_install":
		      return DeploymentRequest::deploy($request['file_name'], $request['host_name'], $request['config'], $request['name']);
		
	}
	return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$server = new rabbitMQServer("testRabbitMQ.ini","deploymentServer");
$server->process_requests('requestProcessor');
exit();
?>

