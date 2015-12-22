<?php


$host_name = "localhost";
$database = "student"; 
$username = "root";          
$password = "26dZNC81L7";          

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
