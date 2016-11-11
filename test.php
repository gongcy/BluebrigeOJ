<?php
/*
 *   @author  ykm
 *   @date  2015.05.12
 *   @description  测试文件
 */
header("Content-type: text/html; charset=utf-8");
define('APP_DIR', dirname(__FILE__));
 
if (function_exists('spl_autoload_register')) {
    spl_autoload_register('autoClass');
} else {
    function __auto_load($className){
        autoClass($className);
    }
}
 
function autoClass($className){
    try{
        require_once APP_DIR.'/class/'.$className.'.php';
    } catch (Exception $e) {
        die('Error:' . $e->getMessage() . '<br />');
    }
}
$DB = new DB();
//插入
$inData['a'] = rand(1, 100);
$inData['b'] = rand(1, 1000);
$inData['c'] = rand(1,200) . '.' . rand(1,100);
$ret = $DB->insert('a', $inData);
echo '插入' . ($ret ? '成功' : '失败') . '<br/>';
//更新
$upConData['a'] = 100;
$upConJudge['a'] = '<';
$upConData['b'] = 30;
$upConJudge['b'] = '>';
list($upConStr, $mapUpConData) = $DB->FDField('b', 200, '<', 'gt');
$condition = array(
    'str' => $upConStr,
    'data' => $upConData,
    'judge' => $upConJudge,
    'link' => 'and'
);
$upData['a'] = rand(1, 10);
$upData['b'] = 1;
$upData['c'] = 1.00;
$changeRows = $DB->update('a', $upData, $condition, $mapUpConData);
echo '更新行数:' . (int) $changeRows . '<br/>';
//删除
$delVal = rand(1, 10);
list($delCon, $mapDelCon) = $DB->FDField('a', $delVal);
$delRet = $DB->delete('a', $delCon, $mapDelCon);
echo '删除a=' . $delVal . ($delRet ? '成功' : '失败') . '<br/>';
  
//查询
$data['a'] = '10';
$judge['a'] = '>';
$data['b'] = '400';
$judge['b'] = '<';
list($conSql, $mapConData) = $DB->FDFields($data, 'and', $judge);
$mData = $DB->fetch('select * from a where ' . $conSql . ' order by `a` desc', $mapConData);
 
var_dump($mData);
?>