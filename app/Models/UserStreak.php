<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class UserStreak extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'current_streak',
        'longest_streak',
        'last_activity_date',
        'freeze_count',
    ];

    protected $casts = [
        'last_activity_date' => 'date',
        'current_streak' => 'integer',
        'longest_streak' => 'integer',
        'freeze_count' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function updateStreak(): void
    {
        $today = Carbon::today();

        if (!$this->last_activity_date) {
            // First activity
            $this->current_streak = 1;
            $this->last_activity_date = $today;
        } elseif ($this->last_activity_date->isToday()) {
            // Already updated today
            return;
        } elseif ($this->last_activity_date->isYesterday()) {
            // Consecutive day
            $this->current_streak++;
            $this->last_activity_date = $today;
        } else {
            // Streak broken
            $this->current_streak = 1;
            $this->last_activity_date = $today;
        }

        // Update longest streak
        if ($this->current_streak > $this->longest_streak) {
            $this->longest_streak = $this->current_streak;
        }

        $this->save();
    }

    public function useFreeze(): bool
    {
        if ($this->freeze_count > 0) {
            $this->freeze_count--;
            $this->last_activity_date = Carbon::today();
            $this->save();
            return true;
        }
        return false;
    }

    public function getStreakStatusAttribute(): string
    {
        if (!$this->last_activity_date) {
            return 'inactive';
        }

        if ($this->last_activity_date->isToday()) {
            return 'active';
        }

        if ($this->last_activity_date->isYesterday()) {
            return 'at_risk';
        }

        return 'broken';
    }
}
