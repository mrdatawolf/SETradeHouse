<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Ratios
 *
 * @property int    id
 * @property string title
 * @package Models
 */
class Ratios extends Model
{
    public    $timestamps   = true;
    protected $table        = 'ratios';
    protected $fillable     = ['server_id', 'common', 'uncommon', 'rare', 'ultra_rare'];
    protected $primaryKey   = 'id';
    protected $connection   = 'sqlite';


    public function servers() {
        return $this->belongsTo('App\Models\Servers');
    }
}
