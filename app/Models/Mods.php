<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mods extends Model
{
    use HasFactory, HasTimestamps;
    protected $connection = 'server_info';
    protected $table      = 'mods';
    protected $fillable   = ['server_id','message', 'mod_type', 'mod_number', 'description'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function servers(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\Servers', 'server_id');
    }
}
