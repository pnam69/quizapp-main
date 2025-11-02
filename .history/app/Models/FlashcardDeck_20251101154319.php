<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlashcardDeck extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_id',
        'classroom_id',
        'created_by',
        'title',
        'description',
        'is_public',
        'settings',
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'settings' => 'array',
    ];

    // ========================
    // Relationships
    // ========================

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function flashcards()
    {
        return $this->hasMany(Flashcard::class, 'deck_id');
    }

    public function studySessions()
    {
        return $this->hasMany(\App\Models\FlashcardStudySession::class, 'deck_id');
    }

    // ========================
    // Helper Methods
    // ========================

    public function getCardCountAttribute()
    {
        return $this->flashcards()->count();
    }

    public function getStudyCountAttribute()
    {
        return $this->studySessions()->count();
    }
}
