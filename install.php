<?php if (!defined('APP_PATH')) exit; ?>
<?php
if (!empty($_GET) || !empty($_POST)) {
    // 阻止跨站请求
    if (empty($_SERVER['HTTP_REFERER'])) exit;
    $parts = parse_url($_SERVER['HTTP_REFERER']);
    if (!empty($parts['port'])) $parts['host'] = "{$parts['host']}:{$parts['port']}";
    if (empty($parts['host']) || $_SERVER['HTTP_HOST'] != $parts['host']) exit;
} else {
    // 生成Token
    $_SESSION['install']['token'] = md5(time() + mt_rand());
}
if ($_GET['install'] === 'start') {
    // 开始安装
    if ($_POST['token'] !== $_SESSION['install']['token']) throw new Exception('TOKEN认证失败, 请重试!', 500);
    // 赋值变量
    $title       = $_POST['title'];
    $description = $_POST['description'];
    $keywords    = $_POST['keywords'];
    $db_host     = $_POST['db_host'];
    $db_port     = $_POST['db_port'];
    $db_user     = $_POST['db_user'];
    $db_pass     = $_POST['db_pass'];
    $db_name     = $_POST['db_name'];
    $db_prefix   = $_POST['db_prefix'];
    $db_charset  = $_POST['db_charset'];
    $time        = time();
    // 尝试连接数据库
    try {
        $dsn    = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=%s', $db_host, $db_port, $db_name, $db_charset);
        $db     = new PDO($dsn, $db_user, $db_pass);
    } catch (Exception $e) {
        unset($_SESSION['install']['token']);
        throw new Exception('无法连接数据库：' . $e->getMessage(), 500);
    }
    // 创建数据库
    $db->query("CREATE TABLE `{$db_prefix}options`
        (
        `name` varchar(32) NOT NULL,
        `value` mediumtext NULL
        );"
    );
    $db->query("CREATE TABLE `{$db_prefix}users`
        (
        `uid` int(10) unsigned NOT NULL COMMENT '用户唯一标识' AUTO_INCREMENT PRIMARY KEY,
        `username` varchar(32) NULL COMMENT '用户名',
        `nickname` varchar(32) NULL COMMENT '昵称',
        `password` varchar(64) NULL COMMENT '密码',
        `email` varchar(200) NULL COMMENT '邮箱',
        `url` varchar(200) NULL COMMENT '个人网站',
        `phone` varchar(16) NULL COMMENT '手机号',
        `avatar` varchar(200) NULL COMMENT '头像',
        `intro` varchar(200) NULL COMMENT '简介',
        `created` int(10) unsigned NULL COMMENT '注册时间',
        `activated` int(10) unsigned NULL COMMENT '本次登录时间',
        `logged` int(10) unsigned NULL COMMENT '上次登录时间',
        `group` varchar(16) NULL COMMENT '用户组',
        `authCode` varchar(64) NULL COMMENT '授权码'
        );
    ");
    // 插入数据
    $db->query("INSERT INTO `{$db_prefix}options` (`name`, `value`) VALUES ('title', '{$title}');");
    $db->query("INSERT INTO `{$db_prefix}options` (`name`, `value`) VALUES ('description', '{$description}');");
    $db->query("INSERT INTO `{$db_prefix}options` (`name`, `value`) VALUES ('keywords', '{$keywords}');");
    $db->query("INSERT INTO `{$db_prefix}users` (`username`, `nickname`, `password`, `created`, `group`) VALUES ('admin', 'admin', 'admin', '{$time}', 'administrator');");
    // 载入配置文件
    $config = file_get_contents('config.inc.php');
    // 替换数据库配置
    $config = str_replace(['%1%', '%2%', '%3%', '%4%', '%5%', '%6%', '%7%'], [$db_host, $db_port, $db_user, $db_pass, $db_name, $db_prefix, $db_charset], $config);
    // 写入文件
    file_put_contents('config.inc.php',$config);
    // 刷新页面
    header("Location: /");
    // 结束程序
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="x-dns-prefetch-control" content="on">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="renderer" content="webkit">
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
<meta http-equiv="Cache-Control" content="no-transform">
<meta http-equiv="Cache-Control" content="no-siteapp">
<meta name="keywords" content="">
<meta name="description" content="">
<title>TinyPHP - 安装引导</title>
<link rel="icon" href="favicon.ico">
<style>
html{line-height:1.15;-webkit-text-size-adjust:100%}
body{margin:0}
main{display:block}
hr{overflow:visible;box-sizing:content-box;height:0}
a{background-color:transparent}
abbr[title]{border-bottom:none;text-decoration:underline;text-decoration:underline dotted}
b,strong{font-weight:bolder}
pre,code,kbd,samp{font-size:1em;font-family:monospace,monospace}
small{font-size:80%}
sub,sup{position:relative;vertical-align:baseline;font-size:75%;line-height:0}
sub{bottom:-.25em}
sup{top:-.5em}
img{border-style:none}
button,input,optgroup,select,textarea{margin:0;font-size:100%;font-family:inherit;line-height:1.15}
button,input{overflow:visible}
button,select{text-transform:none}
[type=button],[type=reset],[type=submit],button{-webkit-appearance:button}
[type=button]::-moz-focus-inner,[type=reset]::-moz-focus-inner,[type=submit]::-moz-focus-inner,button::-moz-focus-inner{padding:0;border-style:none}
[type=button]:-moz-focusring,[type=reset]:-moz-focusring,[type=submit]:-moz-focusring,button:-moz-focusring{outline:1px dotted ButtonText}
fieldset{padding:.35em .75em .625em}
legend{display:table;box-sizing:border-box;padding:0;max-width:100%;color:inherit;white-space:normal}
progress{vertical-align:baseline}
textarea{overflow:auto}
[type=checkbox],[type=radio]{box-sizing:border-box;padding:0}
[type=number]::-webkit-inner-spin-button,[type=number]::-webkit-outer-spin-button{height:auto}
[type=search]{outline-offset:-2px;-webkit-appearance:textfield}
[type=search]::-webkit-search-cancel-button,[type=search]::-webkit-search-decoration{-webkit-appearance:none}
::-webkit-file-upload-button{font:inherit;-webkit-appearance:button}
details{display:block}
summary{display:list-item}
template{display:none}
[hidden]{display:none}
*,:after,:before{-webkit-box-sizing:border-box;box-sizing:border-box}
html{font-size:20px;line-height:1.5;-webkit-text-size-adjust:100%;-webkit-tap-highlight-color:transparent}
body{overflow-x:hidden;background:#fff;color:#303133;font-size:.7rem;font-family:Helvetica Neue,Helvetica,PingFang SC,Hiragino Sans GB,Microsoft YaHei,SimSun,sans-serif;text-rendering:geometricPrecision;-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}
body,html{height:100%}
#app{height:100%}
h1{font-size:1.8rem}
h2{font-size:1.6rem}
h3{font-size:1.4rem}
h4{font-size:1.2rem}
h5{font-size:1rem}
h6{font-size:.8rem}
h1,h2,h3,h4,h5,h6{margin-top:0;margin-bottom:.5em;font-weight:400;line-height:1.2}
abbr[title]{border-bottom:.05rem dotted;text-decoration:none;cursor:help}
ins,u{border-bottom:.05em solid;text-decoration:none}
blockquote{margin-right:0;margin-left:0;padding:.2rem .8rem;border-left:.15rem solid #eee}
code,kbd,pre,samp{font-size:1em;font-family:inherit}
code,kbd,mark{padding:.175rem .25rem;border-radius:4px}
kbd{background:#333;color:#fff}
mark{background:#ffe9b3;color:#333}
code{background:#eee;color:#333}
pre{position:relative;-webkit-overflow-scrolling:touch}
pre code{display:block;overflow-x:auto;margin:0;padding:1rem;background:#eee;line-height:1.5}
pre::before{position:absolute;top:.1rem;right:.4rem;color:#909399;content:attr(data-language);font-size:.5rem;font-family:inherit}
.container{display:flex;box-sizing:border-box;height:100%;min-width:0;flex-direction:row;flex:1;flex-basis:auto}
.container.is-vertical{flex-direction:column}
.footer,.header{padding:0 20px;height:60px;line-height:60px;flex-shrink:0}
.main{display:block;padding:20px;flex:1;flex-basis:auto}
.divider{display:block;margin:16px 0;height:1px;border-top:1px solid #dcdfe6;text-align:left}
.divider[data-content]::after{display:inline-block;padding:0 8px;background:#fff;content:attr(data-content);font-size:14px;transform:translate(20px,-50%)}
.form{margin:0 auto;max-width:640px}
.form-item{margin-bottom:20px}
.form-item-label{float:left;box-sizing:border-box;padding:0 12px 0 0;width:80px;color:#606266;vertical-align:middle;text-align:right;font-size:14px;line-height:40px}
.form-item-content{position:relative;margin-left:80px;font-size:14px;line-height:40px}
.form-input{display:inline-block;padding:0 15px;width:100%;height:40px;outline:0;border:1px solid #dcdfe6;border-radius:4px;background-color:#fff;background-image:none;color:#606266;font-size:inherit;line-height:40px;transition:border-color .2s cubic-bezier(.645,.045,.355,1);-webkit-appearance:none}
.form-input:hover{border-color:#c0c4cc}
.form-input:focus{border-color:#409eff}
.btn{display:inline-block;margin:0;padding:12px 20px;outline:0;border:1px solid #dcdfe6;border-radius:4px;background:#fff;color:#606266;text-align:center;white-space:nowrap;font-weight:500;font-size:14px;line-height:1;cursor:pointer;transition:.1s;-webkit-appearance:none;-moz-user-select:none;-webkit-user-select:none;-ms-user-select:none}
.btn-primary{border-color:#409eff;background-color:#409eff;color:#fff}
.btn-primary:hover{border-color:#66b1ff;background:#66b1ff;color:#fff}
.btn-primary:active{border-color:#3a8ee6;background:#3a8ee6;color:#fff}
</style>
</head>
<body>
    <div id="app">
        <section class="container is-vertical">
            <header class="header"></header>
            <main class="main" style="text-align:center">
                <h1 style="margin-bottom:60px;">安装引导</h1>
                <form class="form" method="post" action="?install=start">
                    <div class="divider" data-content="网站配置" style="margin:40px 0"></div>
                    <div class="form-item">
                        <label class="form-item-label form-label">标题</label>
                        <div class="form-item-content">
                            <input class="form-input" type="text" name="title" value="网站标题" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="form-item">
                        <label class="form-item-label form-label">描述</label>
                        <div class="form-item-content">
                            <input class="form-input" type="text" name="description" value="网站描述" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="form-item">
                        <label class="form-item-label form-label">关键词</label>
                        <div class="form-item-content">
                            <input class="form-input" type="text" name="keywords" value="网站关键词" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="divider" data-content="数据库配置" style="margin:40px 0"></div>
                    <div class="form-item">
                        <label class="form-item-label form-label">地址</label>
                        <div class="form-item-content">
                            <input class="form-input" type="text" name="db_host" value="localhost" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="form-item">
                        <label class="form-item-label form-label">端口</label>
                        <div class="form-item-content">
                            <input class="form-input" type="text" name="db_port" value="3306" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="form-item">
                        <label class="form-item-label form-label">用户名</label>
                        <div class="form-item-content">
                            <input class="form-input" type="text" name="db_user" value="root" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="form-item">
                        <label class="form-item-label form-label">密码</label>
                        <div class="form-item-content">
                            <input class="form-input" type="text" name="db_pass" value="" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="form-item">
                        <label class="form-item-label form-label">数据库名</label>
                        <div class="form-item-content">
                            <input class="form-input" type="text" name="db_name" value="tinyphp" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="form-item">
                        <label class="form-item-label form-label">前缀</label>
                        <div class="form-item-content">
                            <input class="form-input" type="text" name="db_prefix" value="tinyphp_" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="form-item">
                        <label class="form-item-label form-label">字符集</label>
                        <div class="form-item-content">
                            <input class="form-input" type="text" name="db_charset" value="utf8mb4" autocomplete="off" required>
                        </div>
                    </div>
                    <input type="hidden" name="token" value="<?php echo $_SESSION['install']['token']; ?>">
                    <button type="submit" class="btn btn-primary" style="float:right"><span>开始安装</span></button>
                </form>
            </main>
            <footer class="footer"></footer>
        </section>
    </div>
</body>
</html>
