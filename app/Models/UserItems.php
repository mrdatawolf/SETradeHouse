<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * UserItems
 *
 * @property string                $Owner
 * @property string                $Item
 * @property int                   $Qty
 * @property mixed                 $Timestamp
 */
class UserItems extends Model
{
    const CREATED_AT = 'Timestamp';
    public $connection='mysql';
    public $table = 'everyonesitems';
    public $fillable = ['Owner','Item', 'Qty','Timestamp'];
    public $incrementing = false;
}
