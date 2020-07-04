<?php namespace Models;

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
    protected $table = 'stock_levels';
    protected $fillable = ['server_id','user_id', 'amount','good_type','good_id'];

    public function ores() {
        $this->belongsToMany('Models\Ores');
    }

    public function ingots() {
        return $this->belongsToMany('Models\Ingots');
    }

    public function clusters() {
        return $this->belongsTo('Models\Clusters');
    }

    public function tradezones() {
        return $this->hasMany('Models\TradeZones');
    }

    public function components() {
        return $this->hasMany('Models\Components');
    }

    public function types() {
        $this->hasMany('Models\ServerTypes');
    }

    public function activeTransactions() {
        return $this->hasMany('Models\ActiveTransactions');
    }
}