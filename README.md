# TinyPHP

## 简介

TinyPHP 是一个基础的 PHP MVC 框架模板，仅对「路由」「数据库」「异常」「错误」进行简单的封装，通过此项目你可以更快理解一个 MVC 框架的实现。

## 环境要求

- PHP >= 7.0
- MySQL >= 5.0

## 安装

首次打开 TinyPHP 会载入一个简陋的「安装程序」，按照要求填写相关配置信息即可完成安装。「安装程序」会创建一系列供演示用的数据库表、数据

## 调试模式

默认是开启的，如果程序捕获到「异常」「错误」会直接输出到页面上，如果程序用户生产环境请手动关闭。到 `config.inc.php` 文件里找到 `APP_DEBUG` 选项，设置为 `false`。（ 注意：关闭状态下所有异常、错误会记录到错误日志，你可以到 `logs\error.log` 找到历史错误 ）

## 伪静态

如果需要 URL伪静态 需要手动开启，首先到 `config.inc.php` 文件里找到 `URL_REWRITE` 选项，设置为 `true`。接下来根据你的服务器环境配置 `rewrite` 规则。

#### Nginx:
```
if (!-e $request_filename) {
    rewrite ^(.*)$ /index.php$1 last;
}
```

#### Apache:
```
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase /
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php [L,E=PATH_INFO:$1]
</IfModule>
```

## 路由

「伪静态」的开启/关闭会决定「路由」对URL解析的方式

#### 伪静态: 开启

`https://www.xxxxx.com/post/get/1/2/3`

- 控制器: post
- 动作名: get
- 参数值: 1, 2, 3

#### 伪静态: 关闭

`https://www.xxxxx.com?c=post&a=get&p=1,2,3`

- 控制器: post
- 动作名: get
- 参数值: 1, 2, 3

## 控制器

#### 用途

主要用于按指令选择合适的模型，指定视图文件

#### 位置

`core\Controllers\`

#### 命名规范

`xxxxxController.php` 其中xxxxx是控制器命名，例如 `adminController.php` 那么当访问 `https://www.xxxxx.com/admin/` 就会加载此控制器（ 注意: 如果不指定方法名则默认执行控制器下的 `init` 方法 ）

#### $this->assign()

用于向 View基类 传递一个变量值，例如 `$this->assign('test', '123')` ，在视图文件中可以通过 `$this->variables['test']` 得到 `123`

#### $this->render()

用于向 View基类 指定一个视图文件进行加载, 例如 `$this->render('index.php')`，就会加载 `pages\index.php` 文件到视图中

## 模型

#### 用途

主要用于按指令操作数据库取出数据返回给控制器

#### 位置

`core\Models\`

#### 命名规范

`xxxxxModel.php` 其中xxxxx是模型命名，例如 `indexModel.php`

#### $this->execute()

用于操作数据库

```php
// 增
$this->execute("INSERT INTO " . DB_PREFIX . "users (username, password) VALUES (?, ?)", array($username, $password));
// 查
$this->execute("SELECT * FROM " . DB_PREFIX . "options")
// 删
$this->execute("DELETE FROM " . DB_PREFIX . "users WHERE uid = ?", array($uid));
// 改
$this->execute("UPDATE " . DB_PREFIX . "options SET value = ? WHERE name = ?", array($value, $name));
```

#### $this->fetch()

从结果集中返回一条以列名为索引的关联数组

#### $this->fetchAll()

从结果集中返回所有以列名为索引的关联数组

#### $this->rowCount()

返回受上一个SQL语句影响的行数

#### $this->lastInsertId()

返回最后插入行的ID或序列值

## 视图

#### 用途

主要用于渲染最终结果并呈献给用户

#### 位置

`pages\`

## 其他说明

请阅读源码...
