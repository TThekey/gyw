<?php

//获取输入的第一个参数，即进程名
$process = $argv[1];
query_process_num($process);


/**
 * 获取进程信息和进程数量
 * @param $service
 */
function query_process_num($service){
    $res = array();
//    exec("ps -ef | grep '" . $service . "'", $res);
//    print_r($res);//不处理直接输出
//
//    unset($res);
    exec("ps -ef | grep '" . $service . "' | wc -l", $res);
    print_r($res[0]-4);
}
