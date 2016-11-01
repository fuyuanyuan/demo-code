<?php
/*
循环的逐行统计，这样的效率太慢
最快的方法是多行统计，每次读取N个字节，然后再统计行数，这样比逐行效率高多了。

测试情况,文件大小 3.14 GB
第1次:line: 13214810 , time:56.2779 s;
第2次:line: 13214810 , time:49.6678 s;

/*
 * 高效率计算文件行数
*用exec执行 wc -l 文件名更快
*/ 
function count_line($file){
     $fp=fopen($file, "r");
     $i=0;
     while(!feof($fp)) {
          //每次读取2M
          if($data=fread($fp,1024*1024*2)){
           //计算读取到的行数
           $num=substr_count($data,"\n");
           $i+=$num;
          }
 }
 fclose($fp);
 return $i;
}
