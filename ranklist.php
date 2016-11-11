<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Blue System</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <link rel="alternate icon" type="image/png" href="assets/i/favicon.png">
    <link rel="stylesheet" href="assets/css/amazeui.min.css"/>

    <style>
        .header {
            text-align: center;
        }

        .header h1 {
            font-size: 200%;
            color: #333;
            margin-top: 30px;
        }

        .header p {
            font-size: 14px;
        }
    </style>
    <script type="text/javascript">
        var timeout;
        var method = $('#rmethod').val();
        function clickRank() {
            if (timeout) {
                clearTimeout(timeout);
            }
            getRank();
        }
        function getRank() {
            $.AMUI.progress.start();
            $("#rankdiv").load("getrank_" + method + ".php?contest_code=" + $("#contest_code").val());
            $.AMUI.progress.done();
            timeout = setTimeout(function () {
                getRank();
            }, 10000);
        }
    </script>
</head>
<body>
<header class="am-topbar admin-header">
    <div class="am-topbar-brand">
        <strong>软件梦工厂</strong>
        <small>蓝桥杯模拟训练系统</small>
    </div>

        <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only"
                data-am-collapse="{target: '#topbar-collapse'}"><span class="am-sr-only">导航切换</span> <span
                class="am-icon-bars"></span></button>

    <div class="am-collapse am-topbar-collapse" id="topbar-collapse">

        <ul class="am-nav am-nav-pills am-topbar-nav am-topbar-right admin-header-list">
            <li class="am-hide-sm-only">
                <div class="am-topbar-form am-topbar-left am-form-inline">
                    <div class="am-form-group">
                        <strong>排名方式</strong>
                        <select data-am-selected id="rmethod">
                            <option value="sc" selected>按通过数据百分比</option>
                            <option value="ac">按AC个数</option>
                        </select>
                    </div>
                </div>
            </li>
            <!--             <li><a href="javascript:;"><span class="am-icon-envelope-o"></span> 收件箱 <span class="am-badge am-badge-warning">5</span></a></li>-->
            <li class="am-hide-sm-only">
                <div class="am-topbar-form am-topbar-left am-form-inline" role="search">
                    <div class="am-form-group">
                        <input type="text" class="am-form-field am-input-sm" placeholder="请在此输入比赛码！" id='contest_code'>
                        <button class="am-btn am-btm-primary" onclick="clickRank()">确定</button>
                    </div>
                </div>
            </li>
            <li class="am-hide-sm-only"><a href="javascript:;" id="admin-fullscreen"><span
                        class="am-icon-arrows-alt"></span> <span class="admin-fullText">开启全屏</span></a></li>
        </ul>
    </div>
</header>
<div class="am-g">
    <div class="am-u-sm-12 am-u-sm-centered" id='rankdiv'></div>
</div>
<div class="am-g">
    <hr>
    <?php include_once "blue-footer.php" ?>
</div>
<!--[if (gte IE 9)|!(IE)]><!-->
<script src="assets/js/jquery.min.js"></script>
<!--<![endif]-->
<script src="assets/js/amazeui.min.js"></script>
<script src="assets/js/app.js"></script>
</body>
</html>
<?php

?>