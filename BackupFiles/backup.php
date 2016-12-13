#!/usr/bin/php
<?php

$host = '10.200.20.158';
$ports = array(7000, 7001);
while(true)
{
    foreach ($ports as $port)
    {
        $connection = @fsockopen($host, $port);

        if (is_resource($connection))
        {
            echo '<h2>' . $host . ':' . $port . ' ' . '(' . getservbyport($port, 'tcp') . ') is open.</h2>' . "\n";

            fclose($connection);
        }

        else
        {
            echo '<h2>' . $host . ':' . $port . ' is not responding.</h2>' . "\n";
        }
    }
}
?>