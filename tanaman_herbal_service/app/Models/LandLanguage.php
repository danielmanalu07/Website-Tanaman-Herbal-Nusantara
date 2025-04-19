<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandLanguage extends Model
{
    protected $table = 'land_languages';

    protected $fillable = [
        'id',
        'land_id',
        'language_id',
        'name',
        'created_at',
        'updated_at',
    ];
}
