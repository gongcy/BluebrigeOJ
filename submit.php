<?php
if ($_POST) {
    session_start();
    require 'config.php';
    $current_time = time();
    //usleep(rand(5000,2000000));
    if (strtotime($BEGIN_TIME) < $current_time && $current_time < strtotime($END_TIME)) {
        $pid = $_POST['pid'];
        if ($problemArray[$pid]['type'] == '结果') {
            require_once 'DBCN.php';
            // if($problemArray[$pid]['ans']==$_POST['ans']){
            // 	echo "AC";
            // }else{
            // 	echo "WA";
            // }
            $db = new DB();
            $inData2['contest_code'] = $CONTEST_CODE;
            $inData2['user_id'] = $_SESSION['user_id'];
            $inData2['ans'] = $_POST['ans'];
//            $inData2['submit_time'] = date('Y-m-d H:i:s', time());
            $inData2['pid'] = $pid;
            $ret2 = $db->insert('blueSySSubmit', $inData2, true);
            if ($ret2) echo "ok:$ret2";
            else echo "error:1";
        } else if ($problemArray[$pid]['type'] == '代码') {
            require_once 'DBCN.php';
            $db = new DB();
            $inData['problem_id'] = $problemArray[$pid]['ans'];
            $inData['user_id'] = $_SESSION['user_id'];
            $inData['in_date'] = date('Y-m-d H:i:s', time());
            $inData['result'] = '0';
            $inData['language'] = '1';
            $inData['ip'] = $_SERVER["REMOTE_ADDR"];
            $ret = $db->insert('solution', $inData, true);
            //echo '插入' . ($ret1 ? '成功' : '失败') . '<br/>';
            $inData1['solution_id'] = $ret;
            $ansfile = fopen('fillblank/' . $problemArray[$pid]['replace'], 'r') or dir("error:3");
            $ansfileread = fread($ansfile, filesize('fillblank/' . $problemArray[$pid]['replace']));
            $keyword_list = trim($_POST['ans']);
            $keyword_arr = explode("\n", $keyword_list);
            foreach ($keyword_arr as $key => $value) {
                $ansfileread = str_replace(($key + 1) . "_______", $value, $ansfileread);
                //var_dump($key);
                //print(":");
                //var_dump($value);
                //print(":");
            }
            $ans = $ansfileread;
            //var_dump($ans);
            $inData1['source'] = $ans;
            $ret1 = $db->insert('source_code', $inData1);
            //echo '插入' . ($ret ? '成功' : '失败') . '<br/>';
            $inData2['contest_code'] = $CONTEST_CODE;
            $inData2['user_id'] = $_SESSION['user_id'];
            $inData2['solution_id'] = $ret;
            $inData2['ans'] = $_POST['ans'];
//            $inData2['submit_time'] = date('Y-m-d H:i:s', time());
            $inData2['pid'] = $pid;
            $ret2 = $db->insert('blueSySSubmit', $inData2, true);
            //echo '插入' . ($ret ? '成功' : '失败') . '<br/>';
            if ($ret && $ret1 && $ret2) echo "ok:$ret2";
            else echo "error:5";

        } else if ($problemArray[$pid]['tpe'] == '编程') {
            require_once 'DBCN.php';
            $db = new DB();
            $inData['problem_id'] = $problemArray[$pid]['ans'];
            $inData['user_id'] = $_SESSION['user_id'];
            $inData['in_date'] = date('Y-m-d H:i:s', time());
            $inData['result'] = '0';
            $inData['language'] = '1'; // 1 for C/C++, 3 for JAva
            $inData['ip'] = $_SERVER["REMOTE_ADDR"];
            $ret = $db->insert('solution', $inData, true);
            //echo '插入' . ($ret1 ? '成功' : '失败') . '<br/>';
            $inData1['solution_id'] = $ret;
            $inData1['source'] = $_POST['ans'];
            $ret1 = $db->insert('source_code', $inData1);
            //echo '插入' . ($ret ? '成功' : '失败') . '<br/>';
            $inData2['contest_code'] = $CONTEST_CODE;
            $inData2['user_id'] = $_SESSION['user_id'];
            $inData2['solution_id'] = $ret;
            $inData2['pid'] = $pid;
//            $inData2['submit_time'] = date('Y-m-d H:i:s', time());
            $ret2 = $db->insert('blueSySSubmit', $inData2, true);
            //echo '插入' . ($ret ? '成功' : '失败') . '<br/>';
            if ($ret && $ret1 && $ret2) echo "ok:$ret2";
            else echo "error:2";
        } else {
            echo "error:0";
        }
    } else {
        echo "时间超时";
    }
}
?>