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
                header("refresh:1;url=localhost");
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
                $_SESSION['balance'] = $response["funds"];
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
        case "league":
            $requestArr = array();
            $requestArr["type"] = "league";
            
            $response = $client->send_request($requestArr);
            if ($response["success"]==true)
            {
            }
            else
            {
                $response["message"] = "Failed to get League Tables";
            }
            break;
        case "cl":
            $requestArr = array();
            SessionManager::sessionStart('PokemonBets');
            $requestArr["type"] = "cl";
            $requestArr["leaguename"] = $request['name'];
            $requestArr["entryfee"] = $request['fee'];
            $requestArr["username"] = $_SESSION['user'];
            
            $response = $client->send_request($requestArr);
            if ($response["success"]==true)
            {
                $response["message"] = "League Created!";
            }
            else
            {
                $response["message"] = "Failed to Create League";
            }
            break;
        case "jl":
            $requestArr = array();
            SessionManager::sessionStart('PokemonBets');
            $requestArr["type"] = "jl";
            $requestArr["leagueid"] = $request['lid'];
            $requestArr["username"] = $_SESSION['user'];
            
            $response = $client->send_request($requestArr);
            if ($response["success"]==true)
            {
                $response["message"] = "League Joined!";
            }
            else
            {
                $response["message"] = "Failed to Join League";
            }
            break;
        case "lh":
            SessionManager::sessionStart('PokemonBets');
            $requestArr = array();
            $requestArr["type"] = "lh";
            $requestArr["user"] = $_SESSION['user'];
            
            $response = $client->send_request($requestArr);
            if ($response["success"]==true)
            {
            }
            else
            {
                $response["message"] = "Failed to show league history. ".$response["message"];
            }
            break;
        case "leaguehome":
            SessionManager::sessionStart('PokemonBets');
            $requestArr = array();
            $requestArr["type"] = "leaguehome";
            $requestArr["user"] = $_SESSION['user'];
            $requestArr["leagueid"] = $request['leagueid'];
            
            $response = $client->send_request($requestArr);
            if ($response["success"]==true)
            {
                $_SESSION['leaguename'] = $response["leaguename"];
                $response["message"] = $response["message"];
            }
            else
            {
                $response["message"] = "Failed to show league home data. ".$response["message"];
            }
            break;
        
    }
        echo json_encode($response['message']);
}
?>
