<?php


$host_name = "localhost";
$database = "student"; 
$username = "root";          
$password = "mysql";          

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
