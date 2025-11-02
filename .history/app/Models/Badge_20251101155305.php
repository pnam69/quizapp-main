<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Badge extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'icon',
        'type',
        'xp_reward',
        'criteria',
        'rarity',
        'is_active',
    ];

    protected $casts = [
        'criteria' => 'array',
        'is_active' => 'boolean',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_badges')
            ->withTimestamps()
            ->withPivot('earned_at');
    }

    public function getRarityColorAttribute(): string
    {
        return match ($this->rarity) {
            'common' => 'gray',
            'rare' => 'blue',
            'epic' => 'purple',
            'legendary' => 'orange',
            default => 'gray',
        };
    }

    public function getRarityIconAttribute(): string
    {
        return match ($this->rarity) {
            'common' => '⚪',
            'rare' => '🔵',
            'epic' => '🟣',
            'legendary' => '🟠',
            default => '⚪',
        };
    }
}
