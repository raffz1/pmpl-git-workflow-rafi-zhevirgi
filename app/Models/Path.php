<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Path extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'icon',
        'image',
        'description',
        'theme',
        'salary_range',
        'skills',
        'suitability',
        'career_description',
    ];

    protected $casts = [
        'skills' => 'array',
        'suitability' => 'array',
    ];

    public function modules(): HasMany
    {
        return $this->hasMany(Module::class)->orderBy('step_number', 'asc');
    }
}
