#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function fightHistory()
{
    echo "hi";

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
		case "fh":
		      return fightHistory();

	}
	return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$server = new rabbitMQServer("fightHistoryRabbitMQ.ini","fightHistoryServer");
$server->process_requests('requestProcessor');
exit();
?>