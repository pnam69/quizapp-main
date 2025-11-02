<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserXp extends Model
{
    use HasFactory;

    protected $table = 'user_xp';

    protected $fillable = [
        'user_id',
        'total_xp',
        'level',
        'xp_to_next_level',
    ];

    protected $casts = [
        'total_xp' => 'integer',
        'level' => 'integer',
        'xp_to_next_level' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getProgressPercentageAttribute(): float
    {
        if ($this->xp_to_next_level == 0) return 100;

        $currentLevelXp = $this->getCurrentLevelXp();
        return ($currentLevelXp / $this->xp_to_next_level) * 100;
    }

    public function getCurrentLevelXp(): int
    {
        // Calculate XP for current level (simplified formula)
        $previousLevelXp = ($this->level - 1) * 100;
        return $this->total_xp - $previousLevelXp;
    }

    public function addXp(int $amount): void
    {
        $this->total_xp += $amount;

        // Check for level up
        while ($this->getCurrentLevelXp() >= $this->xp_to_next_level) {
            $this->levelUp();
        }

        $this->save();
    }

    protected function levelUp(): void
    {
        $this->level++;
        $this->xp_to_next_level = $this->calculateXpForNextLevel();
    }

    protected function calculateXpForNextLevel(): int
    {
        // Progressive XP requirement: 100 * level
        return 100 * $this->level;
    }
}
