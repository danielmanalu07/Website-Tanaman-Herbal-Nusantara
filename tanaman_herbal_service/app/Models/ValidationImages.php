<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ValidationImages extends Model
{
    public $table = 'validation_images';

    protected $fillable = [
        'validation_id',
        'image_id',
    ];
}
