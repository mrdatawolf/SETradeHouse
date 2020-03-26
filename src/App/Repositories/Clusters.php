<?php namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class Clusters implements ResourceInterface
{
    // model property on class instances
    protected $model;
    // Constructor to bind model to repo
    public function __construct(Model $model) {
        $this->model = $model;
    }
    // Get all instances of model
    public function all() {
        return $this->model->all();
    }

    public function create(array $data) {

    }

    public function update(array $data, $id) {

    }

    public function delete($id) {

    }

    public function read($id) {

    }

}