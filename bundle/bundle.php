#!/usr/bin/php
<?php

include 'deployment_request.php';


$name="test";

$request=array();
$request['type']="version_number";
$request['version_name']=$name;

$response = make_request($request);

$version=$response['version_number'];
$package_name=$name.$version;
$directory="/var/packages/$package_name";

shell_exec("mkdir $directory");

//get file paths from config file

$source_directory="/var/packages/replace_tools.php";
shell_exec("scp $source_directory $directory");

shell_exec("tar -czvf $package_name.tar.gz -C $directory .");
shell_exec("mv $package_name.tar.gz $directory");

$ipaddress = "10.200.20.136";
shell_exec("scp $directory.tar.gz steven@$ipaddress:$directory");

?>

