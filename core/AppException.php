<?php
/*********************
        异常处理
**********************/

class AppException extends Exception {

    // 异常处理
    static $errorCode;      // 错误代码
    static $errorMessage;   // 错误信息
    static $errorFile;      // 错误文件
    static $errorLine;      // 错误行数
    public static function exceptionHandle($exception) {
        // 清空内容
        @ob_end_clean();
        // 赋值错误代码规则
        $codeMap = self::codeMap();
        // 赋值错误详情
        self::$errorCode    = $exception->getCode();
        self::$errorMessage = $exception->getMessage();
        self::$errorFile    = $exception->getFile();
        self::$errorLine    = $exception->getLine();
        // 设置 HTTP 状态码
        if (self::$errorCode === 0) self::$errorCode = 502;
        if (is_numeric(self::$errorCode) && self::$errorCode > 200) header((isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.1') . ' ' . self::$errorCode . ' ' . $codeMap[self::$errorCode], true, self::$errorCode);
        // 检测调试环境
        if (APP_DEBUG) {
            echo '<pre><code>';
            echo '错误代码: ' . self::$errorCode    . '<br>';
            echo '错误信息: ' . self::$errorMessage . '<br>';
            echo '错误文件: ' . self::$errorFile    . '<br>';
            echo '错误行数: ' . self::$errorLine    . '<br>';
            echo '</code></pre>';
        } else {
            // 写入错误日志
            error_log(PHP_EOL . '时间: ' . date("Y-m-d H:i:s") . PHP_EOL . 'IP: ' . $_SERVER['REMOTE_ADDR'] . PHP_EOL . 'UA: ' . $_SERVER['HTTP_USER_AGENT'] . PHP_EOL . '错误代码: ' . self::$errorCode . PHP_EOL . '错误信息: ' . self::$errorMessage . PHP_EOL . '错误文件: ' . self::$errorFile . PHP_EOL . '错误行数: ' . self::$errorLine . PHP_EOL, 3, APP_PATH. 'logs/error.log');
        }
        // 结束程序
        exit;
    }

    // 错误代码映射关系
    private static function codeMap() {
        return [
            100 => 'Continue',
            101 => 'Switching Protocols',
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            307 => 'Temporary Redirect',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported'
        ];
    }

}
