<?php
/*********************
        Model基类
**********************/
namespace Core;
use Exception;

class Model extends Db {

    // 构造函数
    private $_table;
    public function __construct() {
        // 获取表名
        $this->_table = DB_PREFIX . str_replace(['Core\\Models\\', 'Model'], '', get_class($this));
    }

    // 表名
    protected function table($name) {
        $this->_table = DB_PREFIX . $name;
        return $this;
    }

    // 参数
    private $_param;
    protected function param() {
        $this->_param = func_get_args();
        return $this;
    }

    // 条件
    private $_where;
    protected function where($where) {
        $this->_where = "WHERE {$where}";
        return $this;
    }

    // 排序
    private $_order;
    protected function order($name, $sort = 'ASC') {
        $this->_order = "ORDER BY `{$name}` {$sort}";
        return $this;
    }

    // 数量限制
    private $_limit;
    protected function limit($num = '50') {
        $this->_limit = "LIMIT {$num}";
        return $this;
    }

    // 查询
    protected function select($name = '*') {
        // 拼接SQL语句
        $sql = "SELECT {$name} FROM `{$this->_table}` {$this->_where} {$this->_order} {$this->_limit}";
        // 操作数据库
        $this->execute($sql, $this->_param);
        // 返回
        return $this;
    }

    // 增加
    protected function insert() {
        // 必须传递参数指定列名
        if (!func_num_args()) throw new Exception('insert方法必须传递参数指定列名', 500);
        // 参数预赋值
        $data        = func_get_args();
        $key         = '';
        $value       = '';
        $placeholder = '';
        // 遍历参数
        foreach ($data[0] as $k => $v) {
            $key         .= "`{$k}`,";
            $value       .= $v . ',';
            $placeholder .= '?,';
        }
        // 去除最右边的逗号
        $key         = rtrim($key  , ',');
        $value       = rtrim($value, ',');
        $placeholder = rtrim($placeholder, ',');
        // 字符串转数组
        $value  = explode(',', $value);
        // 拼接SQL语句
        $sql = "INSERT INTO `{$this->_table}` ({$key}) VALUES ({$placeholder})";
        // 操作数据库
        $this->execute($sql, $value);
        // 返回
        return $this;
    }

    // 更新
    protected function update() {
        // 必须传递参数指定列名
        if (!func_num_args()) throw new Exception('update方法缺少必要参数', 500);
        // 参数预赋值
        $data  = func_get_args();
        $key   = '';
        $value = '';
        // 遍历参数
        foreach ($data[0] as $k => $v) {
            $key   .= "`{$k}` = ?,";
            $value .= $v . ',';
        }
        // 去除最右边的逗号
        $key    = rtrim($key  , ',');
        $value  = rtrim($value, ',');
        // 字符串转数组
        $value  = explode(',', $value);
        // 合并数组
        $this->_param = array_merge($value,$this->_param);
        // 拼接SQL语句
        $sql = "UPDATE `{$this->_table}` SET {$key} {$this->_where}";
        // 操作数据库
        $this->execute($sql, $this->_param);
        // 返回
        return $this;
    }

    // 删除
    protected function delete() {
        // 拼接SQL语句
        $sql = "DELETE FROM `{$this->_table}` {$this->_where}";
        // 操作数据库
        $this->execute($sql, $this->_param);
        // 返回
        return $this;
    }

    // 初始化各项变量
    protected function initVar() {
        $this->_table = DB_PREFIX . str_replace(['Core\\Models\\', 'Model'], '', get_class($this));
        $this->_param = [];
        $this->_where = '';
        $this->_limit = '';
        $this->_order = '';
    }

}
