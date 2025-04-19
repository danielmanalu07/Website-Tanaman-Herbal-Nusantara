<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VisitorCategory extends Model
{
    use SoftDeletes;
    public $table = 'visitor_categories';

    protected $fillable = [
        'id',
        'name',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
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

    public function languages()
    {
        return $this->belongsToMany(Language::class, 'visitor_category_languages')
            ->withPivot('name')
            ->withTimestamps();
    }

    public function translate($langCode)
    {
        $language = Language::where('code', $langCode)->first();
        if (! $language) {
            return [
                'name' => $this->name,
            ];
        }

        $translation = $this->languages()->where('language_id', $language->id)->first();
        return [
            'name' => $translation?->pivot->name ?? $this->name,
        ];
    }
}
