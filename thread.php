<?php

$my = array();
exec("mysqladmin -uroot -proot status", $my);

$th = explode(" ", $my[0]);

echo "mysql连接数：" . $th[4] . "\n";
