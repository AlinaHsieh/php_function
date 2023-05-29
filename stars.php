<style>
    *{
        font-family: 'Courier New', Courier, monospace;
    }
</style>
<?php
//迴圈印正三角形星星
for($i=0;$i<5;$i++){
    for($j=0;$j<(4-$i);$j++){
        echo "&nbsp;";
    }

    for($k=0;$k<($i*2+1);$k++){
        echo "*";
    }
    echo "<br>";
}
//迴圈加入function印正三角形星星
echo star(10);
function star($line){
    for($i=0;$i<$line;$i++){
        for($j=0;$j<($line-1-$i);$j++){
            echo "&nbsp;";
        }
    
        for($k=0;$k<($i*2+1);$k++){
            echo "*";
        }
        echo "<br>";
    }

}
echo "<br>";
//迴圈印矩形
for($i=0;$i<=5;$i++){
    for($j=0;$j<=5;$j++){
        echo "*";
    }
    echo "<br>";
}

//function印矩形
echo rectangle1(10);
function rectangle1($line){
    for($i=0;$i<=$line;$i++){
        for($j=0;$j<=$line;$j++){
            echo "*";
        }
        echo "<br>";
    }
}

stars("正三角形",11);
stars("矩形",6);
stars("直角三角形",21);
stars("菱形",17);
stars("圓形",17);

function stars($shape,$line){
    switch($shape){
        case '正三角形':
            equilateral_triangle($line);
        break;
        case '直角三角形':
            right_triangle($line);
        break;
        case '菱形':
            diamond($line);
        break;
        case '矩形':
            rectangle($line);
        break;
        default:
        echo "目前不支援".$shape."的形狀輸出";
    }

}




function equilateral_triangle($line){
    for($i=0;$i<$line;$i++){
        for($j=0;$j<($line-1-$i);$j++){
            echo "&nbsp;";
        }
    
        for($k=0;$k<($i*2+1);$k++){
            echo "*";
        }
        echo "<br>";
    }
}

function right_triangle($line){
    for($i=0;$i<$line;$i++){

        for($j=0;$j<($i+1);$j++){
            echo "*";
        }
        echo "<br>";

    }
}

function diamond($n){

    $n=($n%2==0)?$n+1:$n;
    
    $tmp=0;
    for($i=0;$i<$n;$i++){
    
        $tmp=($i<ceil($n/2))?$i:$n-1-$i;
    
        for($j=0;$j<(ceil($n/2)-1-$tmp);$j++){
            echo "&nbsp;";
        }
    
        for($k=0;$k<($tmp*2+1);$k++){
            echo "*";
        }
        echo "<br>";  
    
    }
    
}

function rectangle($n){

for($i=0;$i<$n;$i++){

    for($j=0;$j<$n;$j++){
        if($i==0 || $i==($n-1)){
            echo "*";
        }else if($j==0 || $j==$n-1){
            echo "*";
        }else{
            echo "&nbsp;";
        }
    }

    echo "<br>";
}
}