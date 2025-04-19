<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitorCategoryLanguage extends Model
{
    protected $table = 'visitor_category_languages';

    protected $fillable = [
        'id',
        'visitor_category_id',
        'language_id',
        'name',
        'created_at',
        'updated_at',
    ];
}
