#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function doLogin($username,$password)
{
//MySQL Connection
$servername = "localhost";
$DBuser = "it490";
$DBpass = "whoGivesaFuck!490";
$database = "userlogin";

var_dump($servername);
//Create connection
$conn = new mysqli($servername, $DBuser, $DBpass, $database);

//Check Connection
if($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
}
else
{
$s = "SELECT * FROM userlogin";
($result = mysqli_query($conn, $s)) or die (mysqli_error());
        echo "Connected Successfully";
}
//MySQL Connection
    // lookup username and password in database
	while($r=mysqli_fetch_array($result))
{
	$usernameDB = $r["username"];
	$passwordDB = $r["password"]; 
	var_dump($usernameDB);
	var_dump($passwordDB);
	var_dump($username);
	var_dump($password);
	if($username == $usernameDB && $password == $passwordDB)
{
		echo "Access Granted";
		return array("success" => true, 'message'=>"Server received request and processed");
    //return false if not valid
		break;
}
else 
{
echo "Access Denied";
return array("success" => false, 'message'=>"Server received request and processed");
    //return false if not valid

break;
}
}
    return array("success" => true, 'message'=>"Server received request and processed");
    //return false if not valid
}

function requestProcessor($request)
{
  echo "received request".PHP_EOL;
  var_dump($request);
  if(!isset($request['type']))
  {
    return "ERROR: unsupported message type";
  }
  switch ($request['type'])
  {
    case "login":
      return doLogin($request['username'],$request['password']);
    case "validate_session":
      return doValidate($request['sessionId']);
  }
  return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$server = new rabbitMQServer("testRabbitMQ.ini","testServer");

$server->process_requests('requestProcessor');
exit();
?>

