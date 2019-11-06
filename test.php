<?php
    //获取某一时刻系统cpu、内存使用情况
    $cm = array();
    exec('top -b -n 2 | grep -E "(Cpu|Mem :)"', $cm);

    //获取磁盘分区使用情况
    $cp = array();
    exec('df -lh | grep -E "^(/)"', $cp);

    //获取mysql连接数
    $my = array();
    exec("mysqladmin -uroot -proot status", $my);


    $cpu = getCpu($cm[2]);
    echo "cpu使用率：" . $cpu . "%" . "\n";

    $mem = getMem($cm[3]);
    echo "可用内存大小：" . $mem['free'] . "KB" . "\n";
    echo "已使用内存大小：" . $mem['used'] . "KB" . "\n";

    $dev = getDev($cp[0]);
    echo "分区名：" . $dev['name'] . "|" . "磁盘大小：" . $dev['size'] . "|" . "已使用的空间大小：" . $dev['used'] . "|" . "剩余的空间大小:" . $dev['available'] . "|" . "磁盘使用率：" . $dev['use%'] ."\n";

    $th = explode(" ", $my[0]);
    echo "mysql连接数：" . $th[4] . "\n";



/**
 * 获取cpu使用率
 * @return int
 */
function getCpu($rs)
{
    preg_match_all("/:.*id/", $rs,$cpu_info);
    $cpu_true = $cpu_info[0][0];
    $cpus = explode(',', $cpu_true);
    $cpu_usage = explode(' ', $cpus[3]);
    return 100-$cpu_usage[1];
}


/**
 * 获取内存使用情况
 * @return array
 */
function getMem($rs)
{
    preg_match_all("/:.*used/", $rs,$mem_info);
    $mem_true = $mem_info[0][0];
    $mems = explode(',', $mem_true);
    $free = explode(' ', $mems[1]);
    $used = explode(' ', $mems[2]);
    return [
        'free' => $free[4],
        'used' => $used[3]
    ];

}


/**
 * 获取磁盘的使用情况
 * @return array
 */
function getDev($rd)
{
    $rd = preg_replace("/\s{2,}/",' ',$rd);  //把多个空格换成一个空格
    $hd = explode(" ",$rd);
    return [
        'name' => $hd[0],
        'size' => $hd[1],
        'used' => $hd[2],
        'available' => $hd[3],
        'use%' => $hd[4]
    ];
}


