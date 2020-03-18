<?php
/*********************
      index 模型
**********************/
namespace Core\Models;
use Core\Model;

class indexModel extends Model {

    // 获取 options
    private $options;
    public function getOptions() {
        // 操作数据库
        $this->execute("SELECT * FROM " . DB_PREFIX . "options");
        // 返回结果
        return $this->fetchAll('name');
    }

}
