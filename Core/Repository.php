<?php

namespace Core;

use Core\DataMapper;
use Core\Exceptions\RecordNotFoundException;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\RecordsNotFoundException;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

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

    /**
     * @var Model
     */
    protected $model;

    public function __construct(DataMapper $dataMapper, Model $model)
    {
        $this->query        = $model;
        $this->model        = $model;
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

    /**
     * @return Entity
     */
    public function entity(): Entity
    {
        $data = $this->getQuery()->first()->toArray();

        return $this->datamapper->getEntity($data);
    }

    /**
     * @return EntityCollection
     */
    public function entityCollection(): EntityCollection
    {
        $data = $this->getQuery()->get()->toArray();

        return $this->datamapper->getEntityCollection($data);
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
        
        return $this->datamapper->getEntity($m->toArray()); //Return the created entity
    }

    /**
     * @param array $data
     * 
     * @return mixed
     */
    public function update(array $data): mixed
    {
        $newEntity  = $this->datamapper->toEntity($data);
        $newEntity  = $this->datamapper->fromApplication($newEntity);

        $m = $this->model::find($data['id']);
        foreach ($newEntity as $key => $value) {
            if($value == '') continue;
            $m->{$key} = $value;
        }
        if(!$m->save()) return false;
        
        return $this->datamapper->getEntity($m->toArray()); // Return the updated entity
    }

    /**
     * @param array $data
     * 
     * @return mixed
     */
    public function delete(array $data): mixed
    {
        $entity = $this->findById($data['id']);
        
        if(!$this->model->where(['id' => $data['id']])->delete())
            return false;

        return $entity; // Return the entity we deleted
    }

}
