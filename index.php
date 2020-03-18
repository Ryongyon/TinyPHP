<?php
/*********************
        入口文件
**********************/

// 载入配置
require_once('config.inc.php');

// 载入框架
require_once(CORE_PATH . 'App.php');

// 初始化
(new App())->init();
