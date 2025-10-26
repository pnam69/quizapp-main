<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\User;

class Classroom extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'year',
        'semester',
        'is_active',
    ];

    /**
     * Users assigned to this classroom.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'classroom_user', 'classroom_id', 'user_id')
                    ->withTimestamps();
    }
}
