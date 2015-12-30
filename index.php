
<!doctype html public "-//w3c//dtd html 3.2//en">
<html>
<head>
<title> keyword search in relational databases</title>
<META NAME="DESCRIPTION" CONTENT=" ">
<META NAME="KEYWORDS" CONTENT="">
<link rel="stylesheet" href="style.css" type="text/css">
<script type="text/javascript">

function ajaxFunction(val)
{

var httpxml;

try
  {
  
  httpxml=new XMLHttpRequest();
  }
catch (e)
  {
 
  try
    {
    httpxml=new ActiveXObject("Msxml2.XMLHTTP");
    }
  catch (e)
    {
    try
      {
      httpxml=new ActiveXObject("Microsoft.XMLHTTP");
      }
    catch (e)
      {
      alert("Your browser does not support AJAX!");
      return false;
      }
    }
  }
function stateChanged() 
{
if(httpxml.readyState==4)
      {


var myarray = JSON.parse(httpxml.responseText);

for(j=document.getElementById('title').length-1;j>=0;j--)
{
document.getElementById('title').remove(j);
}
var str='';
var result='';
for (i=0;i<myarray.data.length;i++)
{
str += '<option value="'+myarray.data[i].title+'" />';
result += '<a href='+myarray.data[i].file+'>'+myarray.data[i].title+'</a><br>'+ myarray.data[i].des + '<br>'+ myarray.data[i].file + '<br><br>';
} 


document.getElementById("title").innerHTML= str;
document.getElementById("result").innerHTML= result  ;

if(myarray.value.status1 != 'T'){
document.getElementById("msg").innerHTML="About " + myarray.value.no_records2 + " & " + myarray.value.no_records + " results " + " Message : "+ myarray.value.message;
}else{
document.getElementById("msg").innerHTML="About " + myarray.value.no_records2 + " & " + myarray.value.no_records  + " results " ;
}
var endrecord=myarray.value.endrecord 

document.getElementById("navigation").innerHTML= "<table width=700><tr><td width=350><input type=button id=\'back\' value=Prev onClick=\"ajaxFunction('bk'); return false\"></td><td width=350 align=right><input type=button value=Next id=\"fwd\" onClick=\"ajaxFunction(\'fw\');  return false\"></td></tr></tr> </table>";


myForm.st.value=endrecord;
if(myarray.value.end =="yes"){ document.getElementById("fwd").style.display='inline';
}else{document.getElementById("fwd").style.display='none';}


if(myarray.value.startrecord =="yes"){ document.getElementById("back").style.display='inline';
}else{document.getElementById("back").style.display='none';}

      }
    }

	var url="search-backend.php";
var str=document.getElementById("keyword").value;
var myendrecord=myForm.st.value;

url=url+"?txt="+str;
url=url+"&endrecord="+myendrecord;
url=url+"&direction="+val;
url=url+"&sid="+Math.random();
//document.getElementById("txtHint").innerHTML=url
httpxml.onreadystatechange=stateChanged;
httpxml.open("GET",url,true);
httpxml.send(null);
document.getElementById("msg").innerHTML="Please Wait ...";
document.getElementById("msg").style.display='inline';




}
</script>


</head>

<body>
<div id=msg style="position:absolute; width:300px; height:25px; 
z-index:1; left: 400px; top: 0px; 
border: 1px none #000000"></div>

<br><br><br><form name="myForm">
<input type=hidden name=st value=0>
<input type="text" onkeyup="ajaxFunction('');" name="keyword" id="keyword" list="title"  size=70/> 
 
<datalist id="title" >
  </datalist>

<br><br>
<div class='t1' id='result'>
</div>
</form>

<div class='t1' id='navigation'>
</div>



</body>

</html>
<?php
$host_name = "mysql77757-env-3332420.jelasticlw.com.br";
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
@$search_text=$_GET['txt'];

@$end_record=$_GET['endrecord'];

if(strlen($end_record) > 0 AND (!is_numeric($end_record)))

{
echo "Input Data Error 1";
exit;
} 

$limit=10; 

if($end_record < $limit) {$end_record = 0;
}

switch(@$_GET['direction'])  

{
case "fw":
$start_record = $end_record ;
break;

case "bk":
$start_record = $end_record - 2*$limit;
break;

default:

$start_record=0;
break;

}


if($start_record < 0){$start_record=0;

}
$end_record =$start_record+$limit;




$search_text=trim($search_text);
$message = '';

$query='';
$query2='';


$kt=preg_split("/[\s,]+/",$search_text);



while(list($key,$val)=each($kt))

{
if(!ctype_alnum($val))

{
$message .= "objects summary record ";

$main = array('value'=>array("message"=>"$message"));

exit(json_encode($main));
}



if($val<>" " and strlen($val) > 0){$query .= " title like '%$val%' or ";
$query2 .= " title like '%$val%' and ";
}
}

$query=substr($query,0,(strLen($query)-3));
$query2=substr($query2,0,(strLen($query2)-4));


$q="select count(file_id) from paper where ". $query ;
$q2="select count(file_id) from paper where ". $query2 ;
$query= 'select title,file_id,file,des from paper where '. $query . " limit $start_record,$limit " ;
$query2= 'select title,file_id,file,des from paper where '. $query2 . " limit $start_record,$limit " ;


$message .=$query;
$records_found = $dbo->query($q)->fetchColumn(); 
$records_found2 = $dbo->query($q2)->fetchColumn(); 

$records_found_total=$records_found + $records_found2;
$row=$dbo->prepare($query);
$row->execute();
$result=$row->fetchAll(PDO::FETCH_ASSOC);

$row2=$dbo->prepare($query2);
$row2->execute();
$result2=$row2->fetchAll(PDO::FETCH_ASSOC);


$result=array_merge($result2,$result);

if(($end_record) < $records_found_total ){$end="yes";}
else{$end="no";}

if(($end_record) > $limit ){$startrecord="yes";}
else{$startrecord="no";}


$main = array('data'=>$result,'value'=>array("no_records"=>"$records_found","no_records2"=>"$records_found2","message"=>"$message","status1"=>"T","endrecord"=>"$end_record","limit"=>"$limit","end"=>"$end","startrecord"=>"$startrecord" ));
echo json_encode($main);
?>
