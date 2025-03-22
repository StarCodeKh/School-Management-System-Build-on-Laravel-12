<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceCustomerName extends Model
{
    use HasFactory;
    protected $fillable = [
        'invoice_id',
        'customer_name',
        'po_number',
        'date',
        'due_date',
        'enable_tax',
        'recurring_incoice',
        'by_month',
        'month',
        'invoice_from',
        'invoice_to',
    ];

    /** auto genarate id */
    protected static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $getUser = self::orderBy('invoice_id', 'desc')->first();

            if ($getUser) {
                $latestID = intval(substr($getUser->invoice_id,5));
                $nextID = $latestID + 1;
            } else {
                $nextID = 1;
            }
            $model->invoice_id = 'IN0' . sprintf("%05s", $nextID);
            while (self::where('invoice_id', $model->invoice_id)->exists()) {
                $nextID++;
                $model->invoice_id = 'IN0' . sprintf("%05s", $nextID);
            }
        });
    }
}
