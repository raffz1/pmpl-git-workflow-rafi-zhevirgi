<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Module extends Model
{
    protected $fillable = [
        'path_id',
        'step_number',
        'title',
        'desc',
        'side',
        'icon',
        'content_title',
        'content_body',
        'quiz_selection_type',
        'quiz_custom_questions',
    ];

    protected $casts = [
        'id' => 'integer',
        'path_id' => 'integer',
        'step_number' => 'integer',
        'quiz_custom_questions' => 'array',
    ];


    public function path(): BelongsTo
    {
        return $this->belongsTo(Path::class);
    }

    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }
}
