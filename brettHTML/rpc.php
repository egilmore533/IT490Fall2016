<?php

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

$request = array();
$request["request"] = "login";
$request = json_decode(file_get_contents("php://input"),true);
$response = "error unrecognized request";
switch($request["request"])
{
    case "login":
	$username = $request['username'];
	$password = $request['password'];
	$login = new rabbitMQClient("testRabbitMQ.ini","testServer");
	
	$requestArr = array();
	$requestArr["type"] = "login";
	$requestArr["username"] = $username;
	$requestArr['password'] = $password;
	
	$response = $login->send_request($requestArr);
	if ($response["success"]==true)
	{
		$response["message"] = "Login Successful: ".$response["message"];
	}
	else
	{
		$response["message"] = "Login Failed: ".$response["message"];
	}
	echo "client received message: " .PHP_EOL;
	
	break;
	
	
}
echo json_encode($response['message']);
?>