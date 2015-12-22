<?php
$link = mysql_connect('mysql77757-env-3332420.jelasticlw.com.br', 'root', '26dZNC81L7');
if (!$link)
{
echo "<h2>MySQL Error!</h2>";
 exit;
}
 
// Choose database:
$db="student";
mysql_select_db($db);
?>
