<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Scarcity
 *
 * @property int                   $id
 * @property string                $title
 *
 * @package App
 */
class Scarcity extends Model
{
    protected $table = 'scarcity_types';
    protected $fillable = ['title'];
}
