<?php

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require_once('SessionManager.php.inc');

$request = array();
$request["request"] = "login";
$request = json_decode(file_get_contents("php://input"),true);

switch($request["request"])
{
    case "login":
	$username = $request['username'];
	$password = sha1($request['password']);
	$login = new rabbitMQClient("testRabbitMQ.ini","testServer");
	
	$requestArr = array();
	$requestArr["type"] = "login";
	$requestArr["username"] = $username;
	$requestArr['password'] = $password;
	
	$response = $login->send_request($requestArr);
	if ($response["success"]==true)
	{  
            SessionManager::sessionStart('PokemonBets');
            $_SESSION['user'] = $username;
            $_SESSION['balance'] = $response["balance"];
            $_SESSION['wins'] = $response['wins'];
            
            header("Location: myaccount.php"); 
            $response["message"] = "Login Successful! ".$response["message"];
            
            
            
	}
	else
	{
            $response["message"] = "Login Failed!";
	}
	break;
    case "register":
        $username = $request['username'];
	$password = sha1($request['password']);
	$login = new rabbitMQClient("testRabbitMQ.ini","testServer");
	
	$requestArr = array();
	$requestArr["type"] = "register";
	$requestArr["username"] = $username;
	$requestArr['password'] = $password;
	
	$response = $login->send_request($requestArr);
        if ($response["success"]==true)
	{
            $response["message"] = "Register Successful: ".$response["message"];
	}
	else
	{
            $response["message"] = "Register Failed: ".$response["message"];
	}
	break;
    case "addFunds":
	$login = new rabbitMQClient("testRabbitMQ.ini","testServer");
	
	SessionManager::sessionStart('PokemonBets');
	$requestArr = array();
	$requestArr["type"] = "addfunds";
	$requestArr["username"] = $_SESSION['user'];
	$requestArr["funds"] = $request["funds"];
	
	$response = $login->send_request($requestArr);
        if ($response["success"]==true)
	{
            $_SESSION['balance'] = $response["message"];
            $response["message"] = $_SESSION['balance'];
	}
	else
	{
            $response["message"] = "Failed to add $".$request["funds"];
	}
	break;
    case "fh":
	$login = new rabbitMQClient("testRabbitMQ.ini","testServer");
	
	SessionManager::sessionStart('PokemonBets');
	$requestArr = array();
	$requestArr["type"] = "fh";
	
	$response = $login->send_request($requestArr);
        if ($response["success"]==true)
	{
	}
	else
	{
            $response["message"] = "Failed.";
	}
	break;
}
    echo json_encode($response['message']);
?>