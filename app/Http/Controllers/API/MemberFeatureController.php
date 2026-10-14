<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ClassesModel;
use App\Models\DataPayment;
use App\Models\BonusAplikasiModel;
use App\Models\SopModel;
use App\Models\UserProfileModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MemberFeatureController extends Controller
{
    public function dashboard(Request $request): JsonResponse
    {
        $user = $request->user();
        $profile = UserProfileModel::where('user_id', $user->id)->first();
        $payments = DataPayment::query()->where('user_id', $user->id);

        return response()->json([
            'success' => true,
            'message' => 'Dashboard member berhasil diambil.',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
                'membership' => [
                    'is_member' => (int) ($profile?->status_membership ?? 0) === DataPayment::STATUS_PAID,
                    'status' => (int) ($profile?->status_membership ?? 0),
                    'type' => $profile?->tipe_membership,
                    'active_until' => $profile?->masa_aktif_membership,
                    'joined_at' => $profile?->tanggal_bergabung_membership,
                ],
                'stats' => [
                    'paid_orders' => (clone $payments)->where('status', DataPayment::STATUS_PAID)->count(),
                    'pending_orders' => (clone $payments)->whereIn('status', [DataPayment::STATUS_PENDING, DataPayment::STATUS_WAITING_CONFIRMATION])->count(),
                    'class_orders' => (clone $payments)->where('pembelian', DataPayment::PURCHASE_CLASS)->where('status', DataPayment::STATUS_PAID)->count(),
                    'ebook_orders' => (clone $payments)->where('pembelian', DataPayment::PURCHASE_EBOOK)->where('status', DataPayment::STATUS_PAID)->count(),
                    'video_orders' => (clone $payments)->where('pembelian', DataPayment::PURCHASE_VIDEO)->where('status', DataPayment::STATUS_PAID)->count(),
                ],
            ],
        ]);
    }

    public function classes(Request $request): JsonResponse
    {
        $classIds = DataPayment::query()
            ->where('user_id', $request->user()->id)
            ->where('status', DataPayment::STATUS_PAID)
            ->whereNotNull('class_id')
            ->pluck('class_id')
            ->unique();

        $classes = ClassesModel::query()
            ->whereIn('id', $classIds)
            ->where('status', 1)
            ->orderByDesc('date_end')
            ->get()
            ->map(fn (ClassesModel $class): array => [
                'id' => $class->id,
                'title' => $class->title,
                'description' => $class->description,
                'date_start' => $class->date_start,
                'date_end' => $class->date_end,
                'category' => $class->category,
                'iht' => (bool) $class->iht,
            ])
            ->values();

        return response()->json([
            'success' => true,
            'message' => 'Pembelajaran member berhasil diambil.',
            'data' => $classes,
        ]);
    }

    public function certificates(Request $request): JsonResponse
    {
        $classes = DataPayment::query()
            ->with('paymentClass')
            ->where('user_id', $request->user()->id)
            ->where('status', DataPayment::STATUS_PAID)
            ->whereNotNull('class_id')
            ->latest('id')
            ->get()
            ->unique('class_id')
            ->map(fn (DataPayment $payment): array => [
                'class_id' => $payment->class_id,
                'class_name' => $payment->paymentClass?->title ?? 'Kelas',
                'certificate_available' => false,
                'status' => 'Menunggu verifikasi sertifikat',
            ])
            ->values();

        return response()->json([
            'success' => true,
            'message' => 'Sertifikat member berhasil diambil.',
            'data' => $classes,
        ]);
    }

    public function sop(Request $request): JsonResponse
    {
        $sops = SopModel::query()
            ->select(['id', 'judul', 'deskripsi', 'banner', 'status', 'updated_at'])
            ->with('dokumenFiles:id,sop_id,nama_file,link_google_drive,path')
            ->withCount('dokumenFiles')
            ->orderByDesc('updated_at')
            ->orderByDesc('id')
            ->get()
            ->map(fn (SopModel $sop): array => [
                'id' => $sop->id,
                'title' => $sop->judul,
                'description' => $sop->deskripsi,
                'banner' => $sop->banner,
                'status' => $sop->status,
                'document_count' => $sop->dokumen_files_count,
                'documents' => $sop->dokumenFiles->map(fn ($document): array => [
                    'id' => $document->id,
                    'name' => $document->nama_file,
                    'url' => $document->link_google_drive,
                    'path' => $document->path,
                ])->values(),
            ])
            ->values();

        return response()->json([
            'success' => true,
            'message' => 'Dokumen SOP berhasil diambil.',
            'data' => $sops,
        ]);
    }

    public function bonusApplications(): JsonResponse
    {
        $bonuses = BonusAplikasiModel::query()
            ->select(['id', 'nama', 'deskripsi', 'status', 'tipe_sumber', 'url', 'file_name', 'thumbnail_path', 'created_at'])
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->get()
            ->map(fn (BonusAplikasiModel $bonus): array => [
                'id' => $bonus->id,
                'name' => $bonus->nama,
                'description' => $bonus->deskripsi,
                'status' => $bonus->status,
                'source_type' => $bonus->tipe_sumber,
                'url' => $bonus->url,
                'file_name' => $bonus->file_name,
                'thumbnail' => $bonus->thumbnail_path,
            ])
            ->values();

        return response()->json([
            'success' => true,
            'message' => 'Bonus aplikasi berhasil diambil.',
            'data' => $bonuses,
        ]);
    }
}
