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

    public function languages()
    {
        return $this->belongsToMany(Language::class, 'plant_languages')
            ->withPivot('name', 'advantage', 'ecology', 'endemic_information')
            ->withTimestamps();
    }

    public function translate($langCode)
    {
        $language = Language::where('code', $langCode)->first();
        if (! $language) {
            return [
                'name'                => $this->name,
                'advantage'           => $this->advantage,
                'ecology'             => $this->ecology,
                'endemic_information' => $this->endemic_information,
            ];
        }

        $translation = $this->languages()->where('language_id', $language->id)->first();
        return [
            'name'                => $translation?->pivot->name ?? $this->name,
            'advantage'           => $translation?->pivot->advantage ?? $this->advantage,
            'ecology'             => $translation?->pivot->ecology ?? $this->ecology,
            'endemic_information' => $translation?->pivot->endemic_information ?? $this->endemic_information,
        ];
    }
}
