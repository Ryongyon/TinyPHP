<?php
/*********************
        配置文件
**********************/

// 调试模式
define('APP_DEBUG', true);

// 伪静态
define('URL_REWRITE', false);

// 路径配置
define('APP_PATH'        , __DIR__   . '/');            // 主目录
define('PAGES_PATH'      , APP_PATH  . 'pages/');       // 视图目录
define('CORE_PATH'       , APP_PATH  . 'core/');        // 核心目录
define('CONTROLLERS_PATH', CORE_PATH . 'controllers/'); // 控制器目录
define('MODELS_PATH'     , CORE_PATH . 'models/');      // 模型目录

// 数据库配置
define('DB_HOST'   , '%1%');
define('DB_PORT'   , '%2%');
define('DB_USER'   , '%3%');
define('DB_PASS'   , '%4%');
define('DB_NAME'   , '%5%');
define('DB_PREFIX' , '%6%');
define('DB_CHARSET', '%7%');
