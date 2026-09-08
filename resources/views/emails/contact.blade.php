<h2>Pesan Baru dari Form Kontak Bankir Academy</h2>
<p><strong>Nama:</strong> {{ $data['nama'] }}</p>
<p><strong>Institusi:</strong> {{ $data['institusi'] ?? '-' }}</p>
<p><strong>Email:</strong> {{ $data['email'] }}</p>
<p><strong>WhatsApp:</strong> {{ $data['telepon'] }}</p>
<p><strong>Kategori:</strong> {{ $data['kategori'] }}</p>
<p><strong>Subjek:</strong> {{ $data['subjek'] }}</p>
<p><strong>Pesan:</strong></p>
<p>{!! nl2br(e($data['pesan'])) !!}</p>
