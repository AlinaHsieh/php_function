<?php

function dd($ary){
    echo "<pre>";
    print_r($ary);
    echo "</pre>";
}

function pdo(){
    $dsn = "mysql:host=localhost;charset=utf8;dbname=vote3";
    $pdo = new PDO($dsn, 'root', '');
    return $pdo;
}

//all()-給定資料表名後，會回傳整個資料表的資料
function all($table){
    // $dsn = "mysql:host=localhost;charset=utf8;dbname=vote3";
    // $pdo = new PDO($dsn, 'root', '');
    $pdo=pdo();
    $sql = "select * from $table";
    $rows = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
}

/* 
寫一個可以處理比較複雜條件的all function
 * all($table) => 全部資料表的內容
 * 例:select * from `topics` => all('topics')
 * ---------------------------------------------------------------
 * all($table,$array) => 以and為基礎的符合條件資料
 * 例: select * from `topics` where `type`='1' && `login`=1; => all('topics',['type'=>1,'login'=>1]) ;
 * ---------------------------------------------------------------
 * all($table,$sql) => 以sql字串為條件的資料
 * 例: select * from `topics` where open_time <= '2023/06/02' order by `id` desc
 * all(`topcis`,"where open_time <= '2023/06/02' order by `id` desc")
 * ---------------------------------------------------------------
 * all($table,$array,$sql) => 符合複雜條件的資料
 * 例: select * from `topics` where `type`=1 && `login`=1  order by `id` desc
 * all(`topcis`,['type'=>1,,'login'=>1], " order by `id` desc")
 */
function newAll($table,...$arg){ //判斷$arg是否有值
    $pdo=pdo();
    $sql = "select * from $table ";
    if(!empty($arg)){            //不是空的:可能是陣列、可能是字串
        if(is_array($arg[0])){   //如果是陣列，從$arg的key值0的位置開始判斷
            foreach($arg[0] as $key => $value ){
                $tmp[]="`$key`='$value'";
            }
            $sql = $sql . "where" . join(" && ",$tmp);
        }else{
            $sql = $sql . "where" . $arg[0];  //如果是字串，則原本sql語法+$arg[0]的東西
        }
    }
    if(isset($arg[1])){   //判斷是否有第三個參數(預設是sql語句)存在 all($table,$array,$sql) 
        $sql = $sql ."where" . $arg[1];
    }

    $rows = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
}


//計數用的函式
function _count($table,...$arg){ 
    $pdo=pdo();
    $sql = "select count(*) from $table ";
    if(!empty($arg)){            
        if(is_array($arg[0])){   
            foreach($arg[0] as $key => $value ){
                $tmp[]="`$key`='$value'";
            }
            $sql = $sql ."where" . join(" && ",$tmp);
        }else{
            $sql = $sql ."where" . $arg[0];  
        }
    }
    if(isset($arg[1])){    
        $sql = $sql ."where" . $arg[1];
    }

    $rows = $pdo->query($sql)->fetchColumn();
    return $rows;
}
// echo _count('topics');


//計數用的函式(方法)
function math($table,$math,$col,...$arg){ 
    $pdo=pdo();
    $sql = "select $math(`$col`) from $table ";
    if(!empty($arg)){            
        if(is_array($arg[0])){   
            foreach($arg[0] as $key => $value ){
                $tmp[]="`$key`='$value'";
            }
            $sql = $sql . "where" . join(" && ",$tmp);
        }else{
            $sql = $sql . "where" .  $arg[0];  
        }
    }
    if(isset($arg[1])){    
        $sql = $sql . "where" .  $arg[1];
    }

    $rows = $pdo->query($sql)->fetchColumn();
    return $rows;
}
echo math('options','min','id');
echo "<br>";
echo math('options','sum','total',['subject_id'=>8]);




//find()-會回傳資料表指定id的資料
function find($table, $id){
    // $dsn = "mysql:host=localhost;charset=utf8;dbname=vote3";
    // $pdo = new PDO($dsn, 'root', '');
    $pdo=pdo();
    $sql = "select * from $table where `id` = $id";
    $row = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
    return $row;
}

//以function find()舉例，當今天條件可能為多筆時:加判斷式
function find2($table, $arg){
    // $dsn = "mysql:host=localhost;charset=utf8;dbname=vote3";
    // $pdo = new PDO($dsn, 'root', '');
    $pdo=pdo();
    $sql = "select * from `$table` where ";

    if (is_array($arg)) {  //判斷$arg是否為陣列
        foreach($arg as $key => $value ){
            $tmp[]="`$key`='$value'";
        }
        $sql .= join(" && ",$tmp);  
    echo $sql;

    } else {
        $sql .= " `id` = '$arg' ";
    }
        //補充: is_numeric()  判斷$arg是否為字串型式的數字(ex:'1')
   
    $row = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    return $row;

}
// echo "<pre>";
// print_r(find2('options',['subject_id'=>9,'description'=>'別針']));
// echo "</pre>";



//update()-給定資料表的條件後，會去更新相應的資料。
function update($table, $cols, $id){
    // $dsn = "mysql:host=localhost;charset=utf8;dbname=vote3";
    // $pdo = new PDO($dsn, 'root', '');
    $pdo=pdo();
    $sql = "update $table set $cols where `id`= $id";
    //$cols會是key=>value的形式>>用陣列
    //陣列拼成SQL語句>>設定變數$tmp
    $tmp = '';
    foreach ($cols as $key => $value) {
        $tmp = $tmp . "`$key`='$value',";
    }
    $tmp = trim($tmp, ','); //用函數trim清除頭尾多餘逗點
    // echo $tmp;

    $sql = "update `$table` set $tmp where `id`= '$id'";
    $result = $pdo->exec($sql);
    return $result;
}
// update('options',['description'=>'悟饕便當','total'=>'100'],9);


//insert()-給定資料內容後，會去新增資料到資料表
function insert($table, $cols){
    // $dsn = "mysql:host=localhost;charset=utf8;dbname=vote3";
    // $pdo = new PDO($dsn, 'root', '');
    $pdo=pdo();
    //cols為多筆資料>>用陣列
    $col = array_keys($cols); //用array_keys函數只取陣列的key值
    $sql = "insert into `$table`(`" . join("`,`", $col) . "`) value ('" . join("','", $cols) . "')";
    // echo $sql;
    $result = $pdo->exec($sql);
    return $result;
}
// insert('options',['description'=>'義大利麵','subject_id'=>'8','total'=>'0']);


//del()-給定條件後，會去刪除指定的資料
function del($table, $id){
    // $dsn = "mysql:host=localhost;charset=utf8;dbname=vote3";
    // $pdo = new PDO($dsn, 'root', '');
    $pdo=pdo();
    $sql = "delete from `$table` where `id` = '$id' ";
    $result = $pdo->exec($sql);
    return $result;
}
// del('options','27');


//觀察update跟insert語法=>差在update有id,insert沒有id
// update('options',['description'=>'悟饕便當','total'=>'100'],9); 把id寫進陣列中變成下列
// update('options',['id'=>9,'description'=>'悟饕便當','total'=>'100']); 然後跟insert語法比較
// insert('options',['description'=>'義大利麵','subject_id'=>'8','total'=>'0']);

function update2($table, $cols){ //update改版function
    $dsn = "mysql:host=localhost;charset=utf8;dbname=vote3";
    $pdo = new PDO($dsn, 'root', '');
    foreach ($cols as $key => $value) { 
        if($key!='id'){ //用foreach下判斷式排除id列(id不需要被更新)
            $tmp[]= "`$key`='$value',";
        }
    }
    $sql = "update `$table` set ".join(",",$tmp)." where `id`= '{$cols['id']}'";
    $result = $pdo->exec($sql);
    return $result;
}

//寫一個同時具備更新&插入功能的function(處理以id為判斷的資料)
function save($table,$cols){
    if(isset($cols['id'])){
        update2($table,$cols);
    }else{
        insert($table,$cols);
    }
}

//執行select較複雜的語法(可直接在function括弧內加入SQL語句)
function q($sql){
    $dsn = "mysql:host=localhost;charset=utf8;dbname=vote3";
    $pdo = new PDO($dsn, 'root', '');
    return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}
