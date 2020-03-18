<?php
/*********************
        View基类
**********************/
namespace Core;
use Exception;

class View {

    // 分配变量
    private $variables = [];
    public function assign($name, $value) {
        $this->variables[$name] = $value;
    }

    // 渲染视图
    public function render($page) {
        $page = PAGES_PATH . $page;
        if (file_exists($page)) {
            include_once $page;
        } else {
            throw new Exception('无法匹配 ' . $page . ' 视图文件', 404);
        }
    }

}
