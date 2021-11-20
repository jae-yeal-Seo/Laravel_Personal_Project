<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResolutionHashTag extends Model
{
    use HasFactory;

    public function resolution()
    {
        return $this->belongsTo(Resolution::class, 'resolution_id', 'id', 'resolutions');
    }
}
