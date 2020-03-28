<?php namespace Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Ingots
 *
 * @property int                   $id
 * @property string                $title
 * @property                       $ore_required
 * @property                       $base_ore
 * @property                       $keen_crap_fix
 * @package Models
 */
class Ingots extends Model
{
    protected $table = 'ingots';
    protected $fillable = ['title','ore_required','base_ore','keen_crap_fix'];
}