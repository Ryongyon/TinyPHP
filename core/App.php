<?php
/*********************
        框架核心
**********************/

class App {

    // 初始化
    public function init() {
        // 开启 Session
        session_start();
        // 自动加载
        spl_autoload_register(array($this, 'loadClass'));
        // 错误处理
        set_error_handler(array('AppError', 'errorHandle'), E_ALL ^ E_NOTICE);
        // 异常处理
        set_exception_handler(array('AppException', 'exceptionHandle'));
        // 检测敏感字符并删除
        $this->removeMagicQuotes();
        // 检测自定义全局变量并移除
        $this->unregisterGlobals();
        // 安装
        $this->install();
        // 路由
        $this->router();
    }

    // 自动加载
    private function loadClass($className) {
        if (strpos($className, '\\') !== false) {
            $file = APP_PATH . lcfirst(str_replace('\\', '/', $className)) . '.php';
        } else {
            $file = CORE_PATH . $className . '.php';
        }
        include $file;
    }

    // 检测敏感字符并删除
    private function removeMagicQuotes() {
        $_GET     = isset($_GET)     ? $this->stripSlashesDeep($_GET)     : '';
        $_POST    = isset($_POST)    ? $this->stripSlashesDeep($_POST)    : '';
        $_COOKIE  = isset($_COOKIE)  ? $this->stripSlashesDeep($_COOKIE)  : '';
        $_SESSION = isset($_SESSION) ? $this->stripSlashesDeep($_SESSION) : '';
    }
    
    // 删除敏感字符
    private function stripSlashesDeep($value) {
        $value = is_array($value) ? array_map(array($this, 'stripSlashesDeep'), $value) : stripslashes($value);
        return $value;
    }

    // 检测自定义全局变量并移除
    private function unregisterGlobals() {
        if (ini_get('register_globals')) {
            $array = array('_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');
            foreach ($array as $value) {
                foreach ($GLOBALS[$value] as $key => $var) {
                    if ($var === $GLOBALS[$key]) {
                        unset($GLOBALS[$key]);
                    }
                }
            }
        }
    }

    // 安装
    private function install() {
        // 尝试连接数据库判断是否需要安装
        try {
            Core\Db::PDO();
        } catch (Exception $e) {
            // 载入安装引导文件
            include 'install.php';
            // 结束程序
            exit;
        }
    }

    // 路由
    private function router() {
        // 变量预赋值
        $controller = 'index';      // 默认控制器
        $method     = 'init';       // 默认动作
        $param      = [];           // 默认参数
        // 是否开启伪静态
        if (URL_REWRITE) {
            // 获取Url
            $url      = trim($_SERVER['REQUEST_URI'], '/');
            $position = strpos($url, '?');
            // 删除 '?' 以及之后的内容
            $url = $position === false ? $url : substr($url, 0, $position);
            // 使用 '/' 分割字符串为数组
            $url = explode('/', $url);
            // 删除空的数组元素
            $url = array_filter($url);
            // 赋值控制器名
            $controller = $url[0] && $url[0] !== 'index.php' ? $url[0] : $controller;
            // 赋值动作名
            $method     = $url[1] ? $url[1] : $method;
            // 赋值参数值
            array_splice($url,0,2);
            $param = $url ? $url : $param;
        } else {
            // 删除 '?' 以及之前的内容 $url = $position === false ? $url : substr($url, strpos($url, "?") + 1);
            // 赋值控制器名
            $controller = $_GET['c'] ? $_GET['c']: $controller;
            // 赋值动作名
            $method     = $_GET['a'] ? $_GET['a']: $method;
            // 赋值参数值
            $param      = $_GET['p'] ? explode(',', $_GET['p']): $param;
        }
        // 判断控制器和动作是否存在
        $controller = 'Core\\Controllers\\'. $controller . 'Controller';
        if (!class_exists($controller)) throw new Exception('无法匹配 ' . $controller . ' 控制器', 404);
        if (!method_exists($controller, $method)) throw new Exception('无法匹配 ' . $method . ' 动作', 404);
        // 实例化控制器
        $dispatch = new $controller();
        call_user_func_array(array($dispatch, $method), $param);
    }

}
