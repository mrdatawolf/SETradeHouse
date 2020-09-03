<?php namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * UserItems
 *
 * @property int                   $id
 * @property string                $title
 */
class Groups extends Model
{
    protected $table = 'groups';
    protected $index = 'id';
    protected $fillable = ['title'];
}
