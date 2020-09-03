<?php namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * NpcStorageValues
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
class NpcStorageValues extends Model
{
    public $table = 'npc_storage_values';
    public $index = 'id';
    public $timestamps = true;
    public $fillable = ['owner', 'server_id', 'world_id', 'group_id', 'item_id', 'amount'];
}
