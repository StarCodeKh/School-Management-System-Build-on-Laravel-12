<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceTotalAmount extends Model
{
    use HasFactory;
    protected $fillable = [
        'invoice_id',
        'taxable_amount',
        'round_off',
        'total_amount',
        'upload_sign',
        'name_of_the_signatuaory',
    ];
}
