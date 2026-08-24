<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\LokerDraft;
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

        foreach ($items as $data) {
            // Normalisasi Tanggal Posting & Batas Pendaftaran
            if (!empty($data['tanggal_posting'])) {
                $data['tanggal_posting'] = date('Y-m-d H:i:s', strtotime($data['tanggal_posting']));
            }
            if (!empty($data['batas_pendaftaran'])) {
                $data['batas_pendaftaran'] = date('Y-m-d', strtotime($data['batas_pendaftaran']));
            }

            $draft = LokerDraft::create($data);
            $createdIds[] = $draft->id;
        }

        return response()->json([
            'success' => true,
            'message' => count($createdIds) . ' data draft loker berhasil disimpan.',
            'draft_ids' => $createdIds
        ], 201);
    }
}
