<?php
/**
 * Created by PhpStorm.
 * User: jefftan
 * Date: 17-8-25
 * Time: 上午10:14
 */

namespace Core;

use Core\Database\QueryBuilder;

class Model
{
    protected $model;

    public function __construct(QueryBuilder $queryBuilder)
    {
        $this->model = $queryBuilder;
    }

    public function load($modelName)
    {
        $className = 'App\\Models\\' . $modelName;
        $vars = get_class_vars($className);
        $this->model->table($vars['table']);
        return $this->model;
    }

    public function whereAnd(array $datas)
    {
        $this->model->whereAnd($datas);
        return $this->model;
    }

    public function whereOr(array $datas)
    {
        $this->model->whereOr($datas);
        return $this->model;
    }

    public function all()
    {
        $this->model->all();
    }

    public function get($columns = "*")
    {
        $this->model->get($columns);
    }

    public function first($columns = "*")
    {
        $this->model->first($columns);
    }

    public function create(array $datas)
    {
        $this->model->create($datas);
    }

    public function update(array $datas)
    {
        $this->model->update($datas);
    }

    public function delete()
    {
        $this->model->delete();
    }

    public function deleteAll()
    {
        $this->model->deleteAll();
    }
}