<?php 
// �ٱ�ͼ���룬��Ȩ��http://blog.nzye.com/index.php���У���
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
