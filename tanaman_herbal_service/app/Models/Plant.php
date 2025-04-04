<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plant extends Model
{
    use SoftDeletes;

    public $table = 'plants';

    protected $fillable = [
        'id',
        'name',
        'latin_name',
        'advantage',
        'ecology',
        'endemic_information',
        'qrcode',
        'status',
        'habitus_id',
        'created_by',
        'updated_by',
        'deleted_at',
    ];

    protected $dates = ['deleted_at'];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    public function habituses()
    {
        return $this->belongsTo(Habitus::class, 'habitus_id');
    }

    public function images()
    {
        return $this->belongsToMany(Image::class, 'plant_images');
    }

    public function lands()
    {
        return $this->belongsToMany(Land::class, 'plant_lands');
    }
}
