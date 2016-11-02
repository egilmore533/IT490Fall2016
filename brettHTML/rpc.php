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
	$password = sha1($request['username'].$request['password']);

	$login = new rabbitMQClient("pokeRabbitMQ.ini","pokeServer");
	
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
            
            $response["message"] = "Login Successful! ".$response["message"];
   
	}
	else
	{
            $response["message"] = "Login Failed!";
	}
	break;
    case "register":
        $username = $request['username'];
	$password = sha1($request['username'].$request['password']);
	$login = new rabbitMQClient("pokeRabbitMQ.ini","pokeServer");
	
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
	$login = new rabbitMQClient("pokeRabbitMQ.ini","pokeServer");
	
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
    case "wdFunds":
	$login = new rabbitMQClient("pokeRabbitMQ.ini","pokeServer");
	
	SessionManager::sessionStart('PokemonBets');
	$requestArr = array();
	$requestArr["type"] = "wdfunds";
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
            $response["message"] = "Failed to withdraw $".$request["funds"];
	}
	break;
    case "fh":
	$login = new rabbitMQClient("pokeRabbitMQ.ini","pokeServer");
	
	$requestArr = array();
	$requestArr["type"] = "fh";
	
	$response = $login->send_request($requestArr);
        if ($response["success"]==true)
	{
	}
	else
	{
            $response["message"] = "Failed to show fight history.";
	}
	break;
    case "sched":
	$login = new rabbitMQClient("pokeRabbitMQ.ini","pokeServer");
	
	$requestArr = array();
	$requestArr["type"] = "sched";
	
	$response = $login->send_request($requestArr);
        if ($response["success"]==true)
	{
	}
	else
	{
            $response["message"] = "Failed to show fight schedule";
	}
	break;
    case "bh":
	$login = new rabbitMQClient("pokeRabbitMQ.ini","pokeServer");
	
	SessionManager::sessionStart('PokemonBets');
	$requestArr = array();
	$requestArr["type"] = "bh";
	$requestArr["user"] = $_SESSION['user'];
	
	$response = $login->send_request($requestArr);
        if ($response["success"]==true)
	{
	}
	else
	{
            $response["message"] = "Failed to show bet history";
	}
	break;
    case "tdb":
	$login = new rabbitMQClient("pokeRabbitMQ.ini","pokeServer");
	
	SessionManager::sessionStart('PokemonBets');
	$requestArr = array();
	$requestArr["type"] = "tdb";
	$requestArr["trainerid"] = $request['trainerid'];
	
	$response = $login->send_request($requestArr);
        if ($response["success"]==true)
	{
	}
	else
	{
            $response["message"] = "Failed.";
	}
	break;
    case "placebet":
	$login = new rabbitMQClient("pokeRabbitMQ.ini","pokeServer");
	
	SessionManager::sessionStart('PokemonBets');
	$requestArr = array();
	$requestArr["type"] = "placebet";
	$requestArr["username"] = $_SESSION['user'];
	$requestArr["fid"] = $request['fid'];
	$requestArr["tid"] = $request['tid'];
	$requestArr["funds"] = $request['funds'];
	
	$response = $login->send_request($requestArr);
        if ($response["success"]==true)
	{
            $_SESSION['balance'] = $response["message"];
            $response["message"] = $_SESSION['balance'];
	}
	else
	{
            $response["message"] = "Failed to place bets with $".$request["funds"];
	}
	break;
    
}
    echo json_encode($response['message']);
?>