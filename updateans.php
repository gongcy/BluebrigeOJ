<?php
function updateans($value)
{
    require 'config.php';
    $msg;
    $db = new DB();
    $data['submit_id'] = $value;
    $judge['submit_id'] = '=';
    list($conSql, $mapConData) = $db->FDFields($data, 'and', $judge);
    $mData = $db->fetch('select * from blueSySSubmit where ' . $conSql, $mapConData);
    if ($mData['score'] == '0') {
        return "WA";
    } else if ($mData['score'] == '100') {
        return "AC";
    } else if ($mData['score'] != NULL) {
        return "WA##" . $mData['score'];
    }
    // 针对结果填空题
    if ($problemArray[$mData['pid']]['type'] == '结果') {
        if ($mData['ans'] == $problemArray[$mData['pid']]['ans']) {
            $msg = "AC";
            $upData = 100;
            $isCorrect = 1;
        } else {
            $msg = "WA";
            $upData = 0;
            $isCorrect = 0;
        }
        if ($mData['score'] == NULL)
            $row = $db->exec("update blueSySSubmit set score=" . $upData . ",is_correct=" . $isCorrect . " where submit_id=" . $value . ";");
        //$msg = "更新行数:$row";
    } else {
        // 针对编程题
        $data1['solution_id'] = $mData['solution_id'];
        $judge1['solution_id'] = '=';
        list($conSql1, $mapConData1) = $db->FDFields($data1, 'and', $judge1);
        $solutionData = $db->fetch('select * from solution where ' . $conSql1, $mapConData1);
        $result = $solutionData['result'];
        if ($result == '4') {
            $msg = "AC";
            if ($mData['score'] == NULL)
                $db->exec("update blueSySSubmit set score=100,is_correct=1 where submit_id=" . $value . ";");
        } else if ($result == '0' || $result == '2') {
            $msg = "panding";
        } else if ($result == '3') {
            $msg = "TLE####";
        } else if ($result == '6') {
            $msg = "WA" . $solutionData['pass_rate'];
            $score = intval(substr($solutionData['pass_rate'], 2));
            if ($mData['score'] == NULL)
                $db->exec("update blueSySSubmit set score=$score where submit_id=" . $value . ";");
        } else if ($result == '7') {
            $msg = "TLE" . $solutionData['pass_rate'];
            $score = intval(substr($solutionData['pass_rate'], 2));
            if ($mData['score'] == NULL)
                $db->exec("update blueSySSubmit set score=$score where submit_id=" . $value . ";");
        } else if ($result == '11') {
            $msg = "CP";
            if ($mData['score'] == NULL)
                $db->exec("update blueSySSubmit set score=0 where submit_id=" . $value . ";");
        } else if ($result == '8') {
            $msg = "MLE" . $solutionData['pass_rate'];
            $score = intval(substr($solutionData['pass_rate'], 2));
            if ($mData['score'] == NULL)
                $db->exec("update blueSySSubmit set score=$score where submit_id=" . $value . ";");
        } else {
            $db->exec("update blueSySSubmit set score=0 where submit_id=" . $value . ";");
        }
    }
    return $msg;
}

?>