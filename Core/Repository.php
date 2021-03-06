<?php

namespace Core;

use Carbon\Carbon;
use Core\DataMapper;
use Core\Exceptions\ResourceNotFoundException;
use Core\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use ReflectionClass;

abstract class Repository
{

    /**
     * @var DataMapper
     */
    protected $datamapper;

    /**
     * @var Model
     */
    protected $query;

    /**
     * @var Model
     */
    protected $model;

    /**
     * @var int
     */
    private int $paginate;

    /**
     * @var int
     */
    private int $page;

    /**
     * @var string
     */
    private string $cacheKey;
    
    /**
     * @var string
     */
    private string $cachePrefix;

    public function __construct(int $paginate=0, int $page = 1)
    {
        $this->query        = new $this->model();
        $this->model        = new $this->model();
        $this->datamapper   = new $this->datamapper();
        $this->cachePrefix  = (new ReflectionClass($this))->getShortName();
        $this->paginate     = $paginate;
        $this->page         = $page;
    }

    /**
     * @return void
     */
    public function clearCache(): void
    {
        collect(Redis::command("KEYS", ['*'.$this->cachePrefix.':*']))->map(function($value){
            Redis::command("DEL", [$value]);
        });
    }

    /**
     * Change the page of our pagination
     * 
     * @param int $page
     * 
     * @return Repository
     */
    public function setPage(int $page): Repository
    {
        $this->page = $page;

        return $this;
    }

    /**
     * @return mixed
     */
    protected function getQuery()
    {
        return $this->query;
    }

    /**
     * Update the query builder with our new query
     * 
     * @param $query
     * @return Repository
     */
    protected function setQuery($query): Repository
    {
        // Set the cache key for this instance
        $this->cacheKey = $this->cachePrefix . ":" . str_replace(
            " ", "", $query->toSql().implode("", $query->getBindings())
        );

        $this->query = $query;

        return $this;
    }

    /**
     * Order the results by specific column, ascending or descending
     * 
     * @param $column
     * @param string $direction
     * @return Repository
     */
    public function orderBy($column, $direction = 'asc'): Repository
    {
        return $this->setQuery($this->getQuery()->orderBy($column, $direction));
    }

    /**
     * Get count of the results
     * 
     * @return int
     */
    public function count(): int
    {
        return $this->getQuery()->count();
    }

    public function limit(int $amount): Repository
    {
        return $this->setQuery($this->getQuery()->limit($amount));
    }

    /**
     * Get results using the WHERE clause
     * 
     * @param array $query
     * @return Repository
     */
    public function where(array $query): Repository
    {
        return $this->setQuery($this->getQuery()->where($query));
    }

    /**
     * Get results where column is not null
     * 
     * @param $column
     * @return Repository
     */
    public function whereNotNull($column): Repository
    {
        return $this->setQuery(
            $this->getQuery()->whereNotNull($column)
        );
    }

    /**
     * Get results using the where clause, with an operator
     * 
     * @param mixed $column
     * @param mixed $operator
     * @param mixed $value
     * 
     * @return Repository
     */
    public function whereOperator($column, $operator, $value): Repository
    {
        return $this->setQuery(
            $this->getQuery()->where($column, $operator, $value)
        );
    }

    /**
     * Find record by id
     * 
     * @param string $id
     * @return Repository
     */
    public function findById(string $id): Repository
    {
        return $this->where(['id' => $id]);
    }

    /**
     * Find record by foreign id field
     * 
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
     * Find record by certain column
     * 
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
     * Find all records
     * 
     * @return EntityCollection
     */
    public function findAll(): Repository
    {
        return $this->setQuery(
            $this->getQuery()->whereNotNull('id')
        );
    }

    /**
     * Access the query builder directly within a callback for custom query building
     * 
     * @param callable $callback
     * 
     * @return Repository
     */
    public function queryBuilder(callable $callback): Repository
    {
        return $this->setQuery(
            $callback($this->getQuery())
        );
    }

    /**
     * Get entity of our obtained results
     * 
     * @return Entity
     */
    public function entity(): Entity
    {
        if(!env('APP_DEBUG')) // Only use the cache in production
            $data = Cache::remember($this->cacheKey, Carbon::now()->addHour(), function(){
                $_data = $this->getQuery()->first();
                if($_data === null) throw new ResourceNotFoundException();

                return $_data->toArray();
            });
        else{
            $data = $this->getQuery()->first();
            if($data === null) throw new ResourceNotFoundException();

            $data = $data->toArray();
        }

        return $this->datamapper->repoToEntity($data);
    }

    /**
     * Get entity collection of our obtained results
     * 
     * @return EntityCollection
     */
    public function entityCollection(): EntityCollection
    {
        if($this->paginate > 0){
            if(!env('APP_DEBUG')) // Only use the cache in production
                $data = Cache::remember($this->cacheKey.":page:".$this->page, Carbon::now()->addHour(), function(){
                    return $this->getQuery()->paginate($this->paginate)->toArray()['data'];
                });
            else
                $data = $this->getQuery()->paginate($this->paginate, ['*'], 'page', $this->page)->toArray()['data'];
        }
        else{
            if(!env('APP_DEBUG')) // Only use the cache in production
                $data = Cache::remember($this->cacheKey.":all", Carbon::now()->addHour(), function(){
                    return $this->getQuery()->get()->toArray();
                });
            else{
                $data = $this->getQuery()->get()->toArray();
            }
        }

        return $this->datamapper->repoToEntityCollection($data);
    }

    /**
     * Create a record
     * 
     * @param array|Entity $data
     * 
     * @return Entity
     */
    public function create($data): Entity
    {
        if ($data instanceof Entity) {
            $data = $this->datamapper->entityToArray($data);    // Convert entity to array to prepare for the model
        } else{
            $data = $this->datamapper->arrayToEntity($data);    // We must convert array to entity for mapping purposes.
            $data = $this->datamapper->entityToArray($data);    // Then we convert the entity back to array for model.
        }

        $m = new $this->model();

        foreach ($data as $key => $value) {
            // Let's ignore these values since our database should handle this
            if($key === 'id')         continue;
            if($key === 'created_at') continue;
            if($key === 'updated_at') continue;

            $m->{$key} = $value;
        }

        $m->save();

        $this->clearCache(); // Clear the cache so we see our newly created record
        
        return $this->datamapper->repoToEntity($m->toArray()); //Return the created entity
    }

    /**
     * Update a record
     * 
     * @param array|Entity $data
     * 
     * @return Entity
     */
    public function update($data): Entity
    {
        if($data instanceof Entity)
            $data = $this->datamapper->entityToArray($data);    // Convert our Entity to array ready for the model

        $m = $this->model::find($data['id']);
        if($m === null)
            throw new ResourceNotFoundException();
        
        foreach ($data as $key => $value) {
            // Make sure we're not updating things
            // The user shouldn't be allowed to update.
            if($key   === 'id')         continue;
            if($key   === 'created_at') continue;
            if($key   === 'updated_at') continue;

            $m->{$key} = $value;
        }

        $m->save();
        $m->touch();

        $this->clearCache(); // Clear the cache so we see our newly updated record
        
        return $this->datamapper->repoToEntity($m->toArray()); // Return the updated entity
    }

    /**
     * Delete a record
     * 
     * @param array $data
     * 
     * @return Entity
     */
    public function delete(array $data): Entity
    {
        $entity = $this->findById($data['id'])->entity();
        
        $this->model->where(['id' => $data['id']])->delete();

        $this->clearCache(); // Clear the cache so we no longer see our deleted record

        return $entity; // Return the entity we deleted
    }

}
