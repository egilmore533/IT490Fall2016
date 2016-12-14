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

    $request=ArrayClean::multidimensionalArrayClean($array,MySQLLib::makeConnection());

    if(!isset($request['type']))
    {
        return "ERROR: request type not set";
    }
    switch ($request['type'])
    {
        case "login":
            return BackendRequestLib::doLogin($request['username'],$request['password']);
        case "register":
            return BackendRequestLib::register($request['username'],$request['password']);
        case "addfunds":
            return BackendRequestLib::addfunds($request['username'], $request['funds']);
        case "validate_session":
            return BackendRequestLib::doValidate($request['sessionId']);
        case "fh":
            return BackendRequestLib::fightHistory();
        case "bh":
            return BackendRequestLib::betHistory($request['user']);
        case "sched":
            return BackendRequestLib::schedule();
        case "tdb":
            return BackendRequestLib::trainers($request['trainer']);
        case "wdfunds":
            return BackendRequestLib::withdraw($request['username'], $request['funds']);
        case "placebet":
            return BackendRequestLib::placebet($request['username'], $request['fid'], $request['tid'], $request['funds']);
        case "league":
            return BackendRequestLib::leagues();
        case "cl":
            return BackendRequestLib::createLeague($request["leaguename"], $request["entryfee"], $request["username"]);
        case "jl":
            return BackendRequestLib::joinLeague($request["leagueid"], $request["username"]);
        case "lh":
            return BackendRequestLib::leagueHistory($request['user']);
        case "leaguehome":
            return BackendRequestLib::leagueHome($request['user'], $request['leagueid']);
        default:
            return "ERROR: unsupported message type.";
    }
    return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$server = new rabbitMQServer("testRabbitMQ.ini","pokeServer");
$server->process_requests('requestProcessor');
exit();
?>
