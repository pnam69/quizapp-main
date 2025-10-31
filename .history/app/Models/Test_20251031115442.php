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


    public function questions()
    {
        return $this->belongsToMany(Question::class, 'test_question')
            ->withTimestamps();
    }

    public function certifications()
    {
        return $this->belongsToMany(Certification::class, 'certification_test');
    }
}
