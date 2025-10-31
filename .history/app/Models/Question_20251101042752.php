<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'domain_id',
        'level',
        'is_active',
        'question',
        'explanation',
        'user_id',
    ];

    protected static function booted()
    {
        static::creating(function ($question) {
            $question->user_id = auth()->id() ?? 1;
        });
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function domain()
    {
        return $this->belongsTo(Domain::class);
    }
}
