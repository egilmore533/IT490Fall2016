<?php
require_once('SessionManager.php.inc');
SessionManager::sessionStart('PokemonBets');   
unset($_SESSION['user']); 
session_destroy();
session_unset();
ob_start();
header("location:http://www.pokefights.com/");
ob_end_flush(); 

exit();
?>