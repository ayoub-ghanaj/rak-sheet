<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subject extends Model
{
    use HasFactory;
    protected $guard = 'subject';
    protected $guarded = [];
    protected $table = 'subject';
    protected $fillable = [
        'sheet_id',
        'subject',
        'subject_ar',
        'grade_short',
        'total',
        'grade',
        'rank',
        'status',
        'Evaluation',
        'end_period',
    ];
}
