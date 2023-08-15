<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Low_Subjects extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
    ];
    protected $table = 'low_subjects';
}
