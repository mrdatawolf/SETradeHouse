<?php namespace App\Models;

use App\Http\Traits\ScarcityAdjustment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Trends
 *
 * @property int transaction_type_id
 * @property int good_type_id
 * @property int good_id
 * @property string dated_at
 * @property double sum
 * @property double amount
 * @property double average
 * @property int count
 * @package Models
 * @mixin Builder
 */
class Trends extends Model
{
    use ScarcityAdjustment;

    protected $connection   ='trends';
    protected $table = 'trends';
    protected $fillable = ['transaction_type_id', 'good_type_id', 'good_id', 'dated_at', 'sum', 'amount', 'average', 'count'];
    protected $dates = ['dated_at'];
    public $timestamps = false;
}
