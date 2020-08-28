<?php

namespace App;

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
    protected $connection='mysql';
    protected $table = 'everyonesitems';
    protected $index = 'ID';
    protected $fillable = ['Owner','Item', 'Qty','Timestamp'];
}
