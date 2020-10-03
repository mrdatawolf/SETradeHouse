<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class WorldTypes
 *
 * @property int    $id
 * @property int    $server_id
 * @property int    $user_id
 * @property string $owner_title
 * @package Models
 */
class OwnerServer extends Model
{
    protected $primaryKey = 'id';
    protected $connection = 'sqlite';
    public    $timestamps = true;
    protected $table      = 'owner_server';
    protected $fillable   = ['server_id', 'user_id', 'owner_title'];
}
