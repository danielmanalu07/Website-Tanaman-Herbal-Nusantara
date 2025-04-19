<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlantLanguage extends Model
{
    protected $table = 'plant_languages';

    protected $fillable = [
        'id',
        'plant_id',
        'language_id',
        'name',
        'advantage',
        'ecology',
        'endemic_information',
        'created_at',
        'updated_at',
    ];
}
