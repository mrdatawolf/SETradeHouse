<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * UserStorageValues
 *
 * @property int                   $id
 * @property string                $owner
 * @property string                $server_id
 * @property string                $world_id
 * @property string                $group_id
 * @property string                $item_id
 * @property int                   $amount
 * @property mixed                 $updated_at
 * @property mixed                 $created_at
 */
class UserStorageValues extends Model
{
    public $table = 'user_storage_values';
    public $index = 'id';
    public $timestamps = true;
    public $fillable = ['owner', 'server_id', 'world_id', 'group_id', 'item_id', 'amount'];
}
