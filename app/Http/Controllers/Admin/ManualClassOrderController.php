<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassesModel;
use App\Models\ClassParticipantModel;
use App\Models\ClassPaymentModel;
use App\Models\DataPayment;
use App\Models\SertifikatPesertaModel;
use App\Models\User;
use App\Services\ClassPricingService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManualClassOrderController extends Controller
{
    public function index()
    {
        return view('backend.manual-class-orders.index', [
            'orders' => $this->manualOrdersQuery()->get(),
            'classes' => $this->eligibleClassesQuery()->orderBy('title')->get(),
            'users' => $this->eligibleUsersQuery()->orderBy('name')->get(['id', 'name', 'email']),
            'order' => null,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateOrder($request);
        $class = $this->findEligibleClass((int) $validated['class_id']);
        $user = $this->findEligibleUser((int) $validated['user_id']);

        DB::transaction(function () use ($validated, $class, $user) {
            $invoiceNumber = $this->generateInvoiceNumber();
            $classPayment = $this->createClassPayment($validated, $class, $user, $invoiceNumber);

            DataPayment::create([
                'no_invoice' => $invoiceNumber,
                'user_id' => $user->id,
                'class_id' => $class->id,
                'pembelian' => DataPayment::PURCHASE_CLASS,
                'nominal' => (float) $validated['nominal'],
                'qty' => 0,
                'status' => DataPayment::STATUS_PAID,
                'keterangan' => 'Order kelas IHT',
                'tipe_pembelian' => DataPayment::PURCHASE_TYPE_CLASS,
                'is_konfirmasi' => 1,
                'is_iht' => 1,
                'link_payment' => null,
                'expired' => 0,
            ]);

            $this->createParticipant($classPayment, $class, $user);
        });

        return redirect()
            ->route('admin.manual-class-orders.index')
            ->with('manual_order_success', 'Order kelas manual berhasil disimpan.');
    }

    public function edit(int $id)
    {
        $order = $this->manualOrdersQuery()->whereKey($id)->firstOrFail();
        $classes = $this->eligibleClassesQuery()->orderBy('title')->get();

        if (! $classes->contains('id', $order->class_id)) {
            $classes->push($order->class);
            $classes = $classes->sortBy('title')->values();
        }

        return view('backend.manual-class-orders.index', [
            'orders' => $this->manualOrdersQuery()->get(),
            'classes' => $classes,
            'users' => $this->eligibleUsersQuery()->orderBy('name')->get(['id', 'name', 'email']),
            'order' => $order,
        ]);
    }

    public function update(Request $request, int $id)
    {
        $order = $this->manualOrdersQuery()->whereKey($id)->firstOrFail();
        $validated = $this->validateOrder($request);
        $class = $this->findEligibleClass((int) $validated['class_id'], (int) $order->class_id);
        $user = $this->findEligibleUser((int) $validated['user_id']);
        $pricingSnapshot = $this->pricingSnapshot($class, $user, (float) $validated['nominal']);

        DB::transaction(function () use ($validated, $order, $class, $user, $pricingSnapshot) {
            $order->update([
                'status' => 1,
                'user_id' => $user->id,
                'class_id' => $class->id,
                'price' => (float) $validated['nominal'],
                'price_final' => (float) $validated['nominal'],
                'additional_discount' => json_encode($pricingSnapshot),
                'jumlah' => 0,
                'biaya_sertifikat' => 0,
            ]);

            $dataPayment = $order->dataPayment;
            if ($dataPayment) {
                $dataPayment->update([
                    'user_id' => $user->id,
                    'class_id' => $class->id,
                    'pembelian' => DataPayment::PURCHASE_CLASS,
                    'nominal' => (float) $validated['nominal'],
                    'qty' => 0,
                    'status' => DataPayment::STATUS_PAID,
                    'keterangan' => 'Order kelas IHT',
                    'tipe_pembelian' => DataPayment::PURCHASE_TYPE_CLASS,
                    'is_konfirmasi' => 1,
                    'is_iht' => 1,
                    'link_payment' => null,
                    'expired' => 0,
                ]);
            } else {
                DataPayment::create([
                    'no_invoice' => $order->no_invoice,
                    'user_id' => $user->id,
                    'class_id' => $class->id,
                    'pembelian' => DataPayment::PURCHASE_CLASS,
                    'nominal' => (float) $validated['nominal'],
                    'qty' => 0,
                    'status' => DataPayment::STATUS_PAID,
                    'keterangan' => 'Order kelas IHT',
                    'tipe_pembelian' => DataPayment::PURCHASE_TYPE_CLASS,
                    'is_konfirmasi' => 1,
                    'is_iht' => 1,
                    'link_payment' => null,
                    'expired' => 0,
                ]);
            }

            ClassParticipantModel::updateOrCreate(
                ['payment_id' => $order->id],
                [
                    'class_id' => $class->id,
                    'user_id' => $user->id,
                    'certificate' => 1,
                    'jumlah' => 0,
                ]
            );
        });

        return redirect()
            ->route('admin.manual-class-orders.index')
            ->with('manual_order_success', 'Order kelas manual berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        $order = $this->manualOrdersQuery()->whereKey($id)->firstOrFail();

        DB::transaction(function () use ($order) {
            ClassParticipantModel::where('payment_id', $order->id)->delete();
            SertifikatPesertaModel::where('payment_class_id', $order->id)->delete();

            if ($order->dataPayment) {
                $order->dataPayment->delete();
            }

            $order->delete();
        });

        return redirect()
            ->route('admin.manual-class-orders.index')
            ->with('manual_order_success', 'Order kelas manual berhasil dihapus.');
    }

    private function manualOrdersQuery()
    {
        return ClassPaymentModel::query()
            ->whereHas('dataPayment', function ($query) {
                $query->where('status', DataPayment::STATUS_PAID)
                    ->where('is_iht', 1)
                    ->where('tipe_pembelian', DataPayment::PURCHASE_TYPE_CLASS);
            })
            ->with(['class', 'user', 'dataPayment', 'participant'])
            ->latest('id');
    }

    private function eligibleClassesQuery()
    {
        return ClassesModel::query()
            ->where('iht', 1)
            ->where('status', 1)
            ->where(function ($query) {
                $query->whereNull('date_start')
                    ->orWhereDate('date_start', '<=', Carbon::today());
            })
            ->where(function ($query) {
                $query->whereNull('date_end')
                    ->orWhereDate('date_end', '>=', Carbon::today());
            });
    }

    private function eligibleUsersQuery()
    {
        return User::query()->where('role', 2);
    }

    private function validateOrder(Request $request): array
    {
        $request->merge([
            'nominal' => $this->normalizeRupiah($request->input('nominal')),
        ]);

        return $request->validate([
            'class_id' => ['required', 'integer'],
            'user_id' => ['required', 'integer'],
            'nominal' => ['required', 'numeric', 'min:0'],
        ], [
            'class_id.required' => 'Kelas wajib dipilih.',
            'user_id.required' => 'User wajib dipilih.',
            'nominal.numeric' => 'Nominal harus berupa angka.',
            'nominal.min' => 'Nominal tidak boleh kurang dari 0.',
        ]);
    }

    private function normalizeRupiah($value): string
    {
        return preg_replace('/\D+/', '', (string) $value) ?? '';
    }

    private function findEligibleClass(int $classId, ?int $currentClassId = null): ClassesModel
    {
        $class = $this->eligibleClassesQuery()->find($classId);
        if (! $class && $currentClassId !== $classId) {
            abort(422, 'Kelas harus berstatus IHT dan masih aktif.');
        }

        return $class ?: ClassesModel::findOrFail($classId);
    }

    private function findEligibleUser(int $userId): User
    {
        return $this->eligibleUsersQuery()->findOrFail($userId);
    }

    private function createClassPayment(array $validated, ClassesModel $class, User $user, string $invoiceNumber): ClassPaymentModel
    {
        $pricingSnapshot = $this->pricingSnapshot($class, $user, (float) $validated['nominal']);

        return ClassPaymentModel::create([
            'status' => 1,
            'user_id' => $user->id,
            'class_id' => $class->id,
            'unique_code' => $this->generateUniqueCode(),
            'price' => (float) $validated['nominal'],
            'price_final' => (float) $validated['nominal'],
            'additional_discount' => json_encode($pricingSnapshot),
            'expired' => null,
            'no_invoice' => $invoiceNumber,
            'jumlah' => 0,
            'biaya_sertifikat' => 0,
        ]);
    }

    private function pricingSnapshot(ClassesModel $class, User $user, float $nominal): array
    {
        $pricing = app(ClassPricingService::class)->resolve($class, $user);

        return [
            'base_price' => $pricing['base_price'],
            'general_discount' => $pricing['general_discount'],
            'membership_discount' => $pricing['membership_discount'],
            'total_discount' => $pricing['total_discount'],
            'discount_percent' => $pricing['discount_percent'],
            'membership_type' => $pricing['membership_type'],
            'discount_source' => $pricing['discount_source'],
            'manual_nominal' => $nominal,
        ];
    }

    private function createParticipant(ClassPaymentModel $classPayment, ClassesModel $class, User $user): ClassParticipantModel
    {
        return ClassParticipantModel::create([
            'class_id' => $class->id,
            'user_id' => $user->id,
            'payment_id' => $classPayment->id,
            'certificate' => 1,
            'jumlah' => 0,
        ]);
    }

    private function generateInvoiceNumber(): string
    {
        do {
            $invoiceNumber = 'BANKIR-'.now()->format('YmdHisv').'-'.random_int(1000, 9999);
        } while (
            DataPayment::query()->where('no_invoice', $invoiceNumber)->exists()
            || ClassPaymentModel::query()->where('no_invoice', $invoiceNumber)->exists()
        );

        return $invoiceNumber;
    }

    private function generateUniqueCode(): int
    {
        do {
            $uniqueCode = random_int(0, 999);
        } while (ClassPaymentModel::query()->where('unique_code', $uniqueCode)->exists());

        return $uniqueCode;
    }
}
