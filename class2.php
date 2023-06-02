<?php

class Animal{

    private $age=10;
    protected $name;
    protected $hair="紅色 ";

    function __construct($name)
    {
        $this->name=$name;

    }
    public function getName(){
        return $this->name;
    }
    public function setName($name){
        return $this->name=$name;
    }
    public function age(){
        return $this->age;
    }   

    protected function run(){
        return "跑跑跑";
    }

    private function speed(){
        return "跑速1000";
    }

}

$animal=new Animal('小明');
echo "<br>";
echo $animal->getName();
$animal->setName("小莉");
echo $animal->getName();
//echo $animal->age;
//echo $animal->hair;

echo $animal->age();

//echo $animal->speed();

class Cat extends Animal{
    private $age;

    function __construct($name,$age)
    {
        $this->name=$name;
        $this->age=$age;
    }

    function catrun(){
        return $this->run();
    }

    function age(){
        return $this->age;
    }

    function run(){
        return "走走走";
    }
}


echo "<BR>";
$cat=new Cat('小花',20);

echo $cat->age();
echo $cat->catrun();
echo $cat->run();