<?php namespace Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ServerTypes
 *
 * @property int                   $id
 * @property string                $title
 * @package Models
 */
class ServerTypes extends Model
{
    protected $table = 'server_types';
    protected $fillable = ['title'];
}