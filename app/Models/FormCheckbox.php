<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormCheckbox extends Model
{
    use HasFactory;
    protected $fillable = [
    'question1',
    'question2',
    'question3',
    ];
}
