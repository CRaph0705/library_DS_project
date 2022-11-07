<?php
require_once ('config.php');

 
session_start(); //pour être sûr d'utiliser la même session
session_destroy(); //fin de session
header("location:/index.php"); 
exit();

?>
