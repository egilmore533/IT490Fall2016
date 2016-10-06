#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function doLogin($db,$username,$password)
{
    //clean up inputs
    $username = stripslashes($username);
    $password = stripslashes($password);
    $username = mysqli_real_escape_string($username);
    $password = mysqli_real_escape_string($password);

    //have to select databse here $db = mysql_select_db("company", $db); //not sure if i should make the variable different or not
    //sql query to find info of registered users and find a match to given info
    $statement = "select * from userlogin where password='$password' AND username='$username'";
    $query = mysqli_query($statement, $db);
    $rows = mysqli_num_rows($query);
    
    if($rows == 1)
    {
       //add validation for session id
       return true;
    }
else
{
	return false;
}
}

function doRegister($db,$username,$password)
{
    //clean up inputs
    $username = stripslashes($username);
    $password = stripslashes($password);
    $username = mysqli_real_escape_string($username);
    $password = mysqli_real_escape_string($password);

    //sql query to add user to database
    $statement = "INSERT INTO userlogin (username, password) VALUES ('$username', '$password')";
    $query = $mysqli_query($db, $statement);
    if($query) { 
	return false; 
	
    }
    else { return false; }
}

function requestProcessor($request)
{
  echo "received request".PHP_EOL;
  var_dump($request);
  if(!isset($request['type']))
  {
    return "ERROR: unsupported message type";
  }

  //this needs to log into the back end's databse also the actual password and everything should probably be in a differnet file or hidden or something 
  $db = mysqli_connect("servername","mysql_username","mysql_password");


  switch ($request['type'])
  {
    case "login":
      return doLogin($db,$request['username'],$request['password']);
    case "validate_session":
      return doValidate($request['sessionId']);
    case "Register":
      return doRegsiter($db,$request['username'],$request['password'])
  }
  return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$server = new rabbitMQServer("testRabbitMQ.ini","testServer");

$server->process_requests('requestProcessor');
exit();
?>

