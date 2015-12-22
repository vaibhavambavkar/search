<?Php

require "config.php";

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
$message .= "Input Data Error 2 ";

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
