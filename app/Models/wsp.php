<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class wsp extends Model
{
    use HasFactory;
        use HasFactory;

    protected $guard = 'wsp';
    protected $guarded = [];
    protected $table = 'wsp';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
            'user_id',
            'api_key',
            'version',
            'number_id',
            'valid',
    ];
}
