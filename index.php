<!doctype html public "-//w3c//dtd html 3.2//en">
<html>
<head>
<title> keyword search in relational databases</title>
<META NAME="DESCRIPTION" CONTENT=" ">
<META NAME="KEYWORDS" CONTENT="">
<link rel="stylesheet" href="https://github.com/vaibhavambavkar/search/blob/master/style.css" type="text/css">
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
