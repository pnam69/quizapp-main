<?php

namespace App\Livewire;

use App\Models\Hub;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class StudentHub extends Component
{
    public $materials = [];

    public function mount()
    {
        $user = Auth::user();

        $this->materials = Hub::query()
            ->where(function ($q) use ($user) {
                $q->whereDoesntHave('users')                // Global hub
                    ->orWhereHas('users', fn($q2) => $q2->where('id', $user->id)) // Assigned hub
                    ->orWhere('certification_id', $user->certification_id) // By certification
                    ->orWhere('section_id', $user->section_id);            // By section
            })
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function render()
    {
        return view('livewire.student-hub');
    }
}
