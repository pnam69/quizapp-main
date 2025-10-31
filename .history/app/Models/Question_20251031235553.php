<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
        'type',
        'section_id',
        'certification_id',
    ];

    // Relationships
    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function certification()
    {
        return $this->belongsTo(Certification::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    // Core logic for CRUD

    public static function createQuestion(array $data)
    {
        $validated = Validator::make($data, [
            'text' => 'required|string|max:500',
            'type' => 'required|string',
            'section_id' => 'nullable|exists:sections,id',
            'certification_id' => 'nullable|exists:certifications,id',
        ])->validate();

        return static::create($validated);
    }

    public function updateQuestion(array $data)
    {
        $validated = Validator::make($data, [
            'text' => 'required|string|max:500',
            'type' => 'required|string',
            'section_id' => 'nullable|exists:sections,id',
            'certification_id' => 'nullable|exists:certifications,id',
        ])->validate();

        $this->update($validated);
        return $this;
    }

    public function deleteQuestion()
    {
        $this->answers()->delete();
        return $this->delete();
    }
}
