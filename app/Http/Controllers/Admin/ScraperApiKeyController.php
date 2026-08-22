<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ScraperApiKey;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ScraperApiKeyController extends Controller
{
    public function index()
    {
        $apiKeys = ScraperApiKey::latest()->paginate(10);
        return view('docs.api-loker', compact('apiKeys'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Generate plain text key (hanya ditampilkan 1x saat sukses)
        $plainTextKey = 'scr_live_' . Str::random(32);

        // Hash SHA-256 untuk disimpan ke Database
        $keyHash = hash('sha256', $plainTextKey);
        $keyPrefix = substr($plainTextKey, 0, 12) . '...';

        ScraperApiKey::create([
            'name'       => $request->name,
            'key_hash'   => $keyHash,
            'key_prefix' => $keyPrefix,
            'is_active'  => true,
        ]);

        // Kirim plainTextKey lewat flash session agar bisa dicopy admin
        return redirect()->back()->with([
            'success' => 'API Key berhasil dibuat!',
            'new_api_key' => $plainTextKey
        ]);
    }

    public function toggleStatus(ScraperApiKey $apiKey)
    {
        $apiKey->update([
            'is_active' => !$apiKey->is_active
        ]);

        $status = $apiKey->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->back()->with('success', "API Key '{$apiKey->name}' berhasil {$status}.");
    }

    public function destroy(ScraperApiKey $apiKey)
    {
        $apiKey->delete();
        return redirect()->back()->with('success', 'API Key berhasil dihapus.');
    }
}
