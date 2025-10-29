<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
    ];

    // THIS is the key part: cast file_path to array so Filament treats JSON properly
    protected $casts = [
        'file_path' => 'array',
    ];

    // Relationships
    public function certification()
    {
        return $this->belongsTo(Certification::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'hub_user');
    }
}
