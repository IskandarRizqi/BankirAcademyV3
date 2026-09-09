<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\LokerDraft;
use App\Models\ScraperIngestionControl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ScraperIngestionController extends Controller
{
    public function store(Request $request)
    {
        // Pastikan request berupa array dari objek/item
        $items = $request->isJson() ? $request->json()->all() : $request->all();

        // Jika data dikirim sebagai single object, bungkus menjadi array
        if (isset($items['source_type'])) {
            $items = [$items];
        }

        $validator = Validator::make($items, [
            '*.source_type'      => 'required|in:social_media,job_platform',
            '*.posisi'           => 'required|string',
            '*.nama_perusahaan'  => 'required|string',
            '*.sumber_url'       => 'nullable|url',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $createdIds = [];
        $skippedCount = 0;
        $blockedCount = 0;
        $currentYear = (int) date('Y');
        $jobPlatformEnabled = ScraperIngestionControl::isEnabled('job_platform');

        foreach ($items as $data) {
            if ($data['source_type'] === 'job_platform' && ! $jobPlatformEnabled) {
                $skippedCount++;
                $blockedCount++;
                continue;
            }

            // Normalisasi Tanggal Posting & Batas Pendaftaran
            if (!empty($data['tanggal_posting'])) {
                $data['tanggal_posting'] = date('Y-m-d H:i:s', strtotime($data['tanggal_posting']));
            }
            if (!empty($data['batas_pendaftaran'])) {
                $deadlineTime = strtotime($data['batas_pendaftaran']);
                $deadlineYear = (int) date('Y', $deadlineTime);

                // Lewati data jika batas pendaftaran bukan tahun ini
                if ($deadlineYear !== $currentYear) {
                    $skippedCount++;
                    continue;
                }

                $data['batas_pendaftaran'] = date('Y-m-d', $deadlineTime);
            }

            $draft = LokerDraft::create($data);
            $createdIds[] = $draft->id;
        }

        return response()->json([
            'success' => true,
            'message' => count($createdIds) . ' data draft loker berhasil disimpan.',
            'skipped_count' => $skippedCount,
            'blocked_count' => $blockedCount,
            'job_platform_enabled' => $jobPlatformEnabled,
            'draft_ids' => $createdIds
        ], count($createdIds) > 0 ? 201 : 200);
    }
}
