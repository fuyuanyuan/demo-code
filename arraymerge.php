<?php
$arr1 = [
    'a'=>'a',
    'b'=>'b',
    'c'=>'c',
];

$arr2 = [
    'a'=>'a1',
    'b'=>'b1',
    'c'=>'c1',
    'd'=>'d1',
];
echo "arr1,arr2:<br>";
var_dump($arr1,$arr2);
echo "array_merge_recursive:<br>";
$arr = array_merge_recursive($arr1, $arr2);
var_dump($arr);
echo "array_merge:<br>";
$arr = array_merge($arr1,$arr2);
var_dump($arr);
echo "arr1 + arr2:<br>";
$arrplus = $arr1+$arr2;
var_dump($arrplus);


echo "-----------------<br>";
$arr1 = [
    'a',
    'b',
    'c',
];

$arr2 = [
    'a1',
    'b1',
    'c1',
    'd1',
];
echo "arr1,arr2:<br>";
var_dump($arr1,$arr2);
echo "array_merge_recursive:<br>";
$arr = array_merge_recursive($arr1, $arr2);
var_dump($arr);
echo "array_merge:<br>";
$arr = array_merge($arr1,$arr2);
var_dump($arr);
echo "arr1 + arr2:<br>";
$arrplus = $arr1+$arr2;
var_dump($arrplus);
