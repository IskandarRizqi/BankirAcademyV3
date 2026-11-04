<?php

namespace App\Http\Controllers;

use App\Models\ClassExamModel;
use App\Models\ClassExamSubmissionModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ExamController extends Controller
{
    public function show(string $token)
    {
        $exam = $this->activeExam($token);

        return view('exam.show', [
            'exam' => $exam,
            'questions' => $this->publicQuestions($exam),
            'completed' => false,
        ]);
    }

    public function submit(Request $request, string $token)
    {
        $exam = $this->activeExam($token);
        $questions = collect($exam->questions ?: [])->values();
        $answerRules = [];

        foreach ($questions as $index => $question) {
            $answerRules['answers.'.$index] = ['required', 'string', 'in:A,B,C,D,E'];
        }

        $validator = Validator::make($request->all(), array_merge([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30', 'regex:/^[0-9+()\-\s]{8,30}$/'],
            'answers' => ['required', 'array', 'size:'.$questions->count()],
        ], $answerRules), [
            'answers.*.required' => 'Semua soal wajib dijawab.',
            'phone.regex' => 'Nomor HP tidak valid.',
        ]);
        $validator->after(function ($validator) use ($questions, $request) {
            foreach ($questions as $index => $question) {
                $answer = $request->input('answers.'.$index);
                if ($answer && ! filled(data_get($question, 'options.'.$answer))) {
                    $validator->errors()->add('answers.'.$index, 'Pilihan jawaban tidak valid.');
                }
            }
        });
        $validated = $validator->validate();

        $answers = array_values($validated['answers']);
        $correctAnswers = $questions->filter(function ($question, $index) use ($answers) {
            return ($answers[$index] ?? null) === ($question['answer'] ?? null);
        })->count();
        $totalQuestions = $questions->count();
        $score = $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100, 2) : 0;

        DB::transaction(function () use ($exam, $validated, $answers, $questions, $correctAnswers, $totalQuestions, $score) {
            ClassExamSubmissionModel::create([
                'exam_id' => $exam->id,
                'name' => trim($validated['name']),
                'phone' => trim($validated['phone']),
                'answers' => $answers,
                'questions_snapshot' => $questions->all(),
                'correct_answers' => $correctAnswers,
                'total_questions' => $totalQuestions,
                'score' => $score,
                'submitted_at' => now(),
            ]);
        });

        return redirect()->route('exam.thanks', $exam->public_token);
    }

    public function thanks(string $token)
    {
        $exam = $this->activeExam($token);

        return view('exam.show', [
            'exam' => $exam,
            'questions' => [],
            'completed' => true,
        ]);
    }

    private function activeExam(string $token): ClassExamModel
    {
        return ClassExamModel::query()
            ->with('classData')
            ->where('public_token', $token)
            ->where('status', true)
            ->firstOrFail();
    }

    private function publicQuestions(ClassExamModel $exam): array
    {
        return collect($exam->questions ?: [])->map(function (array $question) {
            return [
                'question' => $question['question'] ?? '',
                'options' => collect($question['options'] ?? [])
                    ->filter(fn ($option) => filled($option))
                    ->all(),
            ];
        })->values()->all();
    }
}
