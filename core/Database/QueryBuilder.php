<?php
/**
 * Created by PhpStorm.
 * User: jefftan
 * Date: 17-8-21
 * Time: 下午1:38
 */

namespace Core\Database;

use Core\Application;
use PDO;

class QueryBuilder
{
    protected $pdo;

    protected $table;

    protected $where = '';

    protected $columns = '';

    protected $createStatement = '';

    protected $updateStatement = '';

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function table($name)
    {
        $this->table = $name;
        return $this;
    }

    public function whereAnd(array $datas)
    {
        if (empty($datas)) $this->where = '';
        else {
            $tempCount = 0;
            foreach ($datas as $key => $value) {
                if ($tempCount == count($datas) - 1) {
                    $this->where .= $key . ' = ' . $value;
                } else {
                    $this->where .= $key . ' = ' . $value . ' and ';
                }
                $tempCount++;
            }
        }
        return $this;
    }

    public function whereOr(array $datas)
    {
        if (empty($datas)) $this->where = '';
        else {
            $tempCount = 0;
            foreach ($datas as $key => $value) {
                if ($tempCount == count($datas) - 1) {
                    $this->where .= $key . ' = ' . $value;
                } else {
                    $this->where .= $key . ' = ' . $value . ' or ';
                }
                $tempCount++;
            }
        }
        return $this;
    }

    public function all()
    {
        if (empty($this->where))
            $statement = $this->pdo->prepare("select * from {$this->table}");
        else
            $statement = $this->pdo->prepare("select * from {$this->table} where {$this->where}");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get($columns = "*")
    {
        if ($columns == "*") {
            if (empty($this->where))
                $statement = $this->pdo->prepare("select * from {$this->table}");
            else
                $statement = $this->pdo->prepare("select * from {$this->table} where {$this->where}");
        } else {
            $this->filterColumn($columns);
            if (empty($this->where))
                $statement = $this->pdo->prepare("select {$this->columns} from {$this->table}");
            else
                $statement = $this->pdo->prepare("select {$this->columns} from {$this->table} where {$this->where}");
        }
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function first($columns = "*")
    {
        if ($columns == "*") {
            if (empty($this->where))
                $statement = $this->pdo->prepare("select * from {$this->table} limit 1");
            else
                $statement = $this->pdo->prepare("select * from {$this->table} where {$this->where} limit 1");
        } else {
            $this->filterColumn($columns);
            if (empty($this->where))
                $statement = $this->pdo->prepare("select {$this->columns} from {$this->table} limit 1");
            else
                $statement = $this->pdo->prepare("select {$this->columns} from {$this->table} where {$this->where} limit 1");
        }
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function create(array $datas)
    {
        if (empty($datas)) return false;
        $this->prepareCreateSql($datas);
        $statement = $this->pdo->prepare("insert into {$this->table} {$this->createStatement}");
        $result = $statement->execute();
        return $result;
    }

    public function update(array $datas)
    {
        if (empty($this->where)) return false;

        $this->prepareUpdateSql($datas);
        $statement = $this->pdo->prepare("update {$this->table} set {$this->updateStatement} where {$this->where}");
        $result = $statement->execute();
        return $result;
    }

    public function delete()
    {
        if (empty($this->where)) return false;
        else {
            $statement = $this->pdo->prepare("delete from {$this->table} where {$this->where}");
            $result = $statement->execute();
        }
        return $result;
    }

    public function deleteAll()
    {
        $statement = $this->pdo->prepare("delete from {$this->table}");
        $result = $statement->execute();
        return $result;
    }

    private function filterColumn($columns)
    {
        $tempCount = 0;
        foreach ($columns as $column) {
            if ($tempCount == count($columns) - 1) {
                $this->columns .= $column;
            } else {
                $this->columns .= $column . ',';
            }
            $tempCount++;
        }
    }

    private function prepareCreateSql(array $datas)
    {
        if (empty($datas)) $this->createStatement = '';
        else {
            $tempCount = 0;
            $this->createStatement .= 'set ';
            foreach ($datas as $key => $value) {
                if ($tempCount == count($datas) - 1) {
                    $this->createStatement .= " {$key} = '" . $value . "'";
                } else {
                    $this->createStatement .= " {$key} = '" . $value . "',";
                }
                $tempCount++;
            }
        }
    }

    private function prepareUpdateSql(array $datas)
    {
        if (empty($datas)) $this->updateStatement = '';
        else {
            $tempCount = 0;
            foreach ($datas as $key => $value) {
                if ($tempCount == count($datas) - 1) {
                    $this->updateStatement .= $key . ' = ' . $value;
                } else {
                    $this->updateStatement .= $key . ' = ' . $value . ' , ';
                }
                $tempCount++;
            }
        }
    }

    public function __destruct()
    {
        $this->pdo = null;
    }

}