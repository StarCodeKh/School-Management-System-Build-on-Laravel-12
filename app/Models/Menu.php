<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'icon',
        'route',
        'active_routes',
        'pattern',
        'custom_active_pattern',
        'parent_id',
        'order',
        'is_active',
    ];

    protected $casts = [
        'active_routes' => 'array',
    ];

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('order');
    }

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }
}
