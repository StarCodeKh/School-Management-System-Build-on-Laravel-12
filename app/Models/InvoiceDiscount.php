<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDiscount extends Model
{
    use HasFactory;
    protected $fillable = [
        'invoice_id',
        'offer_new',
    ];
    
}
