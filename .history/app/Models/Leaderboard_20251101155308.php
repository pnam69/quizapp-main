<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leaderboard extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'scope',
        'scope_id',
        'period',
        'starts_at',
        'ends_at',
        'is_active',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    // ========================
    // Relationships
    // ========================

    public function entries()
    {
        return $this->hasMany(LeaderboardEntry::class)->orderBy('rank');
    }

    public function scope()
    {
        return $this->morphTo();
    }

    // ========================
    // Helper Methods
    // ========================

    public function getTopEntries($limit = 10)
    {
        return $this->entries()->with('user')->limit($limit)->get();
    }
}
