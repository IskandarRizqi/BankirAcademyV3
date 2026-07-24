@extends('layouts.compact')
@section('content')
<div class="row" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-top-spacing layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <div class="d-flex justify-content-between align-items-center px-4 pt-3">
                <h5 style="font-weight: bold;">Manajemen Template Sertifikat</h5>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#certModal" onclick="resetForm()">
                    Tambah Template
                </button>
            </div>
            <hr>

            <table id="cert-list" class="table table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tipe Target</th>
                        <th>Nama Kompetensi / Sub Materi</th>
                        <th>Ukuran Font Nama</th>
                        <th>Koordinat Nama (X, Y)</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $key => $x)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>
                            <span class="badge {{ $x->target_type == 'materi' ? 'badge-info' : 'badge-success' }}">
                                {{ strtoupper($x->target_type) }}
                            </span>
                        </td>
                        <td>
                            <p class="align-self-center mb-0" style="font-weight: 600;">
                                {{ $x->target_type == 'materi' ? $x->materi->nama : $x->subMateri->nama }}
                            </p>
                        </td>
                        <td>{{ $x->font_size }} px</td>
                        <td>X: {{ $x->coordinate_x }}, Y: {{ $x->coordinate_y }}</td>
                        <td>
                            <div class="dropdown">
                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink{{ $x->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gear" viewBox="0 0 16 16"><path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492M5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0"/><path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115z"/></svg>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink{{ $x->id }}">
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="editCert({{ json_encode($x) }})">Edit</a>
                                    <form action="/certificate-templates/{{$x->id}}" method="POST" onsubmit="return confirm('Hapus template ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger" style="border: none; background: none; width: 100%;">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center">Belum ada template terupload.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="certModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content" style="background: #fff; border-radius: 8px;">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel" style="font-weight: bold;">Tambah / Edit Template Sertifikat</h5>
            </div>
            <form id="certForm" action="/certificate-templates" enctype="multipart/form-data" method="POST">
                @csrf
                <input type="hidden" name="id" id="id">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label style="font-weight: 600;">Skema Target Penerbitan</label>
                        <select name="target_type" id="target_type" class="form-control" onchange="toggleTargetFields()" required>
                            <option value="materi">Per Kompetensi / Materi (Non-Umum)</option>
                            <option value="sub_materi">Per Sub Materi (Khusus Materi Umum)</option>
                        </select>
                    </div>

                    <div class="form-group mb-3" id="wrapper_materi">
                        <label style="font-weight: 600;">Pilih Kompetensi / Materi</label>
                        <select name="materi_id" id="materi_id" class="form-control">
                            <option value="">-- Pilih --</option>
                            @foreach($materi_non_umum as $m)
                                <option value="{{$m->id}}">{{$m->nama}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3" id="wrapper_sub_materi" style="display:none;">
                        <label style="font-weight: 600;">Pilih Sub Materi Umum</label>
                        <select name="sub_materi_id" id="sub_materi_id" class="form-control">
                            <option value="">-- Pilih --</option>
                            @foreach($sub_materi_umum as $sm)
                                <option value="{{$sm->id}}">{{$sm->nama}} (Materi: {{$sm->materi->nama}})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row">
                        <!-- Pengaturan Nomor Sertifikat -->
                        <div class="col-md-6">
                            <div class="card p-3 mb-3 bg-light">
                                <h6><strong>1. Nomor Seri Sertifikat</strong></h6>
                                <div class="form-group mb-2">
                                    <label>Koordinat Y (Posisi No. Seri)</label>
                                    <input type="number" name="serial_y" id="serial_y" class="form-control" value="330" required>
                                </div>
                                <div class="form-group mb-0">
                                    <label>Ukuran Font No. Seri (px)</label>
                                    <input type="number" name="serial_font_size" id="serial_font_size" class="form-control" value="18" required>
                                </div>
                            </div>
                        </div>

                        <!-- Pengaturan Teks "Diberikan Kepada" -->
                        <div class="col-md-6">
                            <div class="card p-3 mb-3 bg-light">
                                <h6><strong>2. Teks "Diberikan Kepada"</strong></h6>
                                <div class="form-group mb-2">
                                    <label>Koordinat Y (Posisi Label)</label>
                                    <input type="number" name="label_y" id="label_y" class="form-control" value="390" required>
                                </div>
                                <div class="form-group mb-0">
                                    <label>Ukuran Font Label (px)</label>
                                    <input type="number" name="label_font_size" id="label_font_size" class="form-control" value="16" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pengaturan Nama Peserta -->
                    <div class="card p-3 mb-3 bg-light">
                        <h6><strong>3. Nama Peserta</strong></h6>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-2">
                                    <label>Koordinat X (Horizontal Tengah)</label>
                                    <input type="number" name="coordinate_x" id="coordinate_x" class="form-control" value="600" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-2">
                                    <label>Koordinat Y (Posisi Nama)</label>
                                    <input type="number" name="coordinate_y" id="coordinate_y" class="form-control" value="450" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-2">
                                    <label>Ukuran Font Nama (px)</label>
                                    <input type="number" name="font_size" id="font_size" class="form-control" value="40" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label style="font-weight: 600;">Gambar Template Background</label>
                        <input type="file" name="background_image" id="background_image" class="form-control-file">
                        <small class="text-muted" id="file-info"></small>
                    </div>

                    <div class="form-group mb-3">
                        <label style="font-weight: 600; display: block;">Live Preview Posisi Elemen</label>
                        <div style="width: 100%; max-height: 350px; overflow: auto; border: 1px dashed #ccc; padding: 5px; text-align: center; background: #f9f9f9;">
                            <canvas id="certificateCanvas" style="max-width: 100%; height: auto; display: none;"></canvas>
                            <div id="previewPlaceholder" class="text-muted py-5">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-image" viewBox="0 0 16 16">
                                  <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"/>
                                  <path d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1z"/>
                                </svg>
                                <p class="mt-2 mb-0" style="font-size: 12px;">Pilih gambar atau edit data untuk melihat preview posisi</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let currentBgImage = new Image();
let isImageLoaded = false;

// Event Listener input untuk kalkulasi visual secara langsung (Live Preview)
const previewInputs = ['coordinate_x', 'coordinate_y', 'font_size', 'serial_y', 'serial_font_size', 'label_y', 'label_font_size'];
previewInputs.forEach(id => {
    document.getElementById(id).addEventListener('input', drawPreview);
});

// Event Listener Upload Gambar
document.getElementById('background_image').addEventListener('change', function(e) {
    var reader = new FileReader();
    reader.onload = function(event) {
        currentBgImage.onload = function() {
            isImageLoaded = true;
            document.getElementById('certificateCanvas').style.display = 'inline-block';
            document.getElementById('previewPlaceholder').style.display = 'none';
            drawPreview();
        };
        currentBgImage.src = event.target.result;
    };
    if(e.target.files[0]) {
        reader.readAsDataURL(e.target.files[0]);
    }
});

function drawPreview() {
    if (!isImageLoaded) return;

    const canvas = document.getElementById('certificateCanvas');
    const ctx = canvas.getContext('2d');

    canvas.width = 1122;
    canvas.height = 793;

    ctx.drawImage(currentBgImage, 0, 0, 1122, 793);

    const x = parseInt(document.getElementById('coordinate_x').value) || 600;
    
    // 1. Gambar Nomor Seri
    const serialY = parseInt(document.getElementById('serial_y').value) || 330;
    const serialFontSize = parseInt(document.getElementById('serial_font_size').value) || 18;
    ctx.font = `${serialFontSize}px Helvetica, Arial, sans-serif`;
    ctx.fillStyle = '#444444';
    ctx.textAlign = 'center'; 
    ctx.textBaseline = 'top'; 
    ctx.fillText('No. Sertifikat: CERT/2026/001/089', x, serialY);

    // 2. Gambar Teks "Diberikan Kepada"
    const labelY = parseInt(document.getElementById('label_y').value) || 390;
    const labelFontSize = parseInt(document.getElementById('label_font_size').value) || 16;
    ctx.font = `italic ${labelFontSize}px Helvetica, Arial, sans-serif`;
    ctx.fillStyle = '#333333';
    ctx.fillText('Diberikan Kepada:', x, labelY);

    // 3. Gambar Nama Peserta
    const nameY = parseInt(document.getElementById('coordinate_y').value) || 450;
    const nameFontSize = parseInt(document.getElementById('font_size').value) || 40;
    ctx.font = `bold ${nameFontSize}px Helvetica, Arial, sans-serif`;
    ctx.fillStyle = '#000000';
    ctx.fillText('NAMA MAHASISWA CONTOH', x, nameY);
}

function toggleTargetFields() {
    var type = document.getElementById('target_type').value;
    if(type === 'materi') {
        document.getElementById('wrapper_materi').style.display = 'block';
        document.getElementById('wrapper_sub_materi').style.display = 'none';
        document.getElementById('sub_materi_id').value = '';
    } else {
        document.getElementById('wrapper_materi').style.display = 'none';
        document.getElementById('wrapper_sub_materi').style.display = 'block';
        document.getElementById('materi_id').value = '';
    }
}

function resetForm() {
    document.getElementById('id').value = '';
    document.getElementById('target_type').value = 'materi';
    
    document.getElementById('serial_y').value = 330;
    document.getElementById('serial_font_size').value = 18;
    document.getElementById('label_y').value = 390;
    document.getElementById('label_font_size').value = 16;
    document.getElementById('coordinate_x').value = 600;
    document.getElementById('coordinate_y').value = 450;
    document.getElementById('font_size').value = 40;
    
    document.getElementById('file-info').innerText = '';
    isImageLoaded = false;
    document.getElementById('certificateCanvas').style.display = 'none';
    document.getElementById('previewPlaceholder').style.display = 'block';
    
    toggleTargetFields();
}

function editCert(data) {
    resetForm();
    document.getElementById('id').value = data.id;
    document.getElementById('target_type').value = data.target_type;
    
    document.getElementById('serial_y').value = data.serial_y || 330;
    document.getElementById('serial_font_size').value = data.serial_font_size || 18;
    document.getElementById('label_y').value = data.label_y || 390;
    document.getElementById('label_font_size').value = data.label_font_size || 16;
    document.getElementById('coordinate_x').value = data.coordinate_x;
    document.getElementById('coordinate_y').value = data.coordinate_y;
    document.getElementById('font_size').value = data.font_size;
    
    toggleTargetFields();
    if(data.target_type === 'materi') {
        document.getElementById('materi_id').value = data.materi_id;
    } else {
        document.getElementById('sub_materi_id').value = data.sub_materi_id;
    }

    if(data.background_image) {
        document.getElementById('file-info').innerText = 'File aktif: ' + data.background_image;
        currentBgImage.onload = function() {
            isImageLoaded = true;
            document.getElementById('certificateCanvas').style.display = 'inline-block';
            document.getElementById('previewPlaceholder').style.display = 'none';
            drawPreview();
        };
        currentBgImage.src = '/storage/certificates/' + data.background_image;
    }
    $('#certModal').modal('show');
}
</script>
@endsection