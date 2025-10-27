<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Certification;
use App\Models\Question;

class Test extends Model
{
    use HasFactory;
    protected static ?string $model = \App\Models\Test::class;

    protected $fillable = [
        'name',
        'certification_id',
        'question_ids',
        'is_active',
    ];

    protected $casts = [
        'question_ids' => 'array',
        'is_active' => 'boolean',
    ];

    public function certification(): BelongsTo
    {
        return $this->belongsTo(Certification::class);
    }
    

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class, 'id', 'question_ids');
    }
}
