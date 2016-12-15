#!/usr/bin/php
<?php
require_once('path.inc');
require_once('rabbitMQLib.inc');

function install($n, $v, $c)
{   
    shell_exec("mkdir -p /var/packages/$n/$v");
    if(file_exists("/var/packages/$n$v.tar.gz"))
    {
        shell_exec("mv /var/packages/$n$v.tar.gz /var/packages/$n/$v");
        $package = "/var/packages/$n/$v/$n$v.tar.gz";
        shell_exec("tar -xvzf $package -C /var/packages/$n/$v");
        $ini_array = parse_ini_file("/var/packages/$n/$v/$c");
        
        $source_dir = $ini_array['SOURCE_DIRECTORY'];
        foreach($ini_array['FILES'] as $file)
        {
            shell_exec("scp /var/packages/$n/$v/$file $source_dir$file");
            var_dump($file);
        }

        return array ("success" => '1', 'message'=>"Package installed.");
    }
    else
    {
        return array ("success" => '0', 'message'=>"File does not exist.");
    }
}

function requestProcessor($request)
{
    echo "received request".PHP_EOL;
    
    if(!isset($request['type']))
    {
        return "ERROR: unsupported message type";
    }
    if($request['type'] == "install")
    {
        $name = $request['name'];
        $version = $request['number'];
        $config = $request['config'];
        var_dump($request);
        return install($name, $version, $config);
    }
    return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$server = new rabbitMQServer("installer.ini","installServer");
$server->process_requests('requestProcessor');
exit();
?>