<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Language extends Model
{
    use SoftDeletes;
    public $table = 'languages';

    protected $fillable = [
        'id',
        'code',
        'name',
        'created_at',
        'updated_at',
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

    public function news()
    {
        return $this->belongsToMany(News::class, 'news_languages')
            ->withPivot('title', 'content')
            ->withTimestamps();
    }

    public function habitus()
    {
        return $this->belongsToMany(News::class, 'habitus_languages')
            ->withPivot('name')
            ->withTimestamps();
    }
}
