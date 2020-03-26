<?php
/*********************
      options 模型
**********************/
namespace Core\Models;
use Core\Model;

class optionsModel extends Model {

    // 获取单条数据
    public function get($name) {
        return $this->where('name = ?')->param($name)->select()->fetch();
    }

    // 获取所有数据
    public function getAll() {
        return $this->select()->fetchAll('name');
    }

    // 添加一条数据
    public function add() {
        if ($this->insert(['name' => 'test', 'value' => '123'])->rowCount() === 1) {
            echo '添加成功';
        } else {
            echo '添加失败';
        }
    }

    // 更新一条数据
    public function set() {
        if ($this->where('name = ?')->param('test')->update(['name' => 'newTest', 'value' => 'new123'])->rowCount() === 1) {
            echo '更新成功';
        } else {
            echo '更新失败';
        }
    }

    // 删除一条数据
    public function del() {
        if ($this->where('name = ?')->param('test')->delete()->rowCount() === 1) {
            echo '删除成功';
        } else {
            echo '删除失败';
        }
    }

}
