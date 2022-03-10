<?php

namespace Core;

use Carbon\Carbon;
use Core\DataMapper;
use Core\Exceptions\ResourceNotFoundException;
use Core\Model;
use Illuminate\Database\Eloquent\Builder;
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
     * @var Builder
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
     * @var string
     */
    private string $cacheKey;
    
    /**
     * @var string
     */
    private string $cachePrefix;

    public function __construct(int $paginate=0)
    {
        $this->query        = new $this->model();
        $this->model        = new $this->model();
        $this->datamapper   = new $this->datamapper();
        $this->cachePrefix  = (new ReflectionClass($this))->getShortName();
        $this->paginate     = $paginate;
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
        // Set the cache key for this instance
        $this->cacheKey = $this->cachePrefix . ":" . str_replace(
            " ", "", $query->toSql().implode("", $query->getBindings())
        );

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
     * @return Entity|null
     */
    public function entity(): ?Entity
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
     * @return EntityCollection
     */
    public function entityCollection(): EntityCollection
    {
        if($this->paginate > 0){
            if(!env('APP_DEBUG')) // Only use the cache in production
                $data = Cache::remember($this->cacheKey.":".request()->getRequestUri(), Carbon::now()->addHour(), function(){
                    return $this->getQuery()->paginate($this->paginate)->toArray()['data'];
                });
            else
                $data = $this->getQuery()->paginate($this->paginate)->toArray()['data'];
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
            // Let's ignore these values since our database should handle this
            if($key === 'id')         continue;
            if($key === 'created_at') continue;
            if($key === 'updated_at') continue;

            $m->{$key} = $value;
        }
        if(!$m->save()) return false; // Should throw exception

        $this->clearCache(); // Clear the cache so we see our newly created record
        
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
            if($key === 'id')         continue;
            if($key === 'created_at') continue;
            if($key === 'updated_at') continue;
            if($value == '')          continue;

            $m->{$key} = $value;
        }

        if(!$m->save()) return false; // Should throw exception
        $m->touch();

        $this->clearCache(); // Clear the cache so we see our newly updated record
        
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

        $this->clearCache(); // Clear the cache so we no longer see our deleted record

        return $entity; // Return the entity we deleted
    }

}
