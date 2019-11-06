<?php
  $dbms='mysql';//数据库类型
  $dbName='company';//使用的数据库
  $user='root';//数据库连接用户名
  $pwd='root';//数据库连接密码
  $host='localhost';//数据库主机名
  $dsn="$dbms:host=$host;port=3306;dbname=$dbName";
  try{
    $pdo=new PDO($dsn,$user,$pwd);//初始化一个PDO对象，就是创建了数据库连接对象$pdo
    $query="select * from book";//需要执行的sql语句
    $res=$pdo->prepare($query);//准备查询语句
    $res->execute();

    while ($result=$res->fetch(PDO::FETCH_ASSOC)) {
      echo $result['id'] . " " . $result['name'] . '<br>';
    }
  }catch(Exception $e){
    die("Error!:".$e->getMessage().'<br>');
}
