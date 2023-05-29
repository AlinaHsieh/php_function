<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>自訂函式</title>
</head>

<body>
    <?php

function sum($a,$b){
    //return $a+$b; //也可以寫成下兩列
    $sum=$a+$b;
    return $sum;
}
// $sum=sum(15,21);
// echo $sum;        //也可以寫成下一列
echo sum(15,21);

echo "<br>";////////////////////

sum1(10,15,35);
echo sum1(10,15,35);
function sum1(...$arg){ //$arg是陣列(可改名字)
    // print_r($arg);
    $total=0;
    foreach ($arg as $argg){
        $total+=$argg;
    }
    return $total;
}

echo "<br>";////////////////////

echo g();
function g(){
    echo "1234";
}

echo "<br>";////////////////////

echo circle(10,3.14);
function circle($r,$p){
    return $r*$r*$p;
}

echo "<br>";////////////////////

echo circle1(10);
function circle1($r,$p=3.1415){
    return $r*$r*$p;
}




    ?>
</body>

</html>