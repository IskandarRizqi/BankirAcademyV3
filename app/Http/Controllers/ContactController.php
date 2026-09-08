<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $validated = $request->validate([
            'nama'     => 'required|string|max:255',
            'institusi' => 'nullable|string|max:255',
            'email'    => 'required|email',
            'telepon'  => 'required|string|max:20',
            'kategori' => 'required|string',
            'subjek'   => 'required|string|max:255',
            'pesan'    => 'required|string',
            'consent'  => 'accepted',
        ]);

        // Kirim email ke alamat tujuan resmi
        Mail::to('info@bankiracademy.co.id')->send(new ContactFormMail($validated));

        return back()->with('success', 'Pesan Anda berhasil dikirim!.');
    }
}
