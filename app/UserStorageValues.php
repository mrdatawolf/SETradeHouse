<?php namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * UserItems
 *
 * @property int                   $id
 * @property string                $owner
 * @property string                $item
 * @property int                   $amount
 * @property mixed                 $updated_at
 * @property mixed                 $created_at
 */
class UserStorageValues extends Model
{
    protected $table = 'user_storage_values';
    protected $index = 'id';
    protected $fillable = ['owner','item', 'amount','server_id','world_id','updated_at','created_at'];
}
