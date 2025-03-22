<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    protected $fillable = [
        'subject_id',
        'subject_name',
        'class',
    ];

    /** auto genarate id */
    protected static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $getUser = self::orderBy('subject_id', 'desc')->first();

            if ($getUser) {
                $latestID = intval(substr($getUser->subject_id, 5));
                $nextID = $latestID + 1;
            } else {
                $nextID = 1;
            }
            $model->subject_id = 'PRE' . sprintf("%03s", $nextID);
            while (self::where('subject_id', $model->subject_id)->exists()) {
                $nextID++;
                $model->subject_id = 'PRE' . sprintf("%03s", $nextID);
            }
        });
    }
}
