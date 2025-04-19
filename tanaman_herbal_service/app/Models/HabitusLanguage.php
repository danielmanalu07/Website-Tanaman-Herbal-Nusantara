<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HabitusLanguage extends Model
{
    protected $table = 'habitus_languages';

    protected $fillable = [
        'id',
        'habitus_id',
        'language_id',
        'name',
        'created_at',
        'updated_at',
    ];

}
