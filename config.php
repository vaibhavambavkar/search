
<?php

$link = mysql_connect('mysql77757-env-3332420.jelasticlw.com.br', 'root', '26dZNC81L7');
if (!$link) {
    die('Not connected : ' . mysql_error());
}

// make foo the current db
$db_selected = mysql_select_db('student', $link);
if (!$db_selected) {
    die ('Can\'t use foo : ' . mysql_error());
}
?>
