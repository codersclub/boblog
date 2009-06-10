<?php 
// 百变图代码，版权归http://blog.nzye.com/index.php所有！！
$url='pic'; 
$files=array(); 
if ($handle=opendir("$url")) { 
  while(false !== ($file = readdir($handle))) { 
      if ($file != "." && $file != "..") { 
      if(substr($file,-3)=='gif' || substr($file,-3)=='jpg') $files[count($files)] = $file; 
      } 
  } 
} 
closedir($handle); 
$random=rand(0,count($files)-1); 
readfile("$url/$files[$random]"); 

?> 
