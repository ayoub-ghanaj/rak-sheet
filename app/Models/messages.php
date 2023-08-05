<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class messages extends Model
{
    use HasFactory;

    protected $guard = 'messages';
    protected $guarded = [];
    protected $table = 'messages';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'dilevered',
        'wsp_id',
        'message',
        'phone_number',
    ];
}
