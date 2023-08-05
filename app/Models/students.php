<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class students extends Model
{
    use HasFactory;

    protected $guard = 'students';
    protected $guarded = [];
    protected $table = 'students';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
            'user_id',
            'name',
            'id_number',
            'class_number',
            'class',
            'phone_number',
            'year',
    ];
}
