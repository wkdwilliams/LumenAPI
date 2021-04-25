<?php

namespace Core;

use Core\DataMapper\DataMapper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

abstract class Repository
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * @var DataMapper
     */
    protected $datamapper;

    /**
     * @var Builder
     */
    protected $query;

    public function __construct(DataMapper $dataMapper, Model $model)
    {
        $this->model        = $model;
        $this->query        = $model;
        $this->datamapper   = $dataMapper;
    }

    /**
     * @return mixed
     */
    protected function getQuery()
    {
        return $this->query;
    }

    /**
     * @param $query
     * @return Repository
     */
    protected function setQuery($query): Repository
    {
        $this->query = $query;

        return $this;
    }

    /**
     * @param $column
     * @param string $direction
     * @return Repository
     */
    public function orderBy($column, $direction = 'asc'): Repository
    {
        return $this->setQuery($this->getQuery()->orderBy($column, $direction));
    }

    /**
     * @param array $query
     * @return Repository
     */
    public function where(array $query): Repository
    {
        return $this->setQuery($this->getQuery()->where($query));
    }

    /**
     * @param $column
     * @return Repository
     */
    public function whereNotNull($column): Repository
    {
        return $this->setQuery($this->getQuery()->whereNotNull($column));
    }

    public function count(string $column, $value)
    {
        return $this->model->where($column, $value)->count();
    }

    public function truncate()
    {
        return $this->whereNotNull('id')->delete();
    }

    public function limit($value)
    {
        $query = $this->getQuery()->limit($value);

        return $this->setQuery($query);
    }

    /**
     * @param string $id
     * @return Entity
     */
    public function findById(string $id): Entity
    {
        return $this->where(['id' => $id])->entity();
    }

    /**
     * @return Repository
     */
    public function findAll(): Repository
    {
        $query = $this->getQuery()->whereNotNull('id');

        return $this->setQuery($query);
    }

    public function entity(): Entity
    {
        $data = $this->getQuery()->get()->toArray()[0];

        return $this->datamapper->getEntity($data);
    }

    /**
     * @return EntityCollection
     */
    public function entityCollection(): EntityCollection
    {
        $data = $this->getQuery()->get()->toArray();

        $collection = new EntityCollection();

        foreach ($data as $d)
        {
            $collection->push($this->datamapper->getEntity($d));
        }

        return $collection;
    }

}
