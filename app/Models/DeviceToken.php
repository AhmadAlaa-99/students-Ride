<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\driver;

class DeviceToken extends Model
{
    use HasFactory;
    protected $guarded=[''];
    /*
    public function driver()
    {
        return $this->belongsTo(driver::class);
    }
    */
}

