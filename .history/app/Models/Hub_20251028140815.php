<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Hub extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'type',
        'file_path',
        'link_url',
        'certification_id',
        'section_id',
        // 'user_id' removed on purpose when you migrated to pivot
    ];

    /**
     * Students assigned to this hub (many-to-many)
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\User::class, 'hub_user', 'hub_id', 'user_id');
    }
}
