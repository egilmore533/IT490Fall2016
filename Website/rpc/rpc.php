Hi
<?php

require_once("path.inc");
require_once('request.php');

$request = array();
$request["request"] = "login";
$request = json_decode(file_get_contents("php://input"),true);

sendRequest($request);

?>