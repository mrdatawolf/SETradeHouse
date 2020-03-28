<?php namespace Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SystemTypes
 *
 * @property int                   $id
 * @property string                $title
 * @package Models
 */
class SystemTypes extends Model
{
    protected $table = 'system_types';
    protected $fillable = ['title'];
}