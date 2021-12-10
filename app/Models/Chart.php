<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chart extends Model
{
    use HasFactory;

    protected $fillable = [
        'positive',
        'neutral',
        'negative',
        'worry_id',
        'user_id',
        'title',
        'untilday',
        'untilmonth',
        'untilyear',
    ];
}
