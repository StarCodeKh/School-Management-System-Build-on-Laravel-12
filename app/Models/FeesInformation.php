<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeesInformation extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'student_name',
        'gender',
        'fees_type',
        'fees_amount',
        'paid_date',
    ];
}
