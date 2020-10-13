<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Ratios
 *
 * @property int    id
 * @property string title
 * @package Models
 */
class Rarity extends Model
{
    public    $timestamps   = true;
    protected $table        = 'rarity';
    protected $fillable     = ['title', 'minimum_for_first', 'type'];
    protected $primaryKey   = 'id';
    protected $connection   = 'sqlite';
}
