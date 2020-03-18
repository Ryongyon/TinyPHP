<?php
/*********************
     Controller基类
**********************/
namespace Core;

class Controller {

    // 构造函数：实例化 View 基类
    private $_view;
    public function __construct() {
        $this->_view = new View();
    }

    // 分配变量
    protected function assign($name, $value) {
        $this->_view->assign($name, $value);
    }

    // 渲染视图
    protected function render($page) {
        $this->_view->render($page);
    }
    
}
