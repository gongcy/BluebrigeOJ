<?php
if ($_GET) {
    require_once 'DBCN.php';
    require_once 'config.php';
    $db = new DB();
    $_SESSION['contest_code'] = $_GET['contest_code'];
    $data1['contest_code'] = $_GET['contest_code'];
    $judge1['contest_code'] = '=';
    list($conSql1, $mapConData1) = $db->FDFields($data1, 'and', $judge1);
    $mData1 = $db->fetchALL('select * from blueSySSubmit where ' . $conSql1 . 'and score is null order by submit_id asc', $mapConData1, array(0, 5000));
    require_once 'updateans.php';
    foreach ($mData1 as $key => $value) {
        updateans($value['submit_id']);
    }
    $data['contest_code'] = $_GET['contest_code'];
    $judge['contest_code'] = '=';

    list($conSql, $mapConData) = $db->FDFields($data, 'and', $judge);
    $mData = $db->fetchALL('select b.user_id,a.* from blueSySSubmit as a join users as b on a.user_id=b.user_id  where a.' . $conSql . 'and a.score is not null order by a.submit_id asc', $mapConData, array(0, 5000));
    if ($mData) {
        $table = array();
        foreach ($mData as $key1 => $value1) {
            $user_id = $value1['nick'] . "  (" . $value1['user_id'] . ")";
            $pid = $value1['pid'];
            if (!isset($table[$user_id][$pid]['times'])) {
                $table[$user_id][$pid]['times'] = 0;
            }
            if (!isset($table[$user_id][$pid]['is_correct'])) {
                $table[$user_id][$pid]['is'] = 0;
            }
            $table[$user_id][$pid]['is_correct'] = $value1['is_correct'];
            $table[$user_id][$pid]['times']++;
        }
        uasort($table, function ($a, $b) {
            $al = 0;
            $bl = 0;
            require 'config.php';
            foreach ($a as $key => $value) {
                $al += $value['is_correct'];
            }
            foreach ($b as $key => $value) {
                $bl += $value['is_correct'];
            }
            if ($al == $bl)
                return 0;
            return ($al > $bl) ? -1 : 1;
        });
        print("<table class ='am-table am-table-bordered am-table-striped am-table-centered am-table-hover'>");
        print("<tr>");
        print("<th>排名</th>");
        print("<th>用户名</th>");
        $problemNum = count($problemArray) - 1;
        for ($i = 1; $i <= $problemNum; $i++) {
            print("<th>$i</th>");
        }
        print("<th>正确题数</th>");
        print("</tr>");
        $ranki = 0;
        foreach ($table as $key => $value) {
            print("<tr>");
            ++$ranki;
            print("<td>$ranki</td>");
            print("<td>$key</td>");
            $sum = 0;
            for ($i = 1; $i <= $problemNum; $i++) {
                if (isset($value[$i])) {
                    $score = "答案正确";
                    $times = $value[$i]['times'];
                    $sum++;
                    print("<td>$score($times)</td>");
                } else {
                    print("<td>答案错误(0)</td>");
                }
            }
            print("<td>$sum</td>");
            print("</tr>");
        }
        print("</table>");
    } else {
        print("<h1>不存在该比赛或该比赛无人提交！</h1>");
    }
}
?>