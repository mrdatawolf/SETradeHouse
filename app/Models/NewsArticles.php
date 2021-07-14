<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsArticles extends Model
{
    use HasFactory, HasTimestamps;

    protected $connection = 'main';
    protected $table      = 'news_articles';
    protected $fillable   = ['user_id','region','title','body'];
}
