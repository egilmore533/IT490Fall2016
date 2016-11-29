<?php

require_once('rabbitMQLib.inc');
require_once('SessionManager.php.inc');

function sendRequest($request)
{
    $client = new rabbitMQClient("pokeRabbitMQ.ini","pokeServer");

    switch($request["request"])
    {
        case "login":
            $username = $request['username'];
            $password = sha1($request['username'].$request['password']); 
            
            $requestArr = array();
            $requestArr["type"] = "login";
            $requestArr["username"] = $username;
            $requestArr['password'] = $password;
            
            $response = $client->send_request($requestArr);
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
            
            $requestArr = array();
            $requestArr["type"] = "register";
            $requestArr["username"] = $username;
            $requestArr['password'] = $password;
            
            $response = $client->send_request($requestArr);
            if ($response["success"]==true)
            {
                $response["message"] = "Register Successful. You may login now.";
            }
            else
            {
                $response["message"] = "Register Failed. Username Taken.";
            }
            break;
        case "addFunds":
            
            SessionManager::sessionStart('PokemonBets');
            $requestArr = array();
            $requestArr["type"] = "addfunds";
            $requestArr["username"] = $_SESSION['user'];
            $requestArr["funds"] = $request["funds"];
            
            $response = $client->send_request($requestArr);
            if ($response["success"]==true)
            {
                $_SESSION['balance'] = $response["message"];
                $response["message"] = $_SESSION['balance'];
            }
            else
            {
                $response["message"] = "Failed to add $".$request["funds"].".".$request["message"];
            }
            break;
        case "wdFunds":
            
            SessionManager::sessionStart('PokemonBets');
            $requestArr = array();
            $requestArr["type"] = "wdfunds";
            $requestArr["username"] = $_SESSION['user'];
            $requestArr["funds"] = $request["funds"];
            
            $response = $client->send_request($requestArr);
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
            
            $requestArr = array();
            $requestArr["type"] = "fh";
            
            $response = $client->send_request($requestArr);
            if ($response["success"]==true)
            {
            }
            else
            {
                $response["message"] = "Failed to show fight history.";
            }
            break;
        case "sched":
            
            $requestArr = array();
            $requestArr["type"] = "sched";
            
            $response = $client->send_request($requestArr);
            if ($response["success"]==true)
            {
            }
            else
            {
                $response["message"] = "Failed to show fight schedule";
            }
            break;
        case "bh":
            
            SessionManager::sessionStart('PokemonBets');
            $requestArr = array();
            $requestArr["type"] = "bh";
            $requestArr["user"] = $_SESSION['user'];
            
            $response = $client->send_request($requestArr);
            if ($response["success"]==true)
            {
                $_SESSION['balance'] = $response["funds"];
            }
            else
            {
                $response["message"] = "Failed to show bet history. ".$response["message"];
            }
            break;
        case "tdb":
            
            SessionManager::sessionStart('PokemonBets');
            $requestArr = array();
            $requestArr["type"] = "tdb";
            $requestArr["trainer"] = $request['trainer'];
            
            $response = $client->send_request($requestArr);
            if ($response["success"]==true)
            {
            }
            else
            {
                $response["message"] = "Failed: ".$response["message"];
            }
            break;
        case "placebet":
            
            SessionManager::sessionStart('PokemonBets');
            $requestArr = array();
            $requestArr["type"] = "placebet";
            $requestArr["username"] = $_SESSION['user'];
            $requestArr["fid"] = $request['fid'];
            $requestArr["tid"] = $request['tid'];
            $requestArr["funds"] = $request['funds'];
            
            $response = $client->send_request($requestArr);
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
}
?>