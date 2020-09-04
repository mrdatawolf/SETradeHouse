<?php namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TransactionTypes
 *
 *
 * @property int                   $id
 * @property string                $title
 * @package Models
 */
class TransactionTypes extends Model
{
    protected $table = 'transaction_types';
    protected $fillable = ['title'];
}
