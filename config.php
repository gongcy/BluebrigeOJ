<?php 
 static $DB_NAME='jol';  //数据库名
 static $DB_HOST='localhost';		//数据库地址
 static $DB_USER='root';		//数据库用户名
 static $DB_PORT='3306';
 static $DB_PASSWORD='root';	//数据库密码
 static $EMAIL_SERVER="";	//邮件服务器
 static $EMAIL_SIGN=0;		//是否邮件注册,0不使用邮箱注册 1使用
 static $EMAIL_LOGINID="";  //邮箱帐号
 static $EMAIL_PWD="";      //邮箱密码
 static $MODE=1; //比赛模式为1，训练模式为0;
 static $BEGIN_TIME="2016-11-06 00:00:00";
 static $END_TIME="2016-11-06 22:00:00";
 static $CONTEXT_NAME="模拟训练一 C/C++组";
 static $CONTEST_CODE="000";//请确保每次比赛的contest_code不相同
 static $TIME_TO_GETANS=2000;//刷新时间
 static $PROBLEM_RAR='problem.zip';

 static $problemArray=array(array(),
  array('des'=>'积分之迷','type'=>'结果','ans'=>'105','score'=>19),
  array('des'=>'完美正方形','type'=>'结果','ans'=>'50 33 30 41','score'=>35),
  array('des'=>'关联账户','type'=>'代码','ans'=>'1031','replace'=>'1027.cpp','score'=>31),
  array('des'=>'密文搜索','type'=>'编程','ans'=>'1032','score'=>41),
  array('des'=>'居民集会','type'=>'编程','ans'=>'1033','score'=>75),
  array('des'=>'模型染色','type'=>'编程','ans'=>'1034','score'=>99)
  );
?>
