<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public $table = 'images';

    protected $fillable = [
        'image_path',
    ];

    public function plant()
    {
        return $this->belongsToMany(Plant::class, 'plant_images');
    }

    public function news()
    {
        return $this->belongsToMany(News::class, 'news_images');
    }
}
