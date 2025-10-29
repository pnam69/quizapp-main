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
                $q->whereNull('user_id')
                    ->orWhere('user_id', $user->id)
                    ->orWhereIn('certification_id', $user->->pluck('id'));
            })
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function render()
    {
        return view('livewire.student-hub');
    }
}
