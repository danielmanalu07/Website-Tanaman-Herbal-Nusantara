<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsLanguage extends Model
{
    protected $table = 'news_languages';

    protected $fillable = [
        'id',
        'news_id',
        'language_id',
        'title',
        'content',
        'created_at',
        'updated_at',
    ];
}
