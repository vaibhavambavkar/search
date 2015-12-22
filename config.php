<?php
$link = mysql_connect('mysql77757-env-3332420.jelasticlw.com.br ', 'root', '26dZNC81L7');
//if connection is not successful you will see text error
if (!$link) {
       die('Could not connect: ' . mysql_error());
}
//if connection is successfuly you will see message bellow
echo 'Connected successfully';
 
mysql_close($link);
?>
