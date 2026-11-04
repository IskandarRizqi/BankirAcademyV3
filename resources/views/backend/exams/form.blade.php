@extends('layouts.compact')

@section('title', $exam->exists ? 'Edit Exam' : 'Tambah Exam')

@section('content')
@php
    $formQuestions = old('questions', $exam->questions ?: [[
        'question' => '',
        'options' => ['A' => '', 'B' => '', 'C' => '', 'D' => ''],
        'answer' => 'A',
    ]]);
    $nextQuestionIndex = count($formQuestions) > 0
        ? max(array_map('intval', array_keys($formQuestions))) + 1
        : 0;
@endphp
<style>
    .floating-add-question {
        position: fixed;
        right: 28px;
        bottom: 28px;
        z-index: 1030;
        border-radius: 999px;
        box-shadow: 0 8px 22px rgba(31, 85, 224, .28);
        font-weight: 700;
    }

    @media (max-width: 575.98px) {
        .floating-add-question {
            right: 18px;
            bottom: 18px;
            width: 50px;
            height: 50px;
            padding: 0;
            border-radius: 50%;
        }

        .floating-add-question span {
            display: none;
        }
    }
</style>

<div class="col-lg-12">
    <div class="d-flex align-items-center justify-content-between flex-wrap mb-3">
        <div>
            <h3 class="mb-1">{{ $exam->exists ? 'Edit Exam' : 'Tambah Exam' }}</h3>
            <p class="text-muted mb-0">Exam berdiri sendiri, tetapi selalu terhubung ke satu kelas.</p>
        </div>
        <a href="{{ route('admin.exams.index') }}" class="btn btn-outline-secondary mt-2 mt-md-0">Kembali</a>
    </div>
    @if($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif

    <form action="{{ $exam->exists ? route('admin.exams.update', $exam) : route('admin.exams.store') }}" method="POST">
        @csrf
        @if($exam->exists) @method('PUT') @endif
        <div class="card shadow-sm border-0 mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-7">
                        <div class="form-group">
                            <label for="title">Judul exam</label>
                            <input id="title" name="title" class="form-control" value="{{ old('title', $exam->title) }}" required maxlength="255">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="class_id">Kelas</label>
                            <select id="class_id" name="class_id" class="form-control" required>
                                <option value="">Pilih kelas</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ (string) old('class_id', $exam->class_id) === (string) $class->id ? 'selected' : '' }}>{{ $class->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            <label for="description">Petunjuk singkat <small class="text-muted">(opsional)</small></label>
                            <textarea id="description" name="description" class="form-control" rows="3" maxlength="2000">{{ old('description', $exam->description) }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Status</label>
                            <div class="custom-control custom-switch mt-2">
                                <input type="checkbox" class="custom-control-input" id="status" name="status" value="1" {{ old('status', $exam->status) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="status">Aktifkan exam</label>
                            </div>
                            <small class="form-text text-muted">Jika aktif, link dapat dibuka tanpa login.</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-2">
            <h4 class="mb-1">Soal pilihan ganda</h4>
            <p class="text-muted small mb-0">Gunakan tombol tambah soal yang mengambang di kanan bawah halaman.</p>
        </div>

        <div id="questionList">
            @foreach($formQuestions as $index => $question)
                @php
                    $options = $question['options'] ?? [];
                    $selectedAnswer = $question['answer'] ?? 'A';
                @endphp
                <div class="card shadow-sm border-0 mb-3 question-card">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <strong>Soal <span class="question-number">{{ $index + 1 }}</span></strong>
                        <button type="button" class="btn btn-sm btn-outline-danger remove-question">Hapus soal</button>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Pertanyaan</label>
                            <textarea name="questions[{{ $index }}][question]" class="form-control" rows="3" required maxlength="2000">{{ $question['question'] ?? '' }}</textarea>
                        </div>
                        <div class="row">
                            @foreach(['A', 'B', 'C', 'D', 'E'] as $letter)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Opsi {{ $letter }} @if($letter === 'E')<small class="text-muted">(opsional)</small>@endif</label>
                                        <input type="text" name="questions[{{ $index }}][options][{{ $letter }}]" class="form-control" value="{{ $options[$letter] ?? '' }}" {{ $letter !== 'E' ? 'required' : '' }} maxlength="500">
                                    </div>
                                </div>
                            @endforeach
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Kunci jawaban</label>
                                    <select name="questions[{{ $index }}][answer]" class="form-control answer-select" required>
                                        @foreach(['A', 'B', 'C', 'D', 'E'] as $letter)
                                            <option value="{{ $letter }}" {{ $selectedAnswer === $letter ? 'selected' : '' }}>{{ $letter }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <button class="btn btn-primary btn-block mb-4" type="submit">Simpan Exam</button>
    </form>
</div>

<button type="button" class="btn btn-primary floating-add-question" id="addQuestion" title="Tambah soal">
    <i class="bx bx-plus mr-sm-1"></i><span>Tambah soal</span>
</button>
@endsection

@section('custom-js')
@if(session()->has('success'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (window.Swal && typeof window.Swal.fire === 'function') {
            window.Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: @json(session('success')),
                timer: 1800,
                showConfirmButton: false,
                toast: true,
                position: 'top-end'
            });
        }
    });
</script>
@endif
<script>
    (function () {
        var list = document.getElementById('questionList');
        var addButton = document.getElementById('addQuestion');
        var nextIndex = {{ $nextQuestionIndex }};

        function questionTemplate(index) {
            return '<div class="card shadow-sm border-0 mb-3 question-card">'
                + '<div class="card-header bg-white d-flex justify-content-between align-items-center"><strong>Soal <span class="question-number"></span></strong><button type="button" class="btn btn-sm btn-outline-danger remove-question">Hapus soal</button></div>'
                + '<div class="card-body"><div class="form-group"><label>Pertanyaan</label><textarea name="questions[' + index + '][question]" class="form-control" rows="3" required maxlength="2000"></textarea></div>'
                + '<div class="row">'
                + ['A', 'B', 'C', 'D'].map(function (letter) { return '<div class="col-md-6"><div class="form-group"><label>Opsi ' + letter + '</label><input type="text" name="questions[' + index + '][options][' + letter + ']" class="form-control" required maxlength="500"></div></div>'; }).join('')
                + '<div class="col-md-6"><div class="form-group"><label>Opsi E <small class="text-muted">(opsional)</small></label><input type="text" name="questions[' + index + '][options][E]" class="form-control" maxlength="500"></div></div>'
                + '<div class="col-md-6"><div class="form-group"><label>Kunci jawaban</label><select name="questions[' + index + '][answer]" class="form-control answer-select" required><option>A</option><option>B</option><option>C</option><option>D</option><option>E</option></select></div></div>'
                + '</div></div></div>';
        }

        function refreshNumbers() {
            Array.prototype.forEach.call(list.querySelectorAll('.question-card'), function (card, index) {
                card.querySelector('.question-number').textContent = index + 1;
            });
        }

        addButton.addEventListener('click', function () {
            list.insertAdjacentHTML('beforeend', questionTemplate(nextIndex++));
            refreshNumbers();
            var cards = list.querySelectorAll('.question-card');
            cards[cards.length - 1].scrollIntoView({ behavior: 'smooth', block: 'center' });
            cards[cards.length - 1].querySelector('textarea').focus();
        });

        list.addEventListener('click', function (event) {
            if (!event.target.classList.contains('remove-question')) return;
            var cards = list.querySelectorAll('.question-card');
            if (cards.length === 1) {
                alert('Minimal harus ada satu soal.');
                return;
            }
            event.target.closest('.question-card').remove();
            refreshNumbers();
        });

        refreshNumbers();
    }());
</script>
@endsection
