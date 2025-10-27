<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'certification_id',
        'question_ids',
        'is_active',
    ];

    protected $casts = [
        'question_ids' => 'array',
    ];

    public function certification()
    {
        return $this->belongsTo(Certification::class);
    }
}
