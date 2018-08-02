<?php
/**
 * 静态工厂模式是通过一个静态方法创建对象的
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

class StaticFactoty
{
    static function createMan(){
        return new man;
    }

    static function createWomen(){
        return new women;
    }
}



$man = StaticFactoty::createMan();
$man->show();

$women = StaticFactoty::createWomen();
$women->show();