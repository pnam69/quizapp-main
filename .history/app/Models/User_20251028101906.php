<?php

namespace App\Models;

use App\Models\Section;
use App\Models\Certification;
use App\Models\Classroom;
use Filament\Models\Contracts\HasAvatar;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Traits\HasRoles;
use Jeffgreco13\FilamentBreezy\Traits\TwoFactorAuthenticatable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable implements FilamentUser, HasAvatar
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, TwoFactorAuthenticatable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'is_active',
        'email_verified_at',
        'avatar_url',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function canAccessPanel(\Filament\Panel $panel): bool
    {
        return match ($panel->getId()) {
            'admin' => $this->is_admin,
            'member' => ! $this->is_admin,
            default => false,
        };
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar_url ? Storage::url($this->avatar_url) : null;
    }

    // ========================
    // RELATIONSHIPS
    // ========================

    // Many-to-many: users ↔ sections
    public function sections(): BelongsToMany
    {
        return $this->belongsToMany(Section::class, 'section_user', 'user_id', 'section_id');
    }

    // Many-to-many: users ↔ certifications
    public function certifications(): BelongsToMany
    {
        return $this->belongsToMany(Certification::class, 'certification_user', 'user_id', 'certification_id');
    }

    // Many-to-many: users ↔ classrooms
    public function classrooms(): BelongsToMany
    {
        return $this->belongsToMany(Classroom::class, 'classroom_user', 'user_id', 'classroom_id');
    }

    // One-to-many: user ↔ quiz results
    public function quizHeaders(): HasMany
    {
        return $this->hasMany(QuizHeader::class);
    }
}
