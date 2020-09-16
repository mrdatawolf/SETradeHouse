<?php namespace App;

use App\Http\Traits\ScarcityAdjustment;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Tools
 *
 * @property int id
 * @property int type_id
 * @property int transaction_type_id
 * @property int good_id
 * @property int month
 * @property int day
 * @property int hour
 * @property double sum
 * @property double amount
 * @property double average
 * @property int count
 * @property int latestMinute
 * @package Models
 */
class Trends extends Model
{
    use ScarcityAdjustment;
    protected $table = 'trends';
    protected $fillable = ['transaction_type_id', 'type_id', 'good_id', 'month', 'day', 'hour', 'sum', 'amount', 'average', 'count', 'latest_minute'];
    public $timestamps = true;
}
