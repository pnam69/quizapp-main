<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MyQuizzes;

class MyQuizzesController extends Controller
{
    public function create(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $quiz = MyQuizzes::create([
            'title' => $validated['title'],
            'section_id' => 1, // placeholder, update to dynamic later
            'certification_id' => 1, // same here
            'quiz_size' => 0, // default or calculated value
        ]);

        return response()->json([
            'message' => 'Quiz created successfully!',
            'quiz' => $quiz,
        ]);
    }
}
