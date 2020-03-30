<?php namespace Controllers;

use Interfaces\Crud;
use Models\Components as DataSource;

/**
 * Class Ingots
 *
 * @package Controllers
 */
class Components extends BaseController implements Crud
{
    public $dataSource;

    public function __construct($clusterId)
    {
        $this->clusterId    = $clusterId;
        $this->dataSource   = new DataSource();
    }

    public function create($data) {
        $component = $this->dataSource;
        $component->title       = $data->title;
        $component->cobalt      = $data->cobalt;
        $component->gold        = $data->gold;
        $component->iron        = $data->iron;
        $component->magnesium   = $data->magnesium;
        $component->nickel      = $data->nickel;
        $component->platinum    = $data->platinum;
        $component->silicon     = $data->silicon;
        $component->silver      = $data->silver;
        $component->uranium     = $data->uranium;
        $component->gravel      = $data->gravel;
        $component->mass        = $data->mass;
        $component->volume      = $data->volume;
        $component->save();

        return $component->id;
    }
}