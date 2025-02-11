<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForgotPassword extends Model
{
    protected $table = 'forgot_passwords';

    public $fillable = [
        'id',
        'user_id',
        'username',
        'verification_code',
        'verification_date',
        'verification_status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
