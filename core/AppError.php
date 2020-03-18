<?php
/*********************
        错误处理
**********************/

class AppError extends Error {

    // 错误处理
    static $errorType;      // 错误类型
    static $errorMessage;   // 错误信息
    static $errorFile;      // 错误文件
    static $errorLine;      // 错误行数
    public static function errorHandle($errorType, $errorMessage, $errorFile, $errorLine) {
        // 赋值错误类型规则
        $typeMap = self::typeMap();
        // 赋值错误详情
        self::$errorType    = $typeMap[$errorType];
        self::$errorMessage = $errorMessage;
        self::$errorFile    = $errorFile;
        self::$errorLine    = $errorLine;
        // 检测调试环境
        if (APP_DEBUG) {
            echo '<pre><code>';
            echo '错误类型: ' . self::$errorType    . '<br>';
            echo '错误信息: ' . self::$errorMessage . '<br>';
            echo '错误文件: ' . self::$errorFile    . '<br>';
            echo '错误行数: ' . self::$errorLine    . '<br>';
            echo '</code></pre>';
        } else {
            // 写入错误日志
            error_log(PHP_EOL . '时间: ' . date("Y-m-d H:i:s") . PHP_EOL . 'IP: ' . $_SERVER['REMOTE_ADDR'] . PHP_EOL . 'UA: ' . $_SERVER['HTTP_USER_AGENT'] . PHP_EOL . '错误类型: ' . self::$errorType . PHP_EOL . '错误信息: ' . self::$errorMessage . PHP_EOL . '错误文件: ' . self::$errorFile . PHP_EOL . '错误行数: ' . self::$errorLine . PHP_EOL, 3, APP_PATH. 'logs/error.log');
        }
    }

    // 错误类型映射关系
    private static function typeMap() {
        return [
            E_ERROR             => 'E_ERROR',
            E_WARNING           => 'E_WARNING',
            E_PARSE             => 'E_PARSE',
            E_NOTICE            => 'E_NOTICE',
            E_CORE_ERROR        => 'E_CORE_ERROR',
            E_CORE_WARNING      => 'E_CORE_WARNING',
            E_COMPILE_ERROR     => 'E_COMPILE_ERROR',
            E_COMPILE_WARNING   => 'E_COMPILE_WARNING',
            E_USER_ERROR        => 'E_USER_ERROR',
            E_USER_WARNING      => 'E_USER_WARNING',
            E_USER_NOTICE       => 'E_USER_NOTICE',
            E_STRICT            => 'E_STRICT',
            E_RECOVERABLE_ERROR => 'E_RECOVERABLE_ERROR',
            E_DEPRECATED        => 'E_DEPRECATED',
            E_USER_DEPRECATED   => 'E_USER_DEPRECATED',
            E_ALL               => 'E_ALL'
        ];
    }

}
