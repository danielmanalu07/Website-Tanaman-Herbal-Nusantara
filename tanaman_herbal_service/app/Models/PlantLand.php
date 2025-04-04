<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlantLand extends Model
{
    use SoftDeletes;

    public $table = 'plant_lands';

    protected $fillable = [
        'id',
        'plant_id',
        'land_id',
        'status',
    ];
}
