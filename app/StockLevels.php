<?php namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Ores
 *
 * @property int                   $id
 * @property string                $server_id
 * @property                       $user_id
 * @property int                   $amount
 * @property                       $good_type
 * @property                       $good_id
 * @property                       $created_at
 * @property                       $updated_at
 * @package Models
 */
class StockLevels extends Model
{
    protected $connection='mysql';
    protected $table = 'everyonesitems';
    protected $fillable = ['Owner','Item', 'Qty','Timestamp'];

    public function getCurrentStockLevels() {
        $currencies  = \DB::select('SELECT *
                             FROM (
                                    SELECT DISTINCT exchange, base, quote
                                      FROM tickers
                                  ) AS t1
                             JOIN tickers
                               ON tickers.id =
                                 (
                                    SELECT id
                                      FROM tickers AS t2
                                     WHERE t2.exchange  = t1.exchange
                                       AND t2.base      = t1.base
                                       AND t2.quote     = t1.quote
                                     ORDER BY created_at DESC
                                     LIMIT 1
                                 )
                         ');
    }

}
