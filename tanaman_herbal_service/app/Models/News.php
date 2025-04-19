<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use SoftDeletes;
    protected $table = 'news';

    protected $fillable = [
        'id',
        'title',
        'content',
        'status',
        'published_at',
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

    public function images()
    {
        return $this->belongsToMany(Image::class, 'news_images');
    }

    public function languages()
    {
        return $this->belongsToMany(Language::class, 'news_languages')
            ->withPivot('title', 'content')
            ->withTimestamps();
    }

    public function translate($langCode)
    {
        $language = Language::where('code', $langCode)->first();
        if (! $language) {
            return [
                'title'   => $this->title,
                'content' => $this->content,
            ];
        }

        $translation = $this->languages()->where('language_id', $language->id)->first();
        return [
            'title'   => $translation?->pivot->title ?? $this->title,
            'content' => $translation?->pivot->content ?? $this->content,
        ];
    }

}
