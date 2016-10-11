<?php
require_once('/../../../git/rabbitmqphp_example/path.inc');
require_once('/../../../git/rabbitmqphp_example/get_host_info.inc');
require_once('/../../../git/rabbitmqphp_example/rabbitMQLib.inc');

$client = new rabbitMQClient("testRabbitMQ.ini","testServer");
if ($_GET["user"] || $_GET["passwd"])
{
  $user = $_GET["user"];
  $passwd = sha1($_GET["passwd"]);
}
else
{
  $msg = "test message";
}



<html>
   <body>
   
      <form action = "<?php $_PHP_SELF ?>" method = "GET">
         Username: <input type = "text" name = "user" />
         Password: <input type = "text" name = "passwd" />
         <input type = "submit" />
      </form>
      
   </body>
</html>
