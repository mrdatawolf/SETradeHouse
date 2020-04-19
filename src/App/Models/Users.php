<?php namespace Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Clusters
 *
 * @property int                   $id
 * @property string                $username
 * @property                       $password
 * @property                       $created_at
 * @package Models
 */
class Users extends Model
{
    protected $table = 'users';
    protected $fillable = ['username','password', 'created_at'];
}