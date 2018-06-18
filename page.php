<?php

require 'connect.php';
$q="select * from users";
$r= mysqli_query($dbc, $q);
$count= mysqli_num_rows($r);
$page=$_GET['page'];
echo $count;
$page_len=5; //including suspension points, count of page numbers in a page
$pagesize=1; //count of record shwon per page
  $st=null;//string to print page number
    $startindex=($page-1)*$pagesize;
$sql="select * from users ORDER BY user_id LIMIT $startindex,$pagesize";
$result = mysqli_query($dbc,$sql);
if (!$result) {
 printf("Error: %s\n", mysqli_error($dbc));
 exit();
}
   while( $row=mysqli_fetch_array($result,MYSQLI_ASSOC)){  
echo"{$row['last_name']}";
   }
$pagenum=ceil($count/$pagesize);//total count of pages displayed
//The symbol to the first page
$sint="<a onclick=ajaxfunction(1)><<</a>";
echo"<section id='spage'>$sint&nbsp&nbsp</section>";
//The symbol to last page
if($page==1){
    $last=1;
}
else if($page>1){
    $last=$page-1;
}
$slast="<a onclick=ajaxfunction($last)><</a>";
echo"<section id='spage'>&nbsp&nbsp$slast&nbsp&nbsp</section>";
//page numbers including suspension points
for($i=1;$i<=$pagenum;$i++){
    
    	if ($pagenum> $page_len) { 
			$half = floor(($page_len - 4) / 2);
			$half_start = $page - $half+ 1;
			if ($page_len % 2 !== 0) --$half_start;
			$half_end = $page + $half;
                      
		}
		if (($pagenum- $page) < ($page_len - 3)) {
			$half_start = $pagenum- $page_len + 3;
			unset($half_end);
		}
		if ($page <= ($page_len - 3)) {
			$half_end = $page_len-2;
			unset($half_start);
		}
  
     if($page==$i){ 
     
    $st.="<a onclick=ajaxfunction($i) class='i'>$i</a>";
}
else{
    if (isset($half_start) && $i < $half_start && $i > 1) {
                              if ($i == 2)    {$st.="..."; }                             
			    continue;	
			}
			if (isset($half_end) && $i > $half_end && $i < $pagenum) {
       		if ($i == ($half_end+1)){$st.="..."; }
				continue;
			}
       
                        else{
       $st.="<a onclick=ajaxfunction($i)>&nbsp&nbsp$i&nbsp&nbsp</a>";
                        }
}
}echo"<section id='spage'>$st</section>";
if($page==$pagenum){
    $next=$pagenum;
}
else if($page<$pagenum){
    $next=$page+1;
}
$snext="<a onclick=ajaxfunction($next)>></a>";
echo"<section id='spage'>&nbsp&nbsp$snext&nbsp&nbsp</section>";
$send="<a onclick=ajaxfunction($pagenum)>>></a>";
echo"<section id='spage'>&nbsp&nbsp$send&nbsp&nbsp</section>";
?>
<style>
    #spage{margin-top:300px;float: left;}
</style>
