<?php
/*********************
      index 控制器
**********************/
namespace Core\Controllers;
use Core\Controller;
use Core\Models\optionsModel;

class indexController extends Controller {

    // 初始化
    public function init() {
        // 操作模型
        $options = (new optionsModel())->getAll();
        // 分配变量
        $this->assign('options', $options);
        // 渲染视图
        $this->render('index.php');
    }
    
}
