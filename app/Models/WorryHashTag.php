<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorryHashTag extends Model
{
    use HasFactory;

    public function worry()
    {
        return $this->belongsTo(Worry::class, 'worry_id', 'id', 'worries');
    }
}
