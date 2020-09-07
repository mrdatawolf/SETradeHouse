<?php namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * UserItems
 *
 * @property int                   $id
 * @property string                $title
 */
class GoodTypes extends Model
{
    protected $table = 'good_types';
    protected $index = 'id';
    protected $fillable = ['title'];
}
