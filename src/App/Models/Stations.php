<?php namespace Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Stations
 *
 * @property int                   $id
 * @property string                $title
 * @property                       $server_id
 * @package Models
 */
class Stations extends Model
{
    protected $table = 'stations';
    protected $fillable = ['title','server_id'];
}