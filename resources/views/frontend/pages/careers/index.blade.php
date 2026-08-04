@extends('layouts.appfrontend')

@section('content')
<div id="content-area">
    <div class="full-page" data-type="component-text">
        
        <!-- ================= HERO & SEARCH HEADER ================= -->
        <div class="bg-gradient-primary text-white py-5 position-relative overflow-hidden careers-hero">
            <div class="container position-relative z-index-2 py-4">
                <div class="row justify-content-center text-center mb-4">
                    <div class="col-lg-8">
                        <span class="badge bg-white text-dark px-3 py-2 rounded-pill fw-bold mb-3">Karir Perbankan</span>
                        <h1 class="text-white fw-bold display-5 mb-3">Temukan Posisi Terbaik di Industri Perbankan</h1>
                        <p class="text-white-50 lead">Bangun karir profesionalmu bersama jaringan mitra bank terpercaya di Indonesia.</p>
                    </div>
                </div>

                <!-- Interactive Filter / Search Bar -->
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="card border-0 shadow-lg p-1 bg-white rounded-3">
                            <form action="{{ url()->current() }}" method="GET" class="row g-2 align-items-center">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <!-- <span class="input-group-text bg-transparent border-0"><i class="ti-search text-muted"></i></span> -->
                                        <input type="text" name="search" class="form-control border-0 bg-transparent" placeholder="Cari posisi atau keahlian..." value="{{ request('search') }}">
                                    </div>
                                </div>
                                <div class="col-md-4 border-start-md">
                                    <select name="location" class="form-select border-0 bg-transparent text-muted">
                                        <option value="">Semua Lokasi</option>
                                        @foreach($provinsi as $prov)
                                            <option value="{{ $prov->id }}" {{ request('location') == $prov->id ? 'selected' : '' }}>
                                                {{ $prov->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary w-100 fw-semibold">Cari Kerja</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- ================= MAIN JOB EXPLORER SECTION (SPLIT VIEW LAYOUT) ================= -->
        <div class="section-padding bg-light">
            <div class="container">
                
                <div class="row mb-4 align-items-center">
                    <div class="col-md-6">
                        <h3 class="fw-bold m-0">Lowongan Pekerjaan Aktif</h3>
                        <p class="text-muted m-0 small">Menampilkan peluang karir terbaru yang siap dilamar</p>
                    </div>
                    <div class="col-md-6 text-md-end mt-2 mt-md-0">
                        <span class="text-muted small">Urutkan: </span>
                        <select class="form-select d-inline-block w-auto form-select-sm border-0 shadow-sm ms-2">
                            <option value="latest">Terbaru</option>
                            <option value="popular">Paling Banyak Dilamar</option>
                        </select>
                    </div>
                </div>

                <div class="row g-4">
                    
                    <!-- LEFT COLUMN: JOB LIST PANEL -->
                   <div class="col-lg-5 col-md-12">
    <div class="d-flex flex-column gap-3" id="job-list-container">
        
        @forelse($lokers as $index => $job)
            @php
                $id = $job->id;
                $title = $job->title;
                $company = $job->nama_perusahaan ?? ($job->corporate ?? ($job->user_name ?? 'Perusahaan Mitra'));
                $location = $job->kabupaten_name ?? ($job->kabupaten ?? 'Indonesia');
                
                // Normalisasi type jika disimpan sebagai JSON string di DB
                $rawType = is_string($job->type) ? json_decode($job->type, true) ?? $job->type : $job->type;
                
                if (is_array($rawType)) {
                    $workType = implode(', ', array_map('ucfirst', $rawType));
                } else {
                    $workType = ucfirst((string)$rawType) ?: 'Onsite';
                }

                $jobType = $job->job_type ?? 'Full Time';
                $salary = $job->gaji_min ? 'Rp ' . number_format($job->gaji_min, 0, ',', '.') : 'Negosiasi';
                $timePosted = $job->created_at ? \Carbon\Carbon::parse($job->created_at)->diffForHumans() : 'Baru saja';
                
                // Normalisasi Skill
                $skills = is_string($job->skill) ? json_decode($job->skill, true) ?? [] : ($job->skill ?? []);

                // Payload data aman disisipkan ke data attribute
                $jobPayload = [
                    'id' => $id,
                    'title' => $title,
                    'company' => $company,
                    'location' => $location,
                    'work_type' => $workType,
                    'job_type' => $jobType,
                    'salary' => $salary,
                    'deskripsi' => $job->deskripsi,
                    'jobdesk' => $job->jobdesk ?? null,
                    'skill' => $skills,
                    'pengalaman' => $job->pengalaman ?? 'Min. 1 Tahun',
                    'whatsapp' => $job->whatsapp ?? '628123456789'
                ];
            @endphp

            <!-- Job Card Item -->
            <div class="card border-0 shadow-sm p-3 position-relative job-card cursor-pointer job-card-clickable {{ $index === 0 ? 'border-start border-4 border-primary bg-white active-card' : 'bg-white opacity-90' }}"
                 data-job="{{ json_encode($jobPayload, JSON_HEX_APOS | JSON_HEX_QUOT) }}"
                 onclick="selectJob(this)">
                
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <span class="badge bg-light text-dark me-1 border"><i class="ti-location-pin me-1"></i>{{ $location }}</span>
                        <span class="badge bg-info-subtle text-info border border-info-subtle">{{ $workType }}</span>
                    </div>
                    <small class="text-muted"><i class="far fa-clock me-1"></i>{{ $timePosted }}</small>
                </div>

                <h5 class="fw-bold text-dark mb-1">{{ $title }}</h5>
                <p class="text-primary fw-semibold small mb-2"><i class="fas fa-building me-1"></i>{{ $company }}</p>

                <div class="d-flex align-items-center justify-content-between mt-3 pt-2 border-top">
                    <span class="fw-bold text-success small">{{ $salary }}</span>
                    <span class="badge bg-primary text-white">{{ $jobType }}</span>
                </div>
            </div>

        @empty
            <div class="card border-0 p-4 text-center">
                <p class="text-muted m-0">Tidak ada lowongan kerja yang ditemukan.</p>
            </div>
        @endforelse

    </div>
</div>

                    <!-- RIGHT COLUMN: DETAILED VIEW PANEL -->
                    <div class="col-lg-7 col-md-12">
                        @if($lokers->count() > 0)
                            @php
                                $firstJob = $lokers->first();
                                $firstCompany = $firstJob->nama_perusahaan ?? ($firstJob->corporate ?? ($firstJob->user_name ?? 'Perusahaan Mitra'));
                                $firstLocation = $firstJob->kabupaten_name ?? ($firstJob->kabupaten ?? 'Indonesia');
                                $firstSalary = $firstJob->gaji_min ? 'Rp ' . number_format($firstJob->gaji_min, 0, ',', '.') : 'Negosiasi';
                                $firstWorkType = is_array($firstJob->type) ? implode(', ', array_map('ucfirst', $firstJob->type)) : (is_string($firstJob->type) ? ucfirst($firstJob->type) : 'Onsite / WFO');
                            @endphp

                            <div class="card border-0 shadow-sm p-4 bg-white sticky-top job-detail-sticky" id="job-detail-card">
                                
                                <div class="d-flex justify-content-between align-items-start pb-3 mb-3 border-bottom">
                                    <div>
                                        <span class="badge bg-primary text-white mb-2" id="detail-job-type">{{ $firstJob->job_type ?? 'Full Time' }}</span>
                                        <h3 class="fw-bold text-dark mb-1" id="detail-title">{{ $firstJob->title }}</h3>
                                        <p class="text-muted fs-6 mb-0" id="detail-company-location">
                                            <i class="fas fa-building text-primary me-2"></i><span id="detail-company">{{ $firstCompany }}</span> &bull; <span id="detail-location">{{ $firstLocation }}</span>
                                        </p>
                                    </div>
                                    <a href="{{ route('lowongan.show', $firstJob->id) }}" id="detail-apply-btn" class="btn btn-primary px-4 py-2 fw-semibold">
                                        Lamar Sekarang <i class="ti-arrow-right ms-1"></i>
                                    </a>
                                </div>

                                <div class="row text-center g-2 mb-4">
                                    <div class="col-6">
                                        <div class="bg-light p-2 rounded">
                                            <small class="text-muted d-block">Gaji Ditawarkan</small>
                                            <strong class="text-dark small" id="detail-salary">{{ $firstSalary }}</strong>
                                        </div>
                                    </div>
                                    <!-- <div class="col-4">
                                        <div class="bg-light p-2 rounded">
                                            <small class="text-muted d-block">Pengalaman</small>
                                            <strong class="text-dark small" id="detail-experience">{{ $firstJob->pengalaman ?? 'Min. 1 Tahun' }}</strong>
                                        </div>
                                    </div> -->
                                    <div class="col-6">
                                        <div class="bg-light p-2 rounded">
                                            <small class="text-muted d-block">Tipe Kerja</small>
                                            <strong class="text-dark small" id="detail-work-type">{{ $firstWorkType }}</strong>
                                        </div>
                                    </div>
                                </div>

                                <div class="job-description-body">
                                    <h5 class="fw-bold text-dark mb-2">Deskripsi Pekerjaan:</h5>
                                    <div class="text-muted small leading-relaxed mb-4" id="detail-description">
                                        {!! $firstJob->deskripsi !!}
                                    </div>

                                    <div id="detail-jobdesk-wrapper" class="{{ empty($firstJob->jobdesk) ? 'd-none' : '' }}">
                                        <h5 class="fw-bold text-dark mb-2">Tanggung Jawab Utama:</h5>
                                        <div class="text-muted small ps-3 mb-4" id="detail-jobdesk">
                                            {!! $firstJob->jobdesk !!}
                                        </div>
                                    </div>

                                    <div id="detail-skills-wrapper" class="{{ empty($firstJob->skill) ? 'd-none' : '' }}">
                                        <h5 class="fw-bold text-dark mb-2">Kualifikasi & Keahlian:</h5>
                                        <div class="mb-4" id="detail-skills">
                                            @if(is_array($firstJob->skill))
                                                @foreach($firstJob->skill as $sk)
                                                    <span class="badge bg-light text-dark border me-1 mb-1">#{{ $sk }}</span>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="p-3 bg-light rounded d-flex align-items-center justify-content-between mt-3">
                                    <div>
                                        <small class="text-muted d-block">Punya pertanyaan tentang posisi ini?</small>
                                        <span class="fw-semibold text-dark small">Hubungi Tim Recruitment Bankir Academy</span>
                                    </div>
                                    <a href="#" id="detail-wa-btn" target="_blank" class="btn btn-outline-success btn-sm">
                                        <i class="fab fa-whatsapp me-1"></i> Tanya HR
                                    </a>
                                </div>

                            </div>
                        @else
                            <div class="card border-0 shadow-sm p-5 text-center bg-white">
                                <p class="text-muted">Pilih lowongan di sebelah kiri untuk melihat rincian informasi.</p>
                            </div>
                        @endif
                    </div>

                </div>

            </div>
        </div>

    </div>
</div>

<!-- JavaScript Split View Handling -->
<script>
function selectJob(cardElement) {
    try {
        // 1. Reset class active pada card kiri
        document.querySelectorAll('.job-card').forEach(card => {
            card.classList.remove('border-start', 'border-4', 'border-primary', 'active-card');
            card.classList.add('opacity-90');
        });

        // 2. Beri style active pada card yang diklik
        cardElement.classList.add('border-start', 'border-4', 'border-primary', 'active-card');
        cardElement.classList.remove('opacity-90');

        // 3. Ambil data JSON dengan parse aman
        const rawData = cardElement.getAttribute('data-job');
        const jobData = typeof rawData === 'string' ? JSON.parse(rawData) : rawData;

        // 4. Update data pada panel detail sebelah kanan
        document.getElementById('detail-title').innerText = jobData.title || '';
        document.getElementById('detail-company').innerText = jobData.company || '';
        document.getElementById('detail-location').innerText = jobData.location || '';
        document.getElementById('detail-job-type').innerText = jobData.job_type || 'Full Time';
        document.getElementById('detail-salary').innerText = jobData.salary || 'Negosiasi';
        document.getElementById('detail-experience').innerText = jobData.pengalaman || '-';
        document.getElementById('detail-work-type').innerText = jobData.work_type || 'Onsite';
        document.getElementById('detail-description').innerHTML = jobData.deskripsi || '';
        
        // Update link Tombol "Lamar Sekarang" & WhatsApp
        document.getElementById('detail-apply-btn').href = "/lowongan/" + jobData.id;
        document.getElementById('detail-wa-btn').href = "https://wa.me/" + (jobData.whatsapp || '');

        // Update Jobdesk
        const jobdeskWrapper = document.getElementById('detail-jobdesk-wrapper');
        if (jobData.jobdesk && jobData.jobdesk.trim() !== '') {
            document.getElementById('detail-jobdesk').innerHTML = jobData.jobdesk;
            jobdeskWrapper.style.display = 'block';
        } else {
            jobdeskWrapper.style.display = 'none';
        }

        // Update Skills
        const skillsWrapper = document.getElementById('detail-skills-wrapper');
        const skillsContainer = document.getElementById('detail-skills');
        if (Array.isArray(jobData.skill) && jobData.skill.length > 0) {
            skillsContainer.innerHTML = jobData.skill.map(s => `<span class="badge bg-light text-dark border me-1 mb-1">#${s}</span>`).join('');
            skillsWrapper.style.display = 'block';
        } else {
            skillsWrapper.style.display = 'none';
        }
    } catch (error) {
        console.error("Gagal memperbarui detail lowongan:", error);
    }
}
</script>
@endsection
