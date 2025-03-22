<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoicePaymentDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        'invoice_id',
        'account_holder_name',
        'bank_name',
        'ifsc_code',
        'account_number',
        'add_terms_and_Conditions',
        'add_notes',
    ];
}
