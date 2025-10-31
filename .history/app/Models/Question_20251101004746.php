<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'domain_id',
        'level',
        'is_active',
        'question',
        'thumbnail',
        'explanation',
    ];

    public static function createQuestion(array $data): self
    {
        // Handle media if necessary
        $question = self::create($data);

        if (isset($data['thumbnail'])) {
            $question->addMultipleMediaFromRequest(['thumbnail'])->toMediaCollection('questions');
        }

        return $question;
    }

    public function updateQuestion(array $data): self
    {
        $this->update($data);

        if (isset($data['thumbnail'])) {
            $this->addMultipleMediaFromRequest(['thumbnail'])->toMediaCollection('questions');
        }

        return $this;
    }

    public function deleteQuestion(): bool
    {
        // Automatically delete related answers
        $this->answers()->delete();
        return $this->delete();
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
