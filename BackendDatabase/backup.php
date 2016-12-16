#!/usr/bin/php
<?php

$host = '128.235.25.1';
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