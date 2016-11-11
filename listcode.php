<?php
/**
 * Created by PhpStorm.
 * User: gongcy
 * Date: 16-11-1
 * Time: 下午9:30
 */
session_start();
if (!isset($_SESSION['user_id'])) {
    die("用户未登录!");
}