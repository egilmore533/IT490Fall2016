#!/usr/bin/php
<?php

include 'requests.php';


function bundle($argv)
{

$ini_file=$argv[2];
$ini_array=parse_ini_file($ini_file);

$name=$ini_array['PACKAGE_NAME'];

$request=array();
$request['type']="version_number";
$request['version_name']=$name;

$response = make_deployment_machine_request($request);

$version=$response['version_number'];
$package_name=$name.$version;
$directory="/var/packages/$package_name";

shell_exec("mkdir $directory");

$source_directory=$ini_array['SOURCE_DIRECTORY'];
foreach($ini_array['FILES'] as $file)
{
	shell_exec("scp $source_directory$file $directory");
}

shell_exec("scp $source_directory$ini_file $directory");

shell_exec("tar -czvf $package_name.tar.gz -C $directory .");
shell_exec("mv $package_name.tar.gz $directory");

$user=$ini_array['USER'];
$pass=$ini_array['PASSWORD'];
$ipaddress=$ini_array['IP_ADDRESS'];

$bundle_request = array();
$bundle_request['type'] = 'bundle';
$bundle_request['version_name'] = $package_name;

$response = make_deployment_machine_request($bundle_request);

}


function deploy($argv)
{
	$request = array();
	$request['type'] = "deploy_and_install";
	$request['ip_address'] = $argv[2];
	$request['name'] = $argv[3];
	$request['version_number'] = $argv[4];
	$request['file_name'] = "$argv[3]$argv[4]";
	$request['config'] = $argv[5];
	var_dump($request);
	var_dump(make_deployment_machine_request($request));
}

var_dump($argv);

if($argv[1] == 'bundle')
{	bundle($argv);	}
if($argv[1] == 'deploy')
{	 deploy($argv);	}

?>

