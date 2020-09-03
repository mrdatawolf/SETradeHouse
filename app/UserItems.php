<?php namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * UserItems
 *
 * @property int                   $ID
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
    public $index = 'ID';
    public $fillable = ['Owner','Item', 'Qty','Timestamp'];
}
