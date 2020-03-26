<?php namespace Old;

use Illuminate\Database\Eloquent\Model;

class Stations extends Model
{
    public $id;

    protected $title;
    protected $data;
    protected $cluster;

    private $table = 'stations';

    public function __construct($id)
    {
        parent::__construct();
        $this->id = $id;
        $this->data = $this->gatherData();
    }


    private function gatherData() {
        $this->data              = $this->find($this->table, $this->id);
        $this->title                = $this->data->title;
    }
}