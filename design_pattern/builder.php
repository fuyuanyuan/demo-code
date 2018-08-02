<?php
class Director
{
    public function build(BuilderInterface $builder){
        $builder->create();
        $builder->step1();
        $builder->step2();
        $builder->product();
    }
}


interface BuilderInterface
{
    public function create();
    public function step1();
    public function step2();
    public function product();
}


class CarBuilder implements BuilderInterface
{
    private $car;

    public function create(){
        $this->car = new Car;
    }
    public function step1(){
        $this->car->setStep('step1');
    }
    public function step2(){
        $this->car->setStep('step2');
    }
    public function product(){
        return $this->car;
    }
}

class BicycleBuilder implements BuilderInterface
{
    private $bicycle;

    public function create(){
        $this->bicycle = new Bycicle;
    }
    public function step1(){
        $this->bicycle->setStep('step1');
    }
    public function step2(){
        $this->bicycle->setStep('step2');
    }
    public function product(){
        return $this->bicycle;
    }
}


abstract class Vehicle
{
    private $data = [];

    public function setStep($name){
        $this->data[] = $name;
    } 
}

class Car extends Vehicle
{
}

class Bycicle extends Vehicle
{
}


$carbuilder = new CarBuilder;
$newcar = (new Director())->build($carbuilder);

$bicyclebuilder = new BicycleBuilder;
$newbicycle = (new Director())->build($bicyclebuilder);