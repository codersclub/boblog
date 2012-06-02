<?php 
// Variety diagram code, copyright belongs to http://blog.nzye.com/index.php!
$url='pic'; 
$files=[]; 
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
