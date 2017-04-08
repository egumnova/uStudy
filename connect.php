<?php
$server = 'localhost';
$username = 'root';
$password = '%iHe&0ET8lFt';
$database = 'Forum';
if(!mysql_connect($server, $username, $password))
{
  exit('Error: no connection to the server'); 
}
if(!mysql_select_db($database))
{
  exit('Error: could not select the database');
}
 ?>
