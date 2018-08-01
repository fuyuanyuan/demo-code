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

// 简单工厂里的静态方法
class SimpleFactoty
{
    static function createMan(){
        return new man;
    }

    static function createWomen(){
        return new women;
    }
}



$man = SimpleFactoty::createMan();
$man->show();

$women = SimpleFactoty::createWomen();
$women->show();