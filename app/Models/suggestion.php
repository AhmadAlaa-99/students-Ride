<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\trip;

class suggestion extends Model
{
    use HasFactory;
    public function trip()
    {
        return $this->belongsTo(trip::class);
    }
}
