<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subs extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'subscription_plan', 'start_date', 'end_date'];

        // Define the relationship between User and Subs
        public function user()
        {
            return $this->belongsTo(User::class);
        }
}
