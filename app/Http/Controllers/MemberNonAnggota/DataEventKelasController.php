<?php

namespace App\Http\Controllers\MemberNonAnggota;

use App\Http\Controllers\Controller;
use App\Models\ClassPaymentModel;
use App\Models\ClassesModel;
use App\Models\DataPayment;
use App\Models\InstructorModel;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DataEventKelasController extends Controller
{
    public function dataeventkelas(Request $request)
    {
        $filters = [
            'q' => trim((string) $request->query('q')),
            'level' => $request->query('level'),
            'category' => $this->arrayFilter($request->query('category')),
            'instructor' => $this->arrayFilter($request->query('instructor')),
            'jenis' => $this->arrayFilter($request->query('jenis')),
            'kategori' => $this->arrayFilter($request->query('kategori'), ['0', '1']),
            'iht' => $this->arrayFilter($request->query('iht'), ['0', '1']),
        ];

        $classes = $this->activeClassesQuery()
            ->when($filters['q'] !== '', fn($query) => $this->applySearch($query, $filters['q']))
            ->when(in_array((string) $filters['level'], ['1', '2', '3'], true), fn($query) => $query->where('level', $filters['level']))
            ->when($filters['category'] !== [], fn($query) => $query->whereIn('category', $filters['category']))
            ->when($filters['jenis'] !== [], fn($query) => $this->applyJsonArrayFilter($query, 'jenis', $filters['jenis']))
            ->when($filters['kategori'] !== [], fn($query) => $query->whereIn('kategori', $filters['kategori']))
            ->when($filters['iht'] !== [], fn($query) => $this->applyIhtFilter($query, $filters['iht']))
            ->when($filters['instructor'] !== [], fn($query) => $this->applyInstructorFilter($query, $filters['instructor']))
            ->tap(fn($query) => $this->applyListOrdering($query))
            ->paginate(9)
            ->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('membernonkeanggotaan.components.ui.course-card-items', [
                    'classes' => $classes,
                    'withoutStyle' => true,
                ])->render(),
                'next_page_url' => $classes->nextPageUrl(),
                'has_more_pages' => $classes->hasMorePages(),
            ]);
        }

        return view('membernonkeanggotaan.pages.event.listevent', [
            'classes' => $classes,
            'filters' => $filters,
            'filterOptions' => $this->filterOptions(),
        ]);
    }

    private function activeClassesQuery()
    {
        return ClassesModel::query()
            ->where('status', 1)
            ->where(function ($query) {
                $query->whereYear('date_start', now()->year)
                    ->orWhere(function ($subQuery) {
                        $subQuery->where('iht', 1)
                            ->whereNull('date_start')
                            ->whereNull('date_end');
                    });
            });
    }

    private function applyIhtFilter($query, array $values): void
    {
        if (in_array('0', $values, true) && in_array('1', $values, true)) {
            return;
        }

        if (in_array('1', $values, true)) {
            $query->where('iht', 1);

            return;
        }

        $query->where(function ($subQuery) {
            $subQuery->where('iht', 0)
                ->orWhereNull('iht');
        });
    }

    private function applyListOrdering($query): void
    {
        $query
            ->orderByRaw('CASE WHEN iht = 1 AND date_start IS NULL AND date_end IS NULL THEN 0 ELSE 1 END')
            ->orderByDesc('date_start');
    }

    private function applySearch($query, string $search): void
    {
        $query->where(function ($subQuery) use ($search) {
            $subQuery->where('title', 'like', "%{$search}%")
                ->orWhere('category', 'like', "%{$search}%")
                ->orWhere('jenis', 'like', "%{$search}%");
        });
    }

    private function applyInstructorFilter($query, array $instructorIds): void
    {
        $this->applyJsonArrayFilter($query, 'instructor', $instructorIds);
    }

    private function applyJsonArrayFilter($query, string $column, array $values): void
    {
        $query->where(function ($subQuery) use ($column, $values) {
            foreach ($values as $value) {
                $subQuery->orWhereJsonContains($column, (string) $value);

                if (is_numeric($value)) {
                    $subQuery->orWhereJsonContains($column, (int) $value);
                }
            }
        });
    }

    private function filterOptions(): array
    {
        $baseQuery = $this->activeClassesQuery();

        return [
            'category' => $this->distinctColumnOptions((clone $baseQuery), 'category'),
            'instructor' => $this->instructorOptions((clone $baseQuery)->pluck('instructor')),
            'jenis' => $this->jsonColumnOptions((clone $baseQuery)->pluck('jenis')),
            'kategori' => [
                '0' => 'Online',
                '1' => 'Offline',
            ],
            'iht' => [
                '0' => 'Non IHT',
                '1' => 'IHT',
            ],
        ];
    }

    private function jsonColumnOptions(Collection $values): array
    {
        return $values
            ->flatMap(function ($value) {
                $decoded = json_decode((string) $value, true);

                return is_array($decoded) ? $decoded : Arr::wrap($value);
            })
            ->filter(fn($value) => $value !== null && $value !== '')
            ->map(fn($value) => (string) $value)
            ->unique()
            ->sort()
            ->mapWithKeys(fn($value) => [$value => $this->formatOptionLabel($value)])
            ->all();
    }

    private function formatOptionLabel(string $value): string
    {
        return ucwords(strtolower(str_replace(['_', '-'], ' ', $value)));
    }

    private function distinctColumnOptions($query, string $column): array
    {
        return $query
            ->whereNotNull($column)
            ->where($column, '!=', '')
            ->distinct()
            ->orderBy($column)
            ->pluck($column)
            ->mapWithKeys(fn($value) => [(string) $value => (string) $value])
            ->all();
    }

    private function instructorOptions(Collection $instructorValues): array
    {
        $ids = $instructorValues
            ->flatMap(function ($value) {
                $decoded = json_decode((string) $value, true);

                return is_array($decoded) ? $decoded : [];
            })
            ->filter(fn($value) => $value !== null && $value !== '')
            ->map(fn($value) => (string) $value)
            ->unique()
            ->values();

        if ($ids->isEmpty()) {
            return [];
        }

        return InstructorModel::query()
            ->whereIn('id', $ids->all())
            ->orderBy('name')
            ->pluck('name', 'id')
            ->mapWithKeys(fn($name, $id) => [(string) $id => $name])
            ->all();
    }

    private function arrayFilter($value, array $allowedValues = []): array
    {
        $values = collect(Arr::wrap($value))
            ->filter(fn($item) => $item !== null && $item !== '')
            ->map(fn($item) => (string) $item)
            ->unique()
            ->values();

        if ($allowedValues !== []) {
            $values = $values->filter(fn($item) => in_array($item, $allowedValues, true))->values();
        }

        return $values->all();
    }

    public function detailevent($unique, $title)
    {
        $class = ClassesModel::query()
            ->where('status', 1)
            ->where('unique_id', $unique)
            ->firstOrFail();

        $relatedClasses = ClassesModel::query()
            ->where('status', 1)
            ->where('unique_id', '!=', $unique)
            ->when($class->category, fn($query) => $query->where('category', $class->category))
            ->orderByDesc('date_start')
            ->limit(3)
            ->get();

        return view('membernonkeanggotaan.pages.event.detailevent', [
            'class' => $class,
            'relatedClasses' => $relatedClasses,
        ]);
    }

    public function orderIht(Request $request, string $unique)
    {
        $class = ClassesModel::query()
            ->where('status', 1)
            ->where('iht', 1)
            ->where('unique_id', $unique)
            ->firstOrFail();

        $user = $request->user();

        $invoiceNumber = DB::transaction(function () use ($class, $user) {
            $existingPayment = DataPayment::query()
                ->where('user_id', $user->id)
                ->where('class_id', $class->id)
                ->where('is_iht', 1)
                ->where('tipe_pembelian', DataPayment::PURCHASE_TYPE_CLASS)
                ->whereIn('status', [DataPayment::STATUS_PAID, DataPayment::STATUS_PENDING])
                ->lockForUpdate()
                ->first();

            if ($existingPayment) {
                return $existingPayment->no_invoice;
            }

            $invoiceNumber = 'BANKIR-' . now()->format('YmdHisv') . '-' . random_int(1000, 9999);
            $classPrice = $this->classPrice($class->pricing);

            DataPayment::create([
                'no_invoice' => $invoiceNumber,
                'user_id' => $user->id,
                'class_id' => $class->id,
                'pembelian' => DataPayment::PURCHASE_CLASS,
                'nominal' => $classPrice,
                'expired' => 0,
                'qty' => 1,
                'status' => DataPayment::STATUS_PENDING,
                'keterangan' => 'pembelian kelas IHT',
                'link_payment' => null,
                'tipe_pembelian' => DataPayment::PURCHASE_TYPE_CLASS,
                'is_konfirmasi' => 0,
                'is_iht' => 1,
            ]);

            ClassPaymentModel::create([
                'status' => 0,
                'user_id' => $user->id,
                'class_id' => $class->id,
                'unique_code' => random_int(0, 999),
                'price' => $classPrice,
                'price_final' => $classPrice,
                'expired' => null,
                'no_invoice' => $invoiceNumber,
                'jumlah' => 1,
                'biaya_sertifikat' => 0,
            ]);

            return $invoiceNumber;
        });

        $message = rawurlencode(
            "Halo Tim Bankir Academy, saya ingin order kelas IHT {$class->title}. No invoice: {$invoiceNumber}"
        );

        return redirect()->away("https://wa.me/6289682019523?text={$message}");
    }

    private function classPrice($pricing): float
    {
        if (! $pricing) {
            return 0;
        }

        $price = (float) data_get($pricing, 'price', 0);

        if ((int) data_get($pricing, 'promo', 0) !== 1) {
            return $price;
        }

        return max(0, $price - (float) data_get($pricing, 'promo_price', 0));
    }
}
