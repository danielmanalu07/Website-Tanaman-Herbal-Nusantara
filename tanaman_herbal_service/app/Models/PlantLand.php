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
        'created_by',
        'updated_by',
        'deleted_at',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function plant()
    {
        return $this->belongsTo(Plants::class, 'plant_id');
    }

    public function land()
    {
        return $this->belongsTo(Lands::class, 'land_id');
    }
}
