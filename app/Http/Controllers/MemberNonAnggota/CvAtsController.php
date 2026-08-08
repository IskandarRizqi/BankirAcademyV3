<?php

namespace App\Http\Controllers\MemberNonAnggota;

use App\Http\Controllers\Controller;
use App\Models\LamaranModel;
use App\Services\CvAtsPdfService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Throwable;

class CvAtsController extends Controller
{
    private const RELIGIONS = [
        'islam',
        'katholik',
        'protestan',
        'hindu',
        'budha',
        'tuhan yang maha esa',
    ];

    private const MARITAL_STATUSES = [
        'Belum Menikah',
        'Menikah',
        'Duda/Janda',
    ];

    public function index(Request $request)
    {
        $cv = $this->findCv($request);

        return view('membernonkeanggotaan.pages.cv-ats.index', [
            'cv' => $cv,
            'experiences' => $cv ? $this->experienceRows($cv) : [],
            'trainings' => $cv ? $this->trainingRows($cv) : [],
        ]);
    }

    public function create(Request $request)
    {
        if ($this->findCv($request)) {
            return redirect()->route('membernonanggota.cv-ats.index')
                ->with('info', 'CV ATS Anda sudah tersedia. Anda dapat memperbarui datanya.');
        }

        return view('membernonkeanggotaan.pages.cv-ats.form', [
            'cv' => new LamaranModel,
            'experiences' => [],
            'trainings' => [],
        ]);
    }

    public function store(Request $request)
    {
        // \Log::info('Request data: ', [
        //     json_encode($request->all()),
        // ]);

        // return $request->all();
        try {
            $this->validateCv($request);
        } catch (ValidationException $exception) {
            return back()
                ->withInput()
                ->withErrors($exception->errors())
                ->with('error', 'Data CV belum dapat disimpan. Periksa kembali isian Anda.');
        }

        try {
            if ($this->findCv($request)) {
                return redirect()->route('membernonanggota.cv-ats.index')
                    ->with('info', 'CV ATS hanya dapat dibuat satu kali. Silakan gunakan menu edit.');
            }

            DB::transaction(function () use ($request) {
                LamaranModel::create($this->cvPayload($request) + [
                    'user_id' => $request->user()->id,
                    'is_cv_ats' => true,
                    'status' => 0,
                    // These legacy columns are required by the existing table schema.
                    'namaorangtua' => '',
                    'jmlsaudara' => '',
                ]);
            });
        } catch (Throwable $exception) {
            report($exception);

            return back()->withInput()->with('error', 'CV ATS gagal disimpan. Silakan coba lagi.');
        }

        return redirect()->route('membernonanggota.cv-ats.index')
            ->with('success', 'CV ATS berhasil disimpan.');
    }

    public function edit(Request $request)
    {
        $cv = $this->findCv($request);

        abort_unless($cv, 404);

        return view('membernonkeanggotaan.pages.cv-ats.form', [
            'cv' => $cv,
            'experiences' => $this->experienceRows($cv),
            'trainings' => $this->trainingRows($cv),
        ]);
    }

    public function update(Request $request)
    {
        try {
            $this->validateCv($request);
        } catch (ValidationException $exception) {
            return back()
                ->withInput()
                ->withErrors($exception->errors())
                ->with('error', 'Perubahan CV belum dapat disimpan. Periksa kembali isian Anda.');
        }

        $cv = $this->findCv($request);

        abort_unless($cv, 404);

        try {
            $cv->update($this->cvPayload($request));
        } catch (Throwable $exception) {
            report($exception);

            return back()->withInput()->with('error', 'Perubahan CV gagal disimpan. Silakan coba lagi.');
        }

        return redirect()->route('membernonanggota.cv-ats.index')
            ->with('success', 'CV ATS berhasil diperbarui.');
    }

    public function pdf(Request $request, CvAtsPdfService $pdfService)
    {
        $cv = $this->findCv($request);

        abort_unless($cv, 404);

        $fileName = $pdfService->filename($cv);
        $pdf = $pdfService->make($cv, $request->user());

        return $pdf->stream($fileName);
    }

    private function findCv(Request $request): ?LamaranModel
    {
        return LamaranModel::where('user_id', $request->user()->id)
            ->where('is_cv_ats', true)
            ->first();
    }

    private function validateCv(Request $request): void
    {
        $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'nama_panggilan' => ['required', 'string', 'max:100'],
            'tmpttgllahir' => [
                'required',
                'string',
                'max:100',
                'regex:/^[\p{L}][\p{L}\s.\'-]*,\s\d{1,2}\s(januari|februari|maret|april|mei|juni|juli|agustus|september|oktober|november|desember)\s\d{4}$/iu',
            ],
            'agama' => ['required', 'in:' . implode(',', self::RELIGIONS)],
            'telpdomisili' => ['required', 'string', 'max:30', 'regex:/^[0-9]+$/'],
            'statusperkawinan' => ['required', 'in:' . implode(',', self::MARITAL_STATUSES)],
            'kodepos' => ['required', 'digits:5'],
            'alamatdomisili' => ['required', 'string', 'max:1000'],
            'pengalamanspesifik' => ['required', 'string', 'max:2000'],
            'perguruannama' => ['nullable', 'string', 'max:255', 'required_with:perguruanfakultas,perguruangelar,perguruantahun'],
            'perguruanfakultas' => ['nullable', 'string', 'max:255', 'required_with:perguruannama'],
            'perguruangelar' => ['nullable', 'string', 'max:100', 'required_with:perguruannama'],
            'perguruantahun' => ['nullable', 'string', 'max:30', 'required_with:perguruannama'],
            'smanama' => ['nullable', 'string', 'max:255', 'required_with:smafakultas,smatahun'],
            'smafakultas' => ['nullable', 'string', 'max:255', 'required_with:smanama'],
            'smatahun' => ['nullable', 'string', 'max:30', 'required_with:smanama'],
            'experiences' => ['nullable', 'array', 'max:20'],
            'experiences.*.company' => ['required', 'string', 'max:255'],
            'experiences.*.position' => ['required', 'string', 'max:255'],
            'experiences.*.period' => ['required', 'string', 'max:100'],
            'experiences.*.responsibility' => ['required', 'string', 'max:5000'],
            'trainings' => ['nullable', 'array', 'max:20'],
            'trainings.*.name' => ['required', 'string', 'max:255'],
            'trainings.*.organizer' => ['required', 'string', 'max:255'],
            'trainings.*.year' => ['required', 'string', 'max:30'],
        ], [
            'required' => ':attribute wajib diisi.',
            'string' => ':attribute harus berupa teks.',
            'max.string' => ':attribute maksimal :max karakter.',
            'max.array' => ':attribute maksimal :max item.',
            'array' => ':attribute tidak valid.',
            'in' => ':attribute yang dipilih tidak valid.',
            'digits' => ':attribute harus terdiri dari :digits angka.',
            'required_with' => ':attribute wajib diisi jika data pendidikan lainnya diisi.',
            'tmpttgllahir.regex' => 'Gunakan format seperti: Jakarta, 24 november 2007.',
            'telpdomisili.regex' => 'No. Telepon / WhatsApp hanya boleh berisi angka.',
            'kodepos.digits' => 'Kode pos harus terdiri dari 5 angka.',
        ], [
            'nama_lengkap' => 'Nama lengkap',
            'nama_panggilan' => 'Nama panggilan',
            'tmpttgllahir' => 'Tempat, tanggal lahir',
            'agama' => 'Agama',
            'telpdomisili' => 'No. Telepon / WhatsApp',
            'statusperkawinan' => 'Status perkawinan',
            'kodepos' => 'Kode pos',
            'alamatdomisili' => 'Alamat domisili',
            'pengalamanspesifik' => 'Ringkasan profil / keahlian',
            'perguruannama' => 'Nama universitas',
            'perguruanfakultas' => 'Fakultas / program studi',
            'perguruangelar' => 'Gelar perguruan tinggi',
            'perguruantahun' => 'Tahun perguruan tinggi',
            'smanama' => 'Nama sekolah',
            'smafakultas' => 'Jurusan',
            'smatahun' => 'Tahun SMA / SMK',
            'experiences.*.company' => 'Nama perusahaan',
            'experiences.*.position' => 'Jabatan / posisi',
            'experiences.*.period' => 'Tahun / periode pengalaman kerja',
            'experiences.*.responsibility' => 'Tanggung jawab utama',
            'trainings.*.name' => 'Nama pelatihan',
            'trainings.*.organizer' => 'Penyelenggara pelatihan',
            'trainings.*.year' => 'Tahun pelatihan',
        ]);
    }

    private function cvPayload(Request $request): array
    {
        return [
            'nama_lengkap' => trim($request->input('nama_lengkap')),
            'nama_panggilan' => trim($request->input('nama_panggilan')),
            'tmpttgllahir' => trim($request->input('tmpttgllahir')),
            'agama' => $request->input('agama'),
            'telpdomisili' => trim($request->input('telpdomisili')),
            'statusperkawinan' => $request->input('statusperkawinan'),
            'kodepos' => trim($request->input('kodepos')),
            'alamatdomisili' => trim($request->input('alamatdomisili')),
            'pengalamanspesifik' => trim($request->input('pengalamanspesifik')),
            'perguruannama' => $this->nullableTrim($request->input('perguruannama')),
            'perguruanfakultas' => $this->nullableTrim($request->input('perguruanfakultas')),
            'perguruangelar' => $this->nullableTrim($request->input('perguruangelar')),
            'perguruantahun' => $this->nullableTrim($request->input('perguruantahun')),
            'smanama' => $this->nullableTrim($request->input('smanama')),
            'smafakultas' => $this->nullableTrim($request->input('smafakultas')),
            'smatahun' => $this->nullableTrim($request->input('smatahun')),
            'pekerjaanperusahaan' => $this->encodeRows($request->input('experiences', []), 'company'),
            'pekerjaanjabatan' => $this->encodeRows($request->input('experiences', []), 'position'),
            'pekerjaantahun' => $this->encodeRows($request->input('experiences', []), 'period'),
            'pekerjaantanggungjawab' => $this->encodeRows($request->input('experiences', []), 'responsibility'),
            'pelatihannama' => $this->encodeRows($request->input('trainings', []), 'name'),
            'pelatihanpenyelanggara' => $this->encodeRows($request->input('trainings', []), 'organizer'),
            'pelatihantahun' => $this->encodeRows($request->input('trainings', []), 'year'),
        ];
    }

    private function encodeRows($rows, string $key): string
    {
        $values = [];

        foreach (is_array($rows) ? $rows : [] as $row) {
            $values[] = trim((string) data_get($row, $key, ''));
        }

        return json_encode($values, JSON_UNESCAPED_UNICODE);
    }

    private function experienceRows(LamaranModel $cv): array
    {
        $companies = $this->decodeList($cv->pekerjaanperusahaan);
        $positions = $this->decodeList($cv->pekerjaanjabatan);
        $periods = $this->decodeList($cv->pekerjaantahun);
        $responsibilities = $this->decodeList($cv->pekerjaantanggungjawab, ';');
        $count = max(count($companies), count($positions), count($periods), count($responsibilities));

        return $this->rows($count, function ($index) use ($companies, $positions, $periods, $responsibilities) {
            return [
                'company' => $companies[$index] ?? '',
                'position' => $positions[$index] ?? '',
                'period' => $periods[$index] ?? '',
                'responsibility' => $responsibilities[$index] ?? '',
            ];
        });
    }

    private function trainingRows(LamaranModel $cv): array
    {
        $names = $this->decodeList($cv->pelatihannama);
        $organizers = $this->decodeList($cv->pelatihanpenyelanggara);
        $years = $this->decodeList($cv->pelatihantahun);
        $count = max(count($names), count($organizers), count($years));

        return $this->rows($count, function ($index) use ($names, $organizers, $years) {
            return [
                'name' => $names[$index] ?? '',
                'organizer' => $organizers[$index] ?? '',
                'year' => $years[$index] ?? '',
            ];
        });
    }

    private function rows(int $count, callable $callback): array
    {
        return $count > 0 ? array_map($callback, range(0, $count - 1)) : [];
    }

    private function decodeList($value, string $separator = ','): array
    {
        if (is_array($value)) {
            return array_values($value);
        }

        $value = (string) $value;
        $decoded = json_decode($value, true);

        if (is_array($decoded)) {
            return array_values($decoded);
        }

        return $value === '' ? [] : array_map('trim', explode($separator, $value));
    }

    private function nullableTrim($value): ?string
    {
        $value = trim((string) $value);

        return $value === '' ? null : $value;
    }
}
