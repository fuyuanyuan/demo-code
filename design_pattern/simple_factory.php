<?php
/**
 * 简单工厂模式是通过一个静态方法创建对象的
 */
interface people
{
    function show();
}

class man implements people
{
    function show(){
        echo "i am man!";
    }
}

class women implements people
{
    function show(){
        echo "i am women!";
    }
}

class SimpleFactoty
{
    function createMan(){
        return new man;
    }

    function createWomen(){
        return new women;
    }
}



$man = new SimpleFactoty;
$man->createMan();
$man->show();

$women = new SimpleFactoty;
$women->createWomen();
$women->show();