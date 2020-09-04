<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Stores
 * @property int        $index
 * @property string     $gridname
 * @property int        $X
 * @property int        $Y
 * @property int        $Z
 * @property string     $Owner
 * @property string     $Item
 * @property string     $offerOrOrder
 * @property string     $Qty
 * @property string     $pricePerUnit
 * @property string     $GPSString
 *
 * @package App
 */
class Stores extends Model
{
    public $timestamps      = false;
    protected $connection   ='mysql';
    protected $table        = 'stores';
    protected $primaryKey   = 'index';
    protected $fillable     = ['gridName', 'X','Y', 'Z', 'Owner', 'Item', 'offerOrOrder', 'Qty', 'pricePerUnit', 'GPSString'];
}
