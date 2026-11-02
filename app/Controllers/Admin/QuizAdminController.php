<?php

namespace App\Controllers\Admin;

use App\Models\OrientationQuiz;
use App\Models\OrientationResult;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QuizAdminController
{
    public function index(): View
    {
        $quizzes = OrientationQuiz::orderBy('order_number')->get();
        $totalCompletions = OrientationResult::count();
        $recentResults = OrientationResult::with(['user', 'bacSerie'])->latest()->take(10)->get();

        return view('admin.quiz.index', compact('quizzes', 'totalCompletions', 'recentResults'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'question_text' => 'required|string',
            'category' => 'required|string',
            'dimension' => 'nullable|string|max:10',
            'order_number' => 'required|integer',
            'options_json' => 'required|string', // raw json string from admin editor
        ]);

        $options = json_decode($validated['options_json'], true);
        if (!is_array($options)) {
            return back()->with('error', 'Le format JSON des options est invalide.');
        }

        OrientationQuiz::create([
            'question_text' => $validated['question_text'],
            'category' => $validated['category'],
            'dimension' => $validated['dimension'],
            'options' => $options,
            'order_number' => $validated['order_number'],
            'is_active' => true,
        ]);

        return redirect()->route('admin.quiz.index')->with('success', 'Question ajoutée avec succès.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $quiz = OrientationQuiz::findOrFail($id);
        $quiz->delete();

        return redirect()->route('admin.quiz.index')->with('success', 'Question supprimée.');
    }
}
