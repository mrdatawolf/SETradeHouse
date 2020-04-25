<?php namespace Models;

use Illuminate\Database\Eloquent\Model;

/**
 * note: these are numbers that are the same on every server. They are foundational numbers allowing us to build the more complicated values.
 * Class MagicNumbers
 *
 * @property int                   $receipt_base_efficiency
 * @property string                $base_multiplier_for_buy_vs_sell
 * @property                       $base_refinery_kwh
 * @property                       $base_refinery_speed
 * @property                       $keen_crap_fix
 * @property                       $base_labor_per_hour
 * @property                       $cost_kw_hour
 * @property                       $server_id
 * @property                       $distance_weight
 * @property                       $other_server_weight
 * @property                       $base_weight_for_system_stock
 * @property                       $markup_total_change
 * @property                       $markup_for_each_leg
 * @property                       $base_drill_per_kw_hour
 * @package Models
 */
class MagicNumbers extends Model
{
    protected $table = 'magic_numbers';
    protected $fillable = [
        'receipt_base_efficiency',
        'base_multiplier_for_buy_vs_sell',
        'base_refinery_kwh',
        'base_refinery_speed',
        'base_drill_per_kw_hour',
        'markup_for_each_leg',
        'markup_total_change',
        'base_weight_for_system_stock',
        'other_server_weight',
        'distance_weight',
        'server_id',
        'cost_kw_hour',
        'base_labor_per_hour'
    ];
}