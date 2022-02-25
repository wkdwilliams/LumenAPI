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
    private int $paginate;

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

 
    public function entity(): ?Entity
    {
        $data = $this->getQuery()->first()->toArray();

        return $this->datamapper->repoToEntity($data);
    }

    /**
     * @return EntityCollection
     */
    public function entityCollection(): EntityCollection
    {
        if($this->paginate > 0) $data = $this->getQuery()->paginate($this->paginate)->toArray()['data'];
        else $data = $this->getQuery()->get()->toArray();

        return $this->datamapper->repoToEntityCollection($data);
    }

    /**
     * @param array|Entity $data
     * 
     * @return mixed
     */
    public function create($data): mixed
    {
        if ($data instanceof Entity) {
            $data = $this->datamapper->entityToArray($data);    // Convert entity to array to prepare for the model
        } else{
            $data = $this->datamapper->arrayToEntity($data);    // We must convert array to entity for mapping purposes.
            $data = $this->datamapper->entityToArray($data);    // Then we convert the entity back to array for model.
        }

        $m = new $this->model();

        foreach ($data as $key => $value) {
            $m->{$key} = $value;
        }
        if(!$m->save()) return false; // Should throw exception
        
        return $this->datamapper->repoToEntity($m->toArray()); //Return the created entity
    }

    /**
     * @param array|Entity $data
     * 
     * @return mixed
     */
    public function update($data): mixed
    {
        if($data instanceof Entity)
            $data = $this->datamapper->entityToArray($data);    // Convert our Entity to array ready for the model

        $m = $this->model::find($data['id']);
        if($m === null)
        {
            // Throw resource not found error here!
        }

        foreach ($data as $key => $value) {
            // Make sure we're not updating things
            // The user shouldn't be allowed to update.
            if($key == 'id')         continue;
            if($value == '')         continue;
            $m->{$key} = $value;
        }

        if(!$m->save()) return false; // Should throw exception
        $m->touch();
        
        return $this->datamapper->repoToEntity($m->toArray()); // Return the updated entity
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
