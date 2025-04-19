<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactUs extends Model
{
    use SoftDeletes;

    protected $table    = 'contact_us';
    protected $fillable = [
        'id',
        'title',
        'text',
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

    public function languages()
    {
        return $this->belongsToMany(Language::class, 'contact_us_languages')
            ->withPivot('title', 'text')
            ->withTimestamps();
    }
    public function translate($langCode)
    {
        $language = Language::where('code', $langCode)->first();
        if (! $language) {
            return [
                'title' => $this->title,
                'text'  => $this->text,
            ];
        }

        $translation = $this->languages()->where('language_id', $language->id)->first();
        return [
            'title' => $translation ? $translation->pivot->title : $this->title,
            'text'  => $translation ? $translation->pivot->text : $this->text,
        ];
    }
}
