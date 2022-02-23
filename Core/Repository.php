<?php

namespace Core;

use Core\DataMapper;
use Core\Model;
use Illuminate\Database\Eloquent\Builder;

abstract class Repository
{

    /**
     * @var DataMapper
     */
    protected DataMapper $datamapper;

    /**
     * @var Builder
     */
    protected $query;

    /**
     * @var Model
     */
    protected Model $model;

    /**
     * @var int
     */
    protected int $paginate;

    public function __construct(DataMapper $dataMapper, Model $model, int $paginate=0)
    {
        $this->query        = $model;
        $this->model        = $model;
        $this->datamapper   = $dataMapper;
        $this->paginate     = $paginate;
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

    public function count(): int
    {
        return $this->getQuery()->count();
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
     * @return Repository
     */
    public function findById(string $id): Repository
    {
        return $this->where(['id' => $id]);
    }

    /**
     * @param string $foreignIdField
     * @param string $id
     * 
     * @return Repository
     */
    public function findByForeignId(string $foreignIdField, string $id): Repository
    {
        return $this->where([$foreignIdField => $id]);
    }

    /**
     * @param string $columnName
     * @param string $value
     * 
     * @return Repository
     */
    public function findByColumn(string $columnName, string $value): Repository
    {
        return $this->where([$columnName => $value]);
    }

    /**
     * @return EntityCollection
     */
    public function findAll(): Repository
    {
        $query = $this->getQuery()->whereNotNull('id');

        return $this->setQuery($query);
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
        if($this->paginate > 0) $data = $this->getQuery()->paginate()->toArray()['data'];
        else $data = $this->getQuery()->get()->toArray();

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
        $entity = $this->datamapper->fromEntity($entity);       // Convert our entity back into an array

        $m = new $this->model();
        foreach ($entity as $key => $value) {
            $m->{$key} = $value;
        }
        if(!$m->save()) return false; // Should throw exception
        
        return $this->datamapper->getEntity($m->toArray()); //Return the created entity
    }

    /**
     * @param array|Entity $data
     * 
     * @return mixed
     */
    public function update($data): mixed
    {
        if($data instanceof Entity)
        {
            $data = $this->datamapper->fromEntity($data);
        }

        $m = $this->model::find($data['id']);

        foreach ($data as $key => $value) {
            // Make sure we're not updating things
            // The user shouldn't be allowed to do.
            if($key == 'id')         continue;
            if($key == 'created_at') continue;
            if($key == 'updated_at') continue;
            if($value == '')         continue;
            $m->{$key} = $value;
        }

        if(!$m->save()) return false; // Should throw exception
        $m->touch();
        
        return $this->datamapper->getEntity($m->toArray()); // Return the updated entity
    }

    /**
     * @param array $data
     * 
     * @return mixed
     */
    public function delete(array $data): mixed
    {
        $entity = $this->findById($data['id'])->entity();
        
        if(!$this->model->where(['id' => $data['id']])->delete())
            return false; // Should throw exception

        return $entity; // Return the entity we deleted
    }

}
