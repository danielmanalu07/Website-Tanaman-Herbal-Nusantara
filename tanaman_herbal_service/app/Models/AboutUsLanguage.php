<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutUsLanguage extends Model
{
    protected $table = 'contact_us_languages';

    protected $fillable = [
        'id',
        'contact_us_id',
        'language_id',
        'title',
        'text',
        'created_at',
        'updated_at',
    ];
}
