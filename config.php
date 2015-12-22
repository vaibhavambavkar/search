<?php
$link = mysql_connect('mysql77757-env-3332420.jelasticlw.com.br', 'root', '26dZNC81L7');
if (!$link)
{
echo "<h2>MySQL Error!</h2>";
 exit;
}
 
// Choose database:
$db="file";
mysql_select_db($db);
// table header output:
echo "<table border=\"1\" width=\"100%\" bgcolor=\"#FFFFE1\">";
echo "<tr><td>Value1</td><td>Value2</td><td>Value3</td>";
// SQL-request:
$q = mysql_query ("SELECT * FROM file;");
// table-result output
for ($c=0; $c<mysql_num_rows($q); $c++)
{
echo "<tr>";
$f = mysql_fetch_array($q); // Returns an array that corresponds to the fetched row and moves the internal data pointer ahead.
echo "<td>$f[0]</td><td>$f[1]</td><td>$f[5]</td>";
echo "</tr>";
}
echo "</table>";
?>
