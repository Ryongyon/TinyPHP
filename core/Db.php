<?php
/*********************
        数据库
**********************/
namespace Core;
use PDO;
use Exception;

class Db {

    // 单例连接
    private static $PDO = null;
    public static function PDO() {
        // 其$PDO属性为静态属性，所以在页面执行周期内，只要一次赋值，以后的获取还是首次赋值的内容
        if (self::$PDO !== null) return self::$PDO;
        // 连接数据库
        try {
            $dsn    = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=%s', DB_HOST, DB_PORT, DB_NAME, DB_CHARSET);
            $option = [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // 默认提取模式: 返回一个索引为结果集列名的数组
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // 异常处理模式: 抛出 exceptions 异常
                PDO::ATTR_PERSISTENT         => false                   // 持久化连接
            ];
            return self::$PDO = new PDO($dsn, DB_USER, DB_PASS, $option);
        } catch (Exception $e) {
            throw new Exception('无法连接数据库：' . $e->getMessage(), 500);
        }
    }

    // 数据库操作
    private $object;
    public function execute($sql, $param = null, $search = false) {
        if (is_null($param)) {
            try {
                $this->object = self::PDO()->prepare($sql);
                $this->object->execute();
            } catch (Exception $e) {
                throw new Exception('数据库操作失败：' . $e->getMessage(), 500);
            }
        } else {
            try {
                $this->object = self::PDO()->prepare($sql);
                for ($i = 0; $i < count($param); ++$i) {
                    if (is_string($param[$i])) {
                        if ($search == true) {
                            $this->object->bindValue($i + 1, "$param[$i]%", PDO::PARAM_STR);
                        } else {
                            $this->object->bindParam($i + 1, $param[$i], PDO::PARAM_STR);
                        }
                    } elseif (is_bool($param[$i])) {
                        $this->object->bindParam($i + 1, $param[$i], PDO::PARAM_BOOL);
                    } else {
                        $this->object->bindParam($i + 1, $param[$i], PDO::PARAM_INT);
                    }
                }
                $this->object->execute();
                $this->initVar();
            } catch (Exception $e) {
                throw new Exception('数据库操作失败：' . $e->getMessage(), 500);
            }
        }
    }

    // 从结果集中返回一条以列名为索引的关联数组
    public function fetch() {
        return $this->object->fetch(PDO::FETCH_ASSOC);
    }

    // 从结果集中返回所有以列名为索引的关联数组
    public function fetchAll($key = null) {
        $results = $this->object->fetchAll(PDO::FETCH_ASSOC);
        // 允许使用结果中的列作为数组的键来检索结果
        if ($key != null && $results[0][$key]) {
            $keyed_results = array();
            foreach ($results as $result) {
                $keyed_results[$result[$key]] = $result;
            }
            $results = $keyed_results;
        }
        return $results;
    }

    // 返回受上一个SQL语句影响的行数
    public function rowCount() {
        return $this->object->rowCount();
    }

    // 返回最后插入行的ID或序列值
    public function lastInsertId() {
        return self::$PDO->lastInsertId();
    }

    // 获取跟数据库句柄上一次操作相关的 SQLSTATE
    public function errorCode() {
        return self::$PDO->errorCode();
    }

}
