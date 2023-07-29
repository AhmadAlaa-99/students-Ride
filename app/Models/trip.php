<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\driver;
use App\Models\line;
use App\Models\student;

class trip extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table='trips';
    public function getTIMEARRANGEAttribute($value)
    {
        return explode(',', $value);
    }
    protected $guarded=[''];
    
    public function driver()
    {
        return $this->belongsTo(driver::class);
    }

    public function line()
    {
        return $this->belongsTo(line::class);
    }
    public function students()
    {
        return $this->belongsToMany(student::class)->withPivot('main_time','time_desire_1','time_desire_2','status');
    }
    public function scopeBetweenDates($query, $startDate, $endDate)
{
    return $query->whereBetween('trip_date', [$startDate, $endDate]);
}
    
}
