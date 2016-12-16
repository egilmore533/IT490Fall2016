#!/usr/bin/php
<?php

$host = '10.200.44.148';
$ports = array(7000);


while(true)
{
    $backup = false;

    foreach ($ports as $port)
    {
        $connection = @fsockopen($host, $port);

        if (is_resource($connection))
        {
            $backup = false;
            
            fclose($connection);
        }

        else
        {
            
            if($backup == false)
            {
                    echo '<h2>' . $host . ':' . $port . ' is not responding.</h2>' . "\n";
                    shell_exec('./MySqlConnection.php');
                    
                    $backup = true;
            }
        
        }
    }
}
?>