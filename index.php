<?php session_start(); ?>
<?php
/**
 * Created by PhpStorm.
 * User: gongcy
 * Date: 16-10-31
 * Time: 下午8:17
 */

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
}
require_once 'config.php';
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>蓝桥训练系统</title>
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
        function getans(thix, x) {
            var gethttp;
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                gethttp = new XMLHttpRequest();
            }
            else {
                // code for IE6, IE5
                gethttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            gethttp.open("POST", 'checkans.php', true);
            gethttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            gethttp.send("submit_id=" + x);
            gethttp.onreadystatechange = function () {
                if (gethttp.readyState == 4 && gethttp.status == 200) {
                    var res = gethttp.responseText;
                    //$(thix).html(res);
                    if (res == 'panding') {
                        $(thix).html("<i class='am-icon-spinner am-icon-spin'></i>判题中");
                        $(thix).attr("class", "am-btn am-btn-warning");
                        $(thix).attr("disabled", "disabled");
                        setTimeout(function () {
                            getans(thix, x);
                        },<?php print($TIME_TO_GETANS); ?>);
                    } else if (res == 'AC') {
                        $(thix).html("<i class='am-icon am-icon-check-square'></i>正确");
                        $(thix).attr("class", "am-btn am-btn-success");
                        $(thix).removeAttr("disabled");
                    } else if (res.substring(0, 2) == 'WA') {
                        if (res.substring(4) == '' || res.substring(4) == '00')msg = '错误';
                        else msg = "部分正确  " + res.substring(4) + "%";
                        $(thix).html("<i>" + msg + "</i>");
                        $(thix).attr("class", "am-btn am-btn-danger");
                        $(thix).removeAttr("disabled");
                    } else if (res.substring(0, 2) == 'CP') {
                        msg = '编译错误';
                        $(thix).html("<i>" + msg + "</i>");
                        $(thix).attr("class", "am-btn am-btn-danger");
                        $(thix).removeAttr("disabled");
                    } else if (res.substring(0, 3) == 'TLE') {
                        msg = '时间超限';
                        if (res.substring(5) == '' || res.substring(5) == '00');
                        else if (res.substring(5) != '##') {
                            msg += "," + res.substring(5) + "%正确";
                            $(thix).html("<i>" + msg + "</i>");
                            $(thix).attr("class", "am-btn am-btn-danger");
                            $(thix).removeAttr("disabled");
                        } else {
                            $(thix).html("<i>" + msg + "</i>");
                            $(thix).attr("class", "am-btn am-btn-danger");
                            $(thix).removeAttr("disabled");
                            setTimeout(function () {
                                getans(thix, x);
                            },<?php print($TIME_TO_GETANS); ?>);
                        }
                    } else if (res.substring(0, 3) == 'MLE') {
                        msg = '内存超限';
                        if (res.substring(5) == '' || res.substring(5) == '00');
                        else msg += "," + res.substring(5) + "%正确";
                        $(thix).html("<i>" + msg + "</i>");
                        $(thix).attr("class", "am-btn am-btn-danger");
                        $(thix).removeAttr("disabled");
                    } else if (res == "wait") {
                        $(thix).html("比赛模式");
                        $(thix).attr("class", "am-btn am-btn-warning");
                        $(thix).removeAttr("disabled");
                    }
                }
            }
        }
        function showSubmit(thix, x) {
            var getcodehttp;
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                getcodehttp = new XMLHttpRequest();
            }
            else {
                // code for IE6, IE5
                getcodehttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            getcodehttp.onreadystatechange = function () {
                if (getcodehttp.readyState == 4 && getcodehttp.status == 200) {
                    $("#ansarea").val(getcodehttp.responseText);
                    var xmlhttp;
                    if (window.XMLHttpRequest) {
                        // code for IE7+, Firefox, Chrome, Opera, Safari
                        xmlhttp = new XMLHttpRequest();
                    }
                    else {
                        // code for IE6, IE5
                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    xmlhttp.onreadystatechange = function () {
                        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                            if (xmlhttp.responseText.substring(0, 2) != 'ok') {
                                $(thix).attr("class", "am-btn am-btn-default");
                                $(thix).attr("disabled", "disabled");
                                $(thix).html(xmlhttp.responseText);
                                $.AMUI.progress.done();
                            }
                            else {
                                $(thix).html("<i class='am-icon-spinner am-icon-spin'></i> 提交成功");
                                $(thix).attr("class", "am-btn am-btn-warning");
                                $(thix).attr("disabled", "disabled");
                                $.AMUI.progress.done();
                                setTimeout(getans(thix, xmlhttp.responseText.substring(3)),<?php print($TIME_TO_GETANS); ?>);
                            }

                        }
                    }
                    $('#my-prompt').modal();
                    $(function () {
                        var $prompt = $('#my-prompt');
                        var $confirmBtn = $prompt.find('[data-am-modal-confirm]');
                        var $cancelBtn = $prompt.find('[data-am-modal-cancel]');
                        $confirmBtn.unbind("click");
                        $confirmBtn.on('click', function (e) {
                            // do something
                            xmlhttp.open("POST", 'submit.php', true);
                            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                            //alert(encodeURIComponent($("#ansarea").val()));
                            xmlhttp.send("pid=" + x + "&ans=" + encodeURIComponent($("#ansarea").val()));
                            $("#ansarea").val("");
                            $.AMUI.progress.start();
                        });

                        //$cancelBtn.off('click.cancel.modal.amui').on('click', function() {
                        // do something
                        // });
                    });
                    $.AMUI.progress.done();
                }
            }
            getcodehttp.open("GET", "showcode.php?pid=" + x, true);
            getcodehttp.send();
            $.AMUI.progress.start();
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
            <!-- <li><a href="javascript:;"><span class="am-icon-envelope-o"></span> 收件箱 <span class="am-badge am-badge-warning">5</span></a></li> -->
            <li class="am-dropdown" data-am-dropdown>
                <a class="am-dropdown-toggle" data-am-dropdown-toggle href="javascript:;">
                    <span class="am-icon-users"></span> <?php print($_SESSION['nick']); ?> <span
                        class="am-icon-caret-down"></span>
                </a>
                <ul class="am-dropdown-content">
                    <!--                     <li><a href="#"><span class="am-icon-user"></span> 资料</a></li>-->
                    <?php

                    if (isset($_SESSION['administrator']) || isset($_SESSION['contest_creator'])) {
                        print "<li><a href='admin.php'><span class='am-icon-cog'></span> 管理</a></li>";
                    }
                    ?>
                    <li><a href="logout.php"><span class="am-icon-power-off"></span> 退出</a></li>
                </ul>
            </li>
            <li class="am-hide-sm-only"><a href="javascript:;" id="admin-fullscreen"><span
                        class="am-icon-arrows-alt"></span> <span class="admin-fullText">开启全屏</span></a></li>
        </ul>
    </div>
</header>
<div class="am-g">
    <h1 style="text-align:center; margin:0;"><?php require_once 'config.php';
        print($CONTEXT_NAME); ?></h1>
</div>
<div class="am-g">
    <h4 style="text-align:center; margin:0; color:red;"><?php require_once 'config.php';
        print($BEGIN_TIME . '——' . $END_TIME); ?></h4>
</div>
<hr/>
<div class="am-g">
    <div class="am-u-lg-6 am-u-md-8 am-u-sm-centered">
        <table class="am-table am-table-bordered am-table-radius am-table-centered">
            <tr>
                <td>点击右侧按钮下载试题压缩包</td>
                <td><a class="am-btn am-btn-primary" href="<?php require_once 'config.php';
                    print($PROBLEM_RAR); ?>">点击下载</a></td>
            </tr>
            <?php require_once 'config.php'; ?>
            <?php
            require_once 'DBCN.php';
            require_once 'config.php';
            $db = new DB();
            //查询
            $data['contest_code'] = $CONTEST_CODE;
            $judge['contest_code'] = '=';
            $data['user_id'] = $_SESSION['user_id'];
            $judge['user_id'] = '=';
            $judge['pid'] = '=';
            foreach ($problemArray as $key => $value) {
                if ($key != '0') {
                    $des = $value['des'];
                    print("<tr><td>$key.$des</td>");
                    $data['pid'] = $key;
                    list($conSql, $mapConData) = $db->FDFields($data, 'and', $judge);
                    $mData = $db->fetch('select * from blueSySSubmit where ' . $conSql . ' order by `submit_id` desc', $mapConData);
                    if ($mData && isset($mData['submit_id']) && $mData['submit_id'] != '') {
                        $submitid = $mData['submit_id'];
                        $js = "getans('#btn" . $key . "',$submitid)";
                    };
                    print("<td><button class='am-btn am-btn-primary' id='btn$key' onclick='showSubmit(this,$key);'>提 交</button></td>");
                    if (isset($js)) print("<script type='text/javascript'>$js</script>");
                }
            }
            ?>
        </table>
    </div>
</div>
<?php include_once "blue-footer.php" ?>

<div class="am-modal am-modal-prompt" tabindex="-1" id="my-prompt">
    <div class="am-modal-dialog">
        <div class="am-modal-hd">提交窗口</div>
        <div class="am-modal-bd">
            <p style="color:red;">结果填空只需要填结果和空缺代码，请不要有多余的空格。</p>
            <textarea style="width:100%;" id="ansarea" cols="65" rows="5"></textarea>
        </div>
        <div class="am-modal-footer">
            <span class="am-modal-btn" data-am-modal-cancel>取消</span>
            <span class="am-modal-btn" data-am-modal-confirm>提交</span>
        </div>
    </div>
</div>

<!--[if (gte IE 9)|!(IE)]><!-->
<script src="assets/js/jquery.min.js"></script>
<!--<![endif]-->
<script src="assets/js/amazeui.min.js"></script>
<script src="assets/js/app.js"></script>
</body>
</html>