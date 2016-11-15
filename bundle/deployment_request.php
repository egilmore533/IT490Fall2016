#!usr/bin/php
<?php

require_once('rabbitMQLib.inc');

function make_request($request)
{
	$connect = new RabbitMQClient("deployment.ini","deploymentServer");
	return $connect->send_request($request);
}



?>


