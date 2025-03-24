<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Habitus extends Model
{
    use SoftDeletes;
    public $table = 'habituses';

    protected $fillable = [
        'id',
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

}
