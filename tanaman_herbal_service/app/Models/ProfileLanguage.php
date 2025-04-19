<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfileLanguage extends Model
{
    protected $table = 'profile_languages';

    protected $fillable = [
        'id',
        'profile_id',
        'language_id',
        'title',
        'content',
        'created_at',
        'updated_at',
    ];
}
