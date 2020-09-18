<?php namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Roles
 *
 * @property int    id
 * @property string title
 * @package Models
 */
class Roles extends Model
{
    public    $timestamps   = false;
    protected $table        = 'roles';
    protected $fillable     = ['title'];
    protected $primaryKey   = 'id';
    protected $connection   = 'sqlite';


    public function users() {
        return $this->belongsToMany('App\User');
    }
}
