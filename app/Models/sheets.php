<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sheets extends Model
{
        use HasFactory;

    protected $guard = 'sheets';
    protected $guarded = [];
    protected $table = 'sheets';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'id_number',
        'state',
        'state_ar',
        'title1',
        'title1_ar',
        'title2',
        'title2_ar',
        'title3',
        'title3_ar',
        'year',
        'year_ar',
        'school',
        'school_ar',
        'name',
        'name_ar',
        'class',
        'nationality',
        'nationality_ar',
        'birth_day',
        'birth_day_ar',
        'sort_by_grade',
        'sort_by_class',
        'absence',
        'latency',
        'table',
        'status',
        'message',
        'class_drop',
        'grade_drop',
    ];
}