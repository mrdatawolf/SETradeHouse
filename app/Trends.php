<?php namespace App;

use App\Http\Traits\ScarcityAdjustment;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Tools
 *
 * @property int id
 * @property int goodTypeId
 * @property int goodId
 * @property int month
 * @property int day
 * @property int hour
 * @property double value
 * @property double amount
 * @property double orderAmount
 * @property double offerAmount
 * @property double average
 * @property int count
 * @property int orderAmountLatestMinute
 * @property int offerAmountLatestMinute
 * @package Models
 */
class Trends extends Model
{
    use ScarcityAdjustment;
    protected $table = 'trends';
    protected $fillable = ['goodTypeId', 'goodId', 'month', 'day', 'hour', 'value', 'amount', 'orderAmount', 'offerAmount', 'average', 'count', 'orderAmountLatestMinute', 'offerAmountLatestMinute'];
    public $timestamps = true;
}
