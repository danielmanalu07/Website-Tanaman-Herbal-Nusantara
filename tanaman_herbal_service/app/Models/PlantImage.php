<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlantImage extends Model
{
    public $table = 'plant_images';

    protected $fillable = [
        'plant_id',
        'image_id',
    ];
}
