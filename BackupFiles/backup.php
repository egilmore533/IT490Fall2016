#!/usr/bin/php
<?php

$host = '128.235.24.215';
$ports = array(7000);


while(true)
{
    $backup = false;

    foreach ($ports as $port)
    {
        $connection = @fsockopen($host, $port);

        if (is_resource($connection))
        {
            echo '<h2>' . $host . ':' . $port . ' ' . '(' . getservbyport($port, 'tcp') . ') is open.</h2>' . "\n";
            
            if($backup == true)
                shell_exec('killall -9 test.php');
                //shell_exec('killall -9 MySqlConnection.php');
            
            $backup = false;
            
            fclose($connection);
        }

        else
        {
            
            if($backup == false)
            {
                    echo '<h2>' . $host . ':' . $port . ' is not responding.</h2>' . "\n";
                    //require_once ('MySqlConnection.php');
                    require('test.php');
                    
                    $backup = true;
            }
        
        }
    }
}
?>