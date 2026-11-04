<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassesModel;
use App\Models\ClassExamModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ExamController extends Controller
{
    public function index(Request $request)
    {
        $exams = ClassExamModel::query()
            ->with('classData')
            ->withCount('submissions')
            ->when($request->filled('class_id'), fn ($query) => $query->where('class_id', $request->class_id))
            ->latest()
            ->paginate(20)
            ->withQueryString();
        $classes = ClassesModel::query()->orderBy('title')->get(['id', 'title']);

        return view('backend.exams.index', compact('exams', 'classes'));
    }

    public function create(Request $request)
    {
        $classes = ClassesModel::query()->orderBy('title')->get(['id', 'title']);
        $exam = new ClassExamModel([
            'class_id' => $request->integer('class_id'),
            'status' => false,
        ]);

        return view('backend.exams.form', compact('exam', 'classes'));
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        $data['public_token'] = Str::random(48);

        $exam = ClassExamModel::create($data);

        return redirect()->route('admin.exams.edit', $exam)->with('success', 'Exam berhasil dibuat.');
    }

    public function edit(ClassExamModel $exam)
    {
        $classes = ClassesModel::query()->orderBy('title')->get(['id', 'title']);

        return view('backend.exams.form', compact('exam', 'classes'));
    }

    public function update(Request $request, ClassExamModel $exam)
    {
        $exam->update($this->validatedData($request));

        return redirect()->route('admin.exams.edit', $exam)->with('success', 'Exam berhasil diperbarui.');
    }

    public function destroy(ClassExamModel $exam)
    {
        $exam->delete();

        return redirect()->route('admin.exams.index')->with('success', 'Exam berhasil dihapus.');
    }

    public function results(ClassExamModel $exam)
    {
        $exam->load('classData');
        $submissions = $exam->submissions()->latest('submitted_at')->paginate(30);

        return view('backend.exams.results', compact('exam', 'submissions'));
    }

    private function validatedData(Request $request): array
    {
        $validator = Validator::make($request->all(), [
            'class_id' => ['required', 'exists:classes,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'status' => ['nullable', 'boolean'],
            'questions' => ['required', 'array', 'min:1'],
            'questions.*.question' => ['required', 'string', 'max:2000'],
            'questions.*.options.A' => ['required', 'string', 'max:500'],
            'questions.*.options.B' => ['required', 'string', 'max:500'],
            'questions.*.options.C' => ['required', 'string', 'max:500'],
            'questions.*.options.D' => ['required', 'string', 'max:500'],
            'questions.*.options.E' => ['nullable', 'string', 'max:500'],
            'questions.*.answer' => ['required', 'string', 'in:A,B,C,D,E'],
        ], [
            'questions.*.question.required' => 'Pertanyaan wajib diisi.',
            'questions.*.options.*.required' => 'Opsi A sampai D wajib diisi.',
            'questions.*.answer.required' => 'Kunci jawaban wajib dipilih.',
        ]);

        $validator->after(function ($validator) use ($request) {
            foreach ((array) $request->input('questions', []) as $index => $question) {
                $answer = strtoupper((string) ($question['answer'] ?? ''));
                $option = trim((string) data_get($question, 'options.'.$answer, ''));
                if ($answer === 'E' && $option === '') {
                    $validator->errors()->add('questions.'.$index.'.answer', 'Kunci E hanya dapat dipilih jika opsi E diisi.');
                }
            }
        });

        $validated = $validator->validate();
        $questions = collect($validated['questions'])->map(function (array $question) {
            $options = collect($question['options'])
                ->map(fn ($option) => trim((string) $option))
                ->filter(fn ($option) => $option !== '')
                ->all();

            return [
                'question' => trim($question['question']),
                'options' => $options,
                'answer' => strtoupper($question['answer']),
            ];
        })->values()->all();

        return [
            'class_id' => $validated['class_id'],
            'title' => trim($validated['title']),
            'description' => filled($validated['description'] ?? null) ? trim($validated['description']) : null,
            'questions' => $questions,
            'status' => $request->boolean('status'),
        ];
    }
}
