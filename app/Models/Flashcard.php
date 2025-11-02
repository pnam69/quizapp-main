<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flashcard extends Model
{
    use HasFactory;

    protected $fillable = [
        'deck_id',
        'front_content',
        'back_content',
        'front_media',
        'back_media',
        'difficulty',
        'tags',
        'order',
    ];

    protected $casts = [
        'front_media' => 'array',
        'back_media' => 'array',
        'tags' => 'array',
        'order' => 'integer',
    ];

    // ========================
    // Relationships
    // ========================

    public function deck()
    {
        return $this->belongsTo(FlashcardDeck::class, 'deck_id');
    }

    public function userMastery()
    {
        return $this->hasMany(\App\Models\UserCardMastery::class, 'card_id');
    }

    // ========================
    // Helper Methods
    // ========================

    public function getDifficultyColorAttribute()
    {
        return match ($this->difficulty) {
            'easy' => 'success',
            'medium' => 'warning',
            'hard' => 'danger',
            default => 'gray',
        };
    }
}
