<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
        'date_of_birth',
        'roll',
        'blood_group',
        'religion',
        'email',
        'class',
        'section',
        'admission_id',
        'phone_number',
        'upload',
    ];
}
