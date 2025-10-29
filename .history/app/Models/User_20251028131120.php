<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Jeffgreco13\FilamentBreezy\Traits\TwoFactorAuthenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, TwoFactorAuthenticatable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'is_active',
        'email_verified_at',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'boolean',
        'is_active' => 'boolean',
    ];

    // Many-to-many relationships
    public function roles()
    {
        return $this->belongsToMany(\Spatie\Permission\Models\Role::class);
    }

    public function classrooms()
    {
        return $this->belongsToMany(Classroom::class);
    }

    public function sections()
    {
        return $this->belongsToMany(Section::class);
    }

    public function certifications()
    {
        return $this->belongsToMany(Certification::class);
    }

    // Quizzes taken by the user
    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    public function quizHeaders()
    {
        return $this->hasMany(QuizHeader::class);
    }
}
