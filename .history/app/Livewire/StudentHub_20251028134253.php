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
                $q->whereDoesntHave('users') // Global hubs
                    ->orWhereHas('users', fn($q2) => $q2->where('id', $user->id)) // Assigned hubs
                    ->orWhere('certification_id', $user->certification_id)
                    ->orWhere('section_id', $user->section_id);
            })
            ->orderByDesc('created_at')
            ->get();
    }

    public function render()
    {
        return view('livewire.student-hub');
    }
}
