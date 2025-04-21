<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlantValidation extends Model
{
    protected $table = 'plant_validations';

    protected $fillable = [
        'plant_id',
        'validator_id',
        'date_validation',
        'condition',
        'description',
    ];

    public function plants()
    {
        return $this->belongsTo(Plant::class, 'plant_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'validator_id');
    }

    public function images()
    {
        return $this->belongsToMany(Image::class, 'validation_images', 'validation_id', 'image_id');
    }

}
