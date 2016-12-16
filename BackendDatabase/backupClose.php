#!/usr/bin/php
<?php

$host = '10.200.44.148';
$ports = array(7000);
$backup = false;

while(true)
{

    foreach ($ports as $port)
    {
        $connection = @fsockopen($host, $port);

        if (is_resource($connection))
        {
            echo '<h2>' . $host . ':' . $port . ' ' . '(' . getservbyport($port, 'tcp') . ') is open.</h2>' . "\n";
            
            if($backup == true)
                shell_exec('killall -9 MySqlConnection.php');
            
            $backup = false;
            
            fclose($connection);
        }

        else
        {
            
            if($backup == false)
            {
                    echo '<h2>' . $host . ':' . $port . ' is not responding.</h2>' . "\n";
                    echo 'Server is Running' . "\n";
                    
                    $backup = true;
            }
        
        }
    }
}
?>