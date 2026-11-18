<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ExamResultsExport;
use App\Http\Controllers\Controller;
use App\Imports\ExamImport;
use App\Models\ClassesModel;
use App\Models\ClassExamModel;
use App\Models\ClassExamSubmissionModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class ExamController extends Controller
{
    public function index(Request $request)
    {
        $exams = ClassExamModel::query()
            ->with('classData')
            ->withCount('submissions')
            ->when($request->filled('class_id'), fn($query) => $query->where('class_id', $request->class_id))
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
            'class_id' => $request->filled('class_id') ? $request->integer('class_id') : null,
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

    public function import(Request $request)
    {
        $request->validate([
            'file_excel' => ['required', 'file', 'mimes:xlsx,xls,csv', 'max:10240'],
        ]);

        $import = new ExamImport;
        Excel::import($import, $request->file('file_excel'));

        if ($import->hasErrors()) {
            return redirect()->route('admin.exams.index')
                ->with('error', 'Import dibatalkan. Periksa kesalahan pada file Excel.')
                ->withErrors($import->errors());
        }

        $exams = $import->exams();
        if ($exams === []) {
            return redirect()->route('admin.exams.index')
                ->with('error', 'File Excel tidak memiliki data soal.');
        }

        DB::transaction(function () use ($exams) {
            foreach ($exams as $data) {
                ClassExamModel::create([
                    'class_id' => $data['class_id'],
                    'title' => $data['title'],
                    'description' => $data['description'],
                    'questions' => $data['questions'],
                    'public_token' => Str::random(48),
                    'status' => $data['status'],
                ]);
            }
        });

        return redirect()->route('admin.exams.index')->with(
            'success',
            count($exams) . ' exam berhasil diimport dengan ' . $import->questionCount() . ' soal.'
        );
    }

    public function downloadTemplate()
    {
        $path = public_path('download/template_import_exam.xlsx');

        abort_unless(is_file($path), 404, 'File template import exam tidak ditemukan.');

        return response()->download($path, 'template_import_exam.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
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
        $submissions = $exam->submissions()->latest('submitted_at')->latest('id')->get();

        return view('backend.exams.results', compact('exam', 'submissions'));
    }

    public function exportExcel(ClassExamModel $exam)
    {
        return Excel::download(
            new ExamResultsExport($this->uniqueSubmissions($exam)),
            'hasil-exam-' . $exam->id . '.xlsx'
        );
    }

    public function exportPdf(ClassExamModel $exam)
    {
        $submissions = $this->uniqueSubmissions($exam);
        $exam->load('classData');
        $pdf = Pdf::loadView('backend.exams.results-pdf', compact('exam', 'submissions'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('hasil-exam-' . $exam->id . '.pdf');
    }

    public function destroySubmission(ClassExamModel $exam, ClassExamSubmissionModel $submission)
    {
        abort_unless((int) $submission->exam_id === (int) $exam->id, 404);

        $submission->delete();

        return redirect()->route('admin.exams.results', $exam)->with('success', 'Hasil exam berhasil dihapus.');
    }

    private function uniqueSubmissions(ClassExamModel $exam): Collection
    {
        return $exam->submissions()
            ->latest('submitted_at')
            ->latest('id')
            ->get()
            ->unique(fn(ClassExamSubmissionModel $submission) => $this->normalizedName($submission->name))
            ->values();
    }

    private function normalizedName(?string $name): string
    {
        return mb_strtolower((string) preg_replace('/\s+/', ' ', trim((string) $name)));
    }

    private function validatedData(Request $request): array
    {
        $validator = Validator::make($request->all(), [
            'class_id' => ['nullable', 'integer', 'exists:classes,id'],
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
                $option = trim((string) data_get($question, 'options.' . $answer, ''));
                if ($answer === 'E' && $option === '') {
                    $validator->errors()->add('questions.' . $index . '.answer', 'Kunci E hanya dapat dipilih jika opsi E diisi.');
                }
            }
        });

        $validated = $validator->validate();
        $questions = collect($validated['questions'])->map(function (array $question) {
            $options = collect($question['options'])
                ->map(fn($option) => trim((string) $option))
                ->filter(fn($option) => $option !== '')
                ->all();

            return [
                'question' => trim($question['question']),
                'options' => $options,
                'answer' => strtoupper($question['answer']),
            ];
        })->values()->all();

        return [
            'class_id' => $validated['class_id'] ?? null,
            'title' => trim($validated['title']),
            'description' => filled($validated['description'] ?? null) ? trim($validated['description']) : null,
            'questions' => $questions,
            'status' => $request->boolean('status'),
        ];
    }
}
