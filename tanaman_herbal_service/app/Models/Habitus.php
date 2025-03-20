<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Habitus extends Model
{
    use SoftDeletes;
    public $table = 'habituses';

    protected $fillable = [
        'name',
        'created_by',
        'updated_by',
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

    // public function getQRCodeUrlAttribute()
    // {
    //     $url = route('habitus.detail', $this->id);
    //     return QrCode::format('png')->size(200)->generate($url);
    // }

    public function plants()
    {
        return $this->hasMany(Plants::class);
    }

}
