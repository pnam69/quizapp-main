$materials = Hub::query()
    ->where(function ($q) use ($user) {
        $q->whereNull('user_id')
          ->orWhere('user_id', $user->id)
          ->orWhereIn('certification_id', $user->certifications->pluck('id'));
    })
    ->get();