<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\trip;
class line extends Model
{
    protected $guarded=[''];
    
    use HasFactory;
    public function trips()
    {
        return $this->hasMany(trip::class);
    }
}
