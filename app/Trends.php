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
 * @property double sum
 * @property double amount
 * @property double orderAmount
 * @property double offerAmount
 * @property double orderSum
 * @property double offerSum
 * @property double average
 * @property int count
 * @property int orderLatestMinute
 * @property int offerLatestMinute
 * @package Models
 */
class Trends extends Model
{
    use ScarcityAdjustment;
    protected $table = 'trends';
    protected $fillable = ['goodTypeId', 'goodId', 'month', 'day', 'hour', 'sum', 'amount', 'orderAmount', 'orderSum', 'orderCount', 'orderAverage', 'offerAmount', 'offerSum', 'offerCount', 'offerAverage', 'average', 'count', 'orderLatestMinute', 'offerLatestMinute'];
    public $timestamps = true;
}
