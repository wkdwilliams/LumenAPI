<?php

namespace Core;

use Core\DataMapper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

abstract class Repository
{

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

    public function findByForeignId(string $foreignIdField, string $id): EntityCollection
    {
        return $this->where([$foreignIdField => $id])->entityCollection();
    }

    /**
     * @return Repository
     */
    public function findAll(): EntityCollection
    {
        $query = $this->getQuery()->whereNotNull('id');

        return $this->setQuery($query)->entityCollection();
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

    /**
     * @param array $data
     * 
     * @return mixed
     */
    public function create(array $data): mixed
    {
        $entity = $this->datamapper->toEntity($data);           // Convert our data into an entity for filtering & data manipulation
        $entity = $this->datamapper->fromApplication($entity);  // Convert our entity back into an array

        $m = new $this->query();
        foreach ($entity as $key => $value) {
            $m->{$key} = $value;
        }
        if(!$m->save()) return false;
        
        return $this->datamapper->getEntity($m->toArray());
    }

}
