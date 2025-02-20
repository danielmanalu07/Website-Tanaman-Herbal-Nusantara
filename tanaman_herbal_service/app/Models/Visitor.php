<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Visitor extends Model
{
    use SoftDeletes;
    public $table = 'visitors';

    protected $fillable = [
        'id',
        'visitor_total',
        'visitor_category_id',
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

    public function visitor_category()
    {
        return $this->belongsTo(VisitorCategory::class, 'visitor_category_id');
    }

}
