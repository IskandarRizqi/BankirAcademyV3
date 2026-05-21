<style>
    /* Menggunakan font modern dan styling card yang clean */
    .membership-section {
        background-color: #f8f9fa;
        padding: 60px 0;
    }
    
    .card-membership {
        border: none;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
        background: #ffffff;
    }

    .card-membership:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    }

    .membership-badge {
        position: absolute;
        top: 20px;
        right: 20px;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(4px);
        padding: 6px 14px;
        border-radius: 30px;
        font-weight: 600;
        font-size: 0.85rem;
    }

    .price-tag {
        font-size: 1.75rem;
        font-weight: 800;
        color: #2b3h41;
    }

    .feature-list {
        list-style: none;
        padding-left: 0;
    }

    .feature-list li {
        padding: 8px 0;
        font-size: 0.95rem;
        color: #555;
        display: flex;
        align-items: center;
    }

    .feature-list li i, .feature-list li .dot {
        color: #28a745;
        margin-right: 10px;
        font-weight: bold;
    }

    /* Styling khusus Area Member yang sudah aktif */
    .active-member-box {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        color: white;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 10px 25px rgba(30, 60, 114, 0.15);
    }

    /* Modal Styling */
    .modal-content {
        border-radius: 16px;
        border: none;
    }
    
    .preview-img-container {
        border: 2px dashed #ddd;
        border-radius: 8px;
        padding: 10px;
        text-align: center;
        background: #fdfdfd;
    }
</style>

<section class="membership-section" id="content">
    <div class="container">
        
        @if($ismember)
            <!-- TAMPILAN JIKA USER SUDAH JADI MEMBER -->
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <div class="active-member-box text-center">
                        <div class="mb-4">
                            <!-- Menggunakan Gambar Banner Member bawaanmu -->
                            <img src="{{ asset('front/images/A_MEMBER.jpg') }}" alt="Member Active" class="img-fluid rounded mb-3" style="max-height: 200px;">
                        </div>
                        <h2 class="font-weight-bold mb-2">Halo, Selamat Datang Member Premium!</h2>
                        <p class="lead opacity-75">Akses penuh seluruh fitur eksklusif kini berada di tangan Anda.</p>
                        <hr style="border-top: 1px solid rgba(255,255,255,0.2)">
                        <div class="d-inline-block bg-white text-dark px-4 py-2 rounded-pill font-weight-bold mt-2 shadow-sm">
                            🗓️ Masa Aktif Hingga: {{\Carbon\Carbon::parse($user->profile->masa_aktif_membership)->format('d M Y')}}
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- TAMPILAN PILIHAN PAKET MEMBERSHIP -->
            <!-- <div class="text-center mb-5">
                <h2 class="font-weight-bold">Pilih Paket Membership Anda</h2>
                <p class="text-muted">Investasikan masa depan karirmu dengan bergabung bersama Bankir Academy</p>
            </div> -->

            <div class="row justify-content-center">
                @foreach($member as $key => $value)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card card-membership h-100 position-relative">
                        
                        <!-- Gambar Banner Paket -->
                        <div class="position-relative">
                            <img src="{{ $value->gambar }}" class="card-img-top" alt="{{ $value->nama }}" style="height: 180px; object-fit: cover;">
                            @if($value->type)
                                <span class="membership-badge text-primary shadow-sm">{{ strtoupper($value->type) }}</span>
                            @endif
                        </div>

                        <!-- Info Paket -->
                        <div class="card-body d-flex flex-column p-4">
                            <h4 class="card-title font-weight-bold mb-1">{{ $value->nama }}</h4>
                            <p class="text-muted small mb-3">{{ $value->keterangan ?? 'Akses fitur premium pilihan' }}</p>
                            
                            <div class="mb-4">
                                <span class="text-muted small">Rp</span>
                                <span class="price-tag">{{ number_format($value->harga, 0, ',', '.') }}</span>
                                <span class="text-muted small">/ paket</span>
                            </div>

                            <!-- List Benefit (Menampilkan Kolom Model secara visual) -->
                            <!-- <ul class="feature-list mb-4 flex-grow-1">
                                <li><span class="dot">✓</span> Jenis Kelas: {{ $value->jenis_kelas ?? 'Semua Kelas' }}</li>
                                <li><span class="dot">✓</span> Limit Penggunaan: {{ $value->limit ?? 'Tanpa Batas' }}</li>
                                @if($value->video_kursus) <li><span class="dot">✓</span> Akses {{ $value->video_kursus }} Video Kursus</li> @endif
                                @if($value->lamaran_online) <li><span class="dot">✓</span> Fitur Lamaran Online Terintegrasi</li> @endif
                                @if($value->pelatihan_gratis) <li><span class="dot">✓</span> Gratis Mengikuti Pelatihan Pilihan</li> @endif
                                @if($value->cvats) <li><span class="dot">✓</span> Fitur Cek CV ATS Friendly</li> @endif
                            </ul> -->

                            <!-- Action Button -->
                            <button type="button" class="btn btn-primary btn-block py-2 font-weight-bold rounded-pill shadow-sm" onclick="openmember({{ json_encode($value) }})">
                                Pilih Paket Ini
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif

    </div>

    <!-- MODAL TRANSAKSI / POP UP PEMBAYARAN -->
    <div class="modal fade" id="modalmember" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Konfirmasi Pendaftaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <form action="/updatemember" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="status_membership" id="status_membership" value="2">
                        <input type="hidden" name="id_member" id="id_member">
                        
                        <!-- Detail Invoice & Bank (Akan di-inject via JS) -->
                        <div id="detailmember" class="mb-4"></div>
                        
                        <!-- Upload Bukti -->
                        <div class="form-group mb-3">
                            <label class="font-weight-bold small text-muted">UPLOAD BUKTI PEMBAYARAN</label>
                            <input type="file" class="form-control-file p-2 border rounded w-100" name="image_bukti_pembayaran" id="image_bukti_pembayaran" accept="image/png, image/jpeg" required>
                            @error('image_bukti_pembayaran')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Preview Image Live -->
                        <div class="preview-img-container mb-3 d-none" id="previewContainer">
                            <img id="pctrbuktipembayaran" src="" alt="Preview Bukti" class="img-fluid rounded" style="max-height: 250px;">
                        </div>

                        <div class="row pt-2">
                            <div class="col-6">
                                <button type="button" class="btn btn-light btn-block rounded-pill" data-dismiss="modal">Batal</button>
                            </div>
                            <div class="col-6">
                                <button type="submit" class="btn btn-success btn-block rounded-pill font-weight-bold shadow-sm">Kirim Bukti</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    function openmember(val) {
        // Set ID Member ke Hidden Input
        $('#id_member').val(val.id);
        
        // Bersihkan Preview Upload sebelumnya
        $('#image_bukti_pembayaran').val('');
        $('#previewContainer').addClass('d-none');
        
        // Komponen Informasi Pembayaran yang Terstruktur & Indah
        let p = `
            <div class="card bg-light border-0 mb-3">
                <div class="card-body p-3">
                    <span class="text-muted d-block small uppercase">NAMA PAKET</span>
                    <h5 class="font-weight-bold text-dark">${val.nama}</h5>
                    <hr class="my-2">
                    <span class="text-muted d-block small">TOTAL TAGIHAN</span>
                    <h4 class="font-weight-bold text-primary">Rp ${parseInt(val.harga).toLocaleString('id-ID')}</h4>
                </div>
            </div>
            
            <div class="p-3 border rounded mb-3" style="background-color: #fffdf5; border-color: #ffeeba !important;">
                <span class="text-muted d-block small font-weight-bold text-warning">REKENING PEMBAYARAN</span>
                <span class="d-block mt-1"><strong>Bank Central Asia (BCA)</strong></span>
                <span class="d-block text-monospace font-weight-bold text-dark" style="font-size: 1.15rem;">803 555 9091</span>
                <span class="small d-block text-muted">a.n. PT. Bankir Academy Indonesia</span>
            </div>

            <a href="/classes/cetakinvoicepending/${val.id}" target="_blank" class="btn btn-outline-info btn-block btn-sm rounded-pill mb-2">
                <i class="fa fa-file-text-o"></i> Unduh Invoice Digital (PDF)
            </a>
        `;
        
        $('#detailmember').html(p);
        $('#modalmember').modal('show');
    }

    // Fitur UX Live Preview Gambar Struk Transfer
    document.getElementById('image_bukti_pembayaran').onchange = function (evt) {
        const [file] = this.files;
        if (file) {
            document.getElementById('pctrbuktipembayaran').src = URL.createObjectURL(file);
            document.getElementById('previewContainer').classList.remove('d-none');
        }
    };
</script>