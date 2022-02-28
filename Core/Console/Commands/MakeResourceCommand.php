<?php

namespace Core\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;

class MakeResourceCommand extends Command
{

    protected $signature = 'make:resource {name}';
    protected $name      = 'make:resource';

    protected $description = "Create a new resource";

    private $datamapper_template = "<?php

namespace App\@@@@@@@@@@@@\DataMappers;
    
use App\@@@@@@@@@@@@\Entities\@@@@@@@@@@@@Entity;
use Core\DataMapper;
use Core\Entity;
    
class @@@@@@@@@@@@DataMapper extends DataMapper
{
    protected \$entity = @@@@@@@@@@@@Entity::class;
    
    protected function fromRepository(array \$data): array
    {
        return [];
    }
    
    protected function toRepository(array \$data): array
    {
        return [];
    }
    
    protected function fromEntity(Entity \$data): array
    {
        return [];
    }
    
}
    
";

    private $controller_template = "<?php

namespace App\@@@@@@@@@@@@\Controllers;
    
use App\@@@@@@@@@@@@\DataMappers\@@@@@@@@@@@@DataMapper;
use App\@@@@@@@@@@@@\Models\@@@@@@@@@@@@;
use App\@@@@@@@@@@@@\Repositories\@@@@@@@@@@@@Repository;
use App\@@@@@@@@@@@@\Resources\@@@@@@@@@@@@Collection;
use App\@@@@@@@@@@@@\Resources\@@@@@@@@@@@@Resource;
use App\@@@@@@@@@@@@\Services\@@@@@@@@@@@@Service;
use Core\Http\Controllers\Controller;
    
class @@@@@@@@@@@@Controller extends Controller
{
    
    protected array \$classes = [
        'datamapper' => @@@@@@@@@@@@DataMapper::class,
        'repository' => @@@@@@@@@@@@Repository::class,
        'resource'   => @@@@@@@@@@@@Resource::class,
        'collection' => @@@@@@@@@@@@Collection::class,
        'service'    => @@@@@@@@@@@@Service::class,
        'model'      => @@@@@@@@@@@@::class,
    ];

    protected int \$paginate = 0;
    
}
";

    private $entities_template = "<?php

namespace App\@@@@@@@@@@@@\Entities;
    
use Core\Entity;
    
class @@@@@@@@@@@@Entity extends Entity
{
        
}
";

    private $model_template = "<?php

namespace App\@@@@@@@@@@@@\Models;
    
use Core\Model;
    
class @@@@@@@@@@@@ extends Model
{
    protected \$table = \"!!!!!!!!!!!!!\";
    
    protected \$appends = [
            
    ];
}
";

    private $repositories_template = "<?php

namespace App\@@@@@@@@@@@@\Repositories;

use App\@@@@@@@@@@@@\DataMappers\@@@@@@@@@@@@DataMapper;
use App\@@@@@@@@@@@@\Models\@@@@@@@@@@@@;
use Core\Repository;
    
class @@@@@@@@@@@@Repository extends Repository
{
    protected \$datamapper   = @@@@@@@@@@@@DataMapper::class;
    protected \$model        = @@@@@@@@@@@@::class;
}";

    private $resource_template = "<?php

namespace App\@@@@@@@@@@@@\Resources;
    
use Illuminate\Http\Resources\Json\JsonResource;
    
class @@@@@@@@@@@@Resource extends JsonResource
{
    
    /**
    * @inheritDoc
    */
    public function toArray(\$request): array
    {
        return [

        ];
    }
}";

    private $collection_template = "<?php

namespace App\@@@@@@@@@@@@\Resources;
    
use Core\ResourceCollection;
    
class @@@@@@@@@@@@Collection extends ResourceCollection
{
    
    public function toArray(\$request)
    {
        return \$this->collection->transform(function(\$client){
            return new @@@@@@@@@@@@Resource(\$client);
        });
    }
    
}";

    private $service_template = "<?php

namespace App\@@@@@@@@@@@@\Services;
    
use Core\Service;
    
class @@@@@@@@@@@@Service extends Service
{
        
}";

    private $factory_template = "<?php

use App\@@@@@@@@@@@@\Models\@@@@@@@@@@@@;
use Faker\Generator as Faker;
    
\$factory->define(@@@@@@@@@@@@::class, function (Faker \$faker) {
    return [
    
    ];
});
";

    private $seeder_template = "<?php

use App\@@@@@@@@@@@@\Models\@@@@@@@@@@@@;
use Illuminate\Database\Seeder;
    
class @@@@@@@@@@@@Seeder extends Seeder
{
    public function run()
    {
        factory(@@@@@@@@@@@@::class, 1)->create();
    }
}
";

    private const REPLACER          = "@@@@@@@@@@@@";
    private const TABLENAMEREPLACER = "!!!!!!!!!!!!!";

    public function handle()
    {
        $_base = base_path();
        $_base .= "/App/";
        
        $_name = $this->argument('name');
        $_name = ucfirst($_name);

        // Set namespaces & class names
        $this->datamapper_template      = str_replace(self::REPLACER, $_name, $this->datamapper_template);
        $this->controller_template      = str_replace(self::REPLACER, $_name, $this->controller_template);
        $this->entities_template        = str_replace(self::REPLACER, $_name, $this->entities_template);
        $this->model_template           = str_replace(self::REPLACER, $_name, $this->model_template);
        $this->repositories_template    = str_replace(self::REPLACER, $_name, $this->repositories_template);
        $this->resource_template        = str_replace(self::REPLACER, $_name, $this->resource_template);
        $this->collection_template      = str_replace(self::REPLACER, $_name, $this->collection_template);
        $this->service_template         = str_replace(self::REPLACER, $_name, $this->service_template);
        $this->factory_template         = str_replace(self::REPLACER, $_name, $this->factory_template);
        $this->seeder_template          = str_replace(self::REPLACER, $_name, $this->seeder_template);
        
        // Set model table name
        $_tableName = $this->ask("Name of table name: ");
        $this->model_template = str_replace(self::TABLENAMEREPLACER, $_tableName, $this->model_template);

        mkdir($_base.$_name);

        $_base = $_base.$_name."/";

        mkdir($_base."DataMappers");
        mkdir($_base."Controllers");
        mkdir($_base."Entities");
        mkdir($_base."Models");
        mkdir($_base."Repositories");
        mkdir($_base."Resources");
        mkdir($_base."Services");

        file_put_contents($_base."DataMappers/{$_name}DataMapper.php"           , $this->datamapper_template);
        file_put_contents($_base."Controllers/{$_name}Controller.php"           , $this->controller_template);
        file_put_contents($_base."Entities/{$_name}Entity.php"                  , $this->entities_template);
        file_put_contents($_base."Models/{$_name}.php"                          , $this->model_template);
        file_put_contents($_base."Repositories/{$_name}Repository.php"          , $this->repositories_template);
        file_put_contents($_base."Resources/{$_name}Resource.php"               , $this->resource_template);
        file_put_contents($_base."Resources/{$_name}Collection.php"             , $this->collection_template);
        file_put_contents($_base."Services/{$_name}Service.php"                 , $this->service_template);
        
        file_put_contents(base_path()."/database/factories/{$_name}Factory.php" , $this->factory_template);
        file_put_contents(base_path()."/database/seeds/{$_name}Seeder.php" , $this->seeder_template);

        // MAke migration
        $this->call("make:migration", ['name' => "create_".$_tableName."_table"]);

        $this->info('Resource Created');

    }

}