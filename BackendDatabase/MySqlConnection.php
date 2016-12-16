#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require_once('MySQLLib.php.inc');
require_once('requestClean.php.inc');
require_once('backendRequestLib.php.inc');

function requestProcessor($request)
{
    echo "received request".PHP_EOL;

    $request=ArrayClean::multidimensionalArrayClean($request,MySQLLib::makeConnection());

    if(!isset($request['type']))
    {
        return "ERROR: request type not set";
    }
    switch ($request['type'])
    {
        case "login":
            return BackendRequest::doLogin($request['username'],$request['password']);
        case "register":
            return BackendRequest::register($request['username'],$request['password']);
        case "addfunds":
            return BackendRequest::addfunds($request['username'], $request['funds']);
        case "validate_session":
            return BackendRequest::doValidate($request['sessionId']);
        case "fh":
            return BackendRequest::fightHistory();
        case "bh":
            return BackendRequest::betHistory($request['user']);
        case "sched":
            return BackendRequest::schedule();
        case "tdb":
            return BackendRequest::trainers($request['trainer']);
        case "wdfunds":
            return BackendRequest::withdraw($request['username'], $request['funds']);
        case "placebet":
            return BackendRequest::placebet($request['username'], $request['fid'], $request['tid'], $request['funds']);
        case "league":
            return BackendRequest::leagues();
        case "cl":
            return BackendRequest::createLeague($request["leaguename"], $request["entryfee"], $request["username"]);
        case "jl":
            return BackendRequest::joinLeague($request["leagueid"], $request["username"]);
        case "lh":
            return BackendRequest::leagueHistory($request['user']);
        case "leaguehome":
            return BackendRequest::leagueHome($request['user'], $request['leagueid']);
        case "ct":
            var_dump($request['leagueid']);
            return BackendRequest::createTeam($request['username'], $request['number'], $request['leagueid'],$request['trainerid']);
        
            
        default:
            return "ERROR: unsupported message type.";
    }
    return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$server = new rabbitMQServer("testRabbitMQ.ini","pokeServer");
$server->process_requests('requestProcessor');
exit();
?>
