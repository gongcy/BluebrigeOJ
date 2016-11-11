<?php
if ($_POST) {
    header('Content-Type:text/html;charset=utf-8');
    require_once 'config.php';
    $current_time = time();
    session_start();
    require_once 'DBCN.php';
    require_once 'updateans.php';
    $msg = updateans($_POST['submit_id']);
    //if($msg=='panding')die("panding");
    if ((strtotime($BEGIN_TIME) < $current_time && $current_time < strtotime($END_TIME)) && $MODE == 1 && $_SESSION['user_id'] != "gcyadmin") {
        die('wait');
    } else print($msg);
    //var_dump($mData);
}
?>