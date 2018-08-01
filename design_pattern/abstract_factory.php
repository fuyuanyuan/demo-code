<?php
/**
 * 工厂模式：定义一个创建对象的接口，让子类决定哪个类实例化。 他可以解决简单工厂模式中的封闭开放原则问题
 * 抽象工厂：提供一个创建一系列相关或相互依赖对象的接口。注意：这里和工厂方法的区别是：一系列，而工厂方法则是一个。
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

// 将对象的创建抽象成一个接口
interface createPeople
{
    function create();
}

class FactoryMan implements createPeople
{
    function create(){
        return new man;
    }
}

class FactoryWomen implements createPeople
{
    function create(){
        return new women;
    }
}

$man = new FactoryMan;
$man->create();
$man->show();

$women = new FactoryWomen;
$women->create();
$women->show();