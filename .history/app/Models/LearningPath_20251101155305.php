<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearningPath extends Model
{
    use HasFactory;

    protected $fillable = [
        'classroom_id',
        'created_by',
        'title',
        'description',
        'difficulty_level',
        'estimated_hours',
        'is_active',
    ];

    protected $casts = [
        'estimated_hours' => 'integer',
        'is_active' => 'boolean',
    ];

    // ========================
    // Relationships
    // ========================

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function modules()
    {
        return $this->hasMany(\App\Models\LearningPathModule::class, 'path_id')->orderBy('order');
    }

    public function userPaths()
    {
        return $this->hasMany(\App\Models\UserLearningPath::class, 'path_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_learning_paths', 'path_id', 'user_id')
            ->withPivot(['started_at', 'completed_at', 'progress_percentage'])
            ->withTimestamps();
    }

    // ========================
    // Helper Methods
    // ========================

    public function getModuleCountAttribute()
    {
        return $this->modules()->count();
    }

    public function getDifficultyColorAttribute()
    {
        return match ($this->difficulty_level) {
            'beginner' => 'success',
            'intermediate' => 'warning',
            'advanced' => 'danger',
            default => 'gray',
        };
    }
}
