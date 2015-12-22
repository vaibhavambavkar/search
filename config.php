<?php


$host_name = "mysql77757-env-3332420.jelasticlw.com";
$username = "root";          
$password = "26dZNC81L7";          
$database = "student"; 
try 
{

$dbo = new PDO('mysql:host='.$host_name.';dbname='.$database, $username, $password);

} 
catch (PDOException $e) 

{
print "Error!: " . $e->getMessage() . "<br/>";
die();
}


?>
