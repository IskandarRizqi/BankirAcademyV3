@extends('layouts.compact')

@section('content')
    <style>
        /* CSS Grid Masonry ala Pinterest */
        .pin-grid {
            column-count: 2;
            column-gap: 1.25rem;
        }

        @media (min-width: 768px) {
            .pin-grid {
                column-count: 3;
            }
        }

        @media (min-width: 992px) {
            .pin-grid {
                column-count: 4;
            }
        }

        /* Pin Card Item */
        .pin-item {
            break-inside: avoid;
            margin-bottom: 1.25rem;
            position: relative;
            border-radius: 16px;
            overflow: hidden;
            background-color: #f1f5f9;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .pin-item:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.12) !important;
        }

        .pin-img {
            width: 100%;
            height: auto;
            display: block;
            object-fit: cover;
        }

        /* Hover Overlay & Action Buttons */
        .pin-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.75) 0%, rgba(0, 0, 0, 0.1) 50%, rgba(0, 0, 0, 0) 100%);
            opacity: 0;
            transition: opacity 0.2s ease-in-out;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 12px;
            z-index: 5;
        }

        .pin-item:hover .pin-overlay,
        .pin-item.selected .pin-overlay {
            opacity: 1;
        }

        .upload-zone {
            border: 2px dashed #cbd5e1;
            border-radius: 12px;
            background-color: #f8fafc;
            transition: all 0.2s ease-in-out;
            cursor: pointer;
        }

        .upload-zone:hover,
        .upload-zone.dragover {
            border-color: #0d6efd;
            background-color: #eff6ff;
        }

        .photo-checkbox-custom {
            width: 20px;
            height: 20px;
            cursor: pointer;
        }
    </style>

    <div class="container-fluid px-4 my-4">
        <!-- Header Toolbar -->
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
            <div>
                <h3 class="fw-bold mb-1 text-dark">Galeri Album Foto</h3>
                <p class="text-muted small mb-0">Kelola dan eksplorasi koleksi foto album Anda.</p>
            </div>
        </div>

        <!-- Alert Status -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Search & Filter Bar (BARU) -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-3">
                <div class="row g-2 align-items-center">
                    <!-- Search Input -->
                    <div class="col-md-4 col-12">
                        <div class="input-group">
                            <input type="text" id="filterSearch"
                                class="form-control bg-light border-start-0 rounded-pill" placeholder="Cari nama foto..."
                                oninput="debounceFilter()">
                        </div>
                    </div>

                    <!-- Filter Ukuran File -->
                    <div class="col-md-3 col-6">
                        <select id="filterSize" class="form-select form-control bg-light rounded-pill"
                            onchange="loadAlbumPhotos()">
                            <option value="">Semua Ukuran File</option>
                            <option value="small">Kecil (&lt; 500 KB)</option>
                            <option value="medium">Sedang (500 KB - 2 MB)</option>
                            <option value="large">Besar (&gt; 2 MB)</option>
                        </select>
                    </div>

                    <!-- Filter Tanggal dari/sampai -->
                    <div class="col-md-2 col-6">
                        <input type="date" id="filterDateFrom" class="form-control bg-light rounded-pill"
                            title="Dari Tanggal" onchange="loadAlbumPhotos()">
                    </div>
                    <div class="col-md-2 col-6">
                        <input type="date" id="filterDateTo" class="form-control bg-light rounded-pill"
                            title="Sampai Tanggal" onchange="loadAlbumPhotos()">
                    </div>

                    <!-- Reset Filter Button -->
                    <div class="col-md-1 col-6 d-grid">
                        <button type="button" class="btn btn-outline-secondary rounded-pill" onclick="resetFilters()"
                            title="Reset Filter">
                            Reset
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab Navigation: Utama vs Tempat Sampah -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <ul class="nav nav-pills" id="albumTabs">
                <li class="nav-item">
                    <button class="nav-link active border border-0 shadow rounded-pill px-4" id="tabMain"
                        onclick="switchTab('main')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-images me-1" viewBox="0 0 16 16">
                            <path
                                d="M4.5 3a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-7zM3 3.5A1.5 1.5 0 0 1 4.5 2h7A1.5 1.5 0 0 1 13 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-7A1.5 1.5 0 0 1 3 12.5v-9z" />
                            <path
                                d="M10.5 5a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-7 7 2.146-2.146a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0L10.5 12H3.5z" />
                        </svg>
                        Semua Foto
                    </button>
                </li>
                <li class="nav-item ms-2">
                    <button class="nav-link border border-0 shadow rounded-pill px-4 mx-4" id="tabTrash"
                        onclick="switchTab('trash')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-trash3 me-1" viewBox="0 0 16 16">
                            <path
                                d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92H4.885a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5" />
                        </svg>
                        Tempat Sampah
                    </button>
                </li>
            </ul>

            <button type="button" class="btn btn-primary rounded-pill px-4" id="btnOpenUpload" onclick="openUploadModal()">
                + Tambah Foto
            </button>
        </div>

        <!-- Toolbar Batch Actions & View Switcher -->
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 p-3 bg-light rounded-4 gap-2 border">
            <div class="form-check mb-0">
                <input class="form-check-input photo-checkbox-custom" type="checkbox" id="selectAll"
                    onchange="toggleSelectAll(this)">
                <label class="form-check-label text-dark fw-medium small ms-2 align-middle" for="selectAll">Pilih
                    Semua</label>
            </div>

            <div class="d-flex align-items-center gap-3">
                <div class="btn-group btn-group-sm" role="group" aria-label="View Mode">
                    <button type="button" class="btn btn-outline-secondary active" id="btnModeGrid"
                        onclick="switchViewMode('grid')" title="Mode Masonry">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-grid-fill" viewBox="0 0 16 16">
                            <path
                                d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5v-3zm8 0A1.5 1.5 0 0 1 10.5 1h3A1.5 1.5 0 0 1 15 2.5v3A1.5 1.5 0 0 1 13.5 7h-3A1.5 1.5 0 0 1 9 5.5v-3zm-8 8A1.5 1.5 0 0 1 2.5 9h3A1.5 1.5 0 0 1 7 10.5v3A1.5 1.5 0 0 1 5.5 15h-3A1.5 1.5 0 0 1 1 13.5v-3zm8 0A1.5 1.5 0 0 1 10.5 9h3a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 9 13.5v-3z" />
                        </svg>
                    </button>
                    <button type="button" class="btn btn-outline-secondary" id="btnModeList"
                        onclick="switchViewMode('list')" title="Mode Detail List">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-list-task" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M2 2.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5V3a.5.5 0 0 0-.5-.5H2zM3 3H2v1h1V3z" />
                            <path
                                d="M5 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM5.5 7a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1h-9zm0 4a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1h-9z" />
                            <path fill-rule="evenodd"
                                d="M1.5 7a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H2a.5.5 0 0 1-.5-.5V7zM2 7h1v1H2V7zm0 3.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5H2zm1 .5H2v1h1v-1z" />
                        </svg>
                    </button>
                </div>

                <span id="selectedCount" class="badge bg-secondary-subtle text-secondary rounded-pill px-3 py-2">0
                    terpilih</span>

                <!-- Batch Normal Action (Soft Delete) -->
                <button type="button" class="btn btn-warning btn-sm rounded-pill px-3" id="btnBatchDelete"
                    onclick="deleteSelectedPhotos()" disabled>
                    Ke Sampah
                </button>

                <!-- Batch Trash Actions (Restore & Force Delete) -->
                <div id="trashBatchActions" class="d-none gap-2">
                    <button type="button" class="btn btn-success btn-sm rounded-pill px-3" id="btnBatchRestore"
                        onclick="restoreSelectedPhotos()" disabled>
                        Pulihkan
                    </button>
                    <button type="button" class="btn btn-danger btn-sm rounded-pill px-3" id="btnBatchForceDelete"
                        onclick="forceDeleteSelectedPhotos()" disabled>
                        Hapus Permanen
                    </button>
                </div>
            </div>
        </div>

        <!-- Container Utama Galeri Foto -->
        <div id="photo_display_container">
            <div class="text-center py-5 text-muted">Memuat galeri foto...</div>
        </div>

        <!-- Modal Form Upload / Edit -->
        <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow rounded-4">
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title fw-bold" id="formTitle">Upload Foto Album</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            onclick="resetForm()"></button>
                    </div>
                    <div class="modal-body p-4">
                        <form id="albumForm" action="{{ route('album.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="_method" id="formMethod" value="POST">
                            <input type="hidden" id="photo_id" name="id">

                            <div class="mb-3 d-none" id="titleGroup">
                                <label class="form-label fw-semibold text-secondary">Judul Foto</label>
                                <input type="text" name="title" id="photo_title" class="form-control rounded-3"
                                    placeholder="Masukkan judul foto">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold text-secondary" id="labelFileInput">Pilih / Drag
                                    Foto</label>
                                <div class="upload-zone text-center p-4" id="dropZone"
                                    onclick="document.getElementById('photo_image').click()">
                                    <div class="text-primary mb-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36"
                                            fill="currentColor" class="bi bi-images" viewBox="0 0 16 16">
                                            <path
                                                d="M4.5 3a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-7zM3 3.5A1.5 1.5 0 0 1 4.5 2h7A1.5 1.5 0 0 1 13 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-7A1.5 1.5 0 0 1 3 12.5v-9z" />
                                            <path
                                                d="M10.5 5a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-7 7 2.146-2.146a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0L10.5 12H3.5z" />
                                        </svg>
                                    </div>
                                    <p class="small fw-semibold text-dark mb-1" id="dropZoneText">Klik atau seret foto ke
                                        sini</p>
                                    <span class="text-muted d-block" style="font-size: 11px;">Bisa pilih multiple file
                                        (JPG, PNG, WEBP, Max 2MB/foto)</span>
                                </div>
                                <input type="file" name="images[]" id="photo_image" class="d-none" accept="image/*"
                                    multiple onchange="handleFileSelect(this)">
                            </div>

                            <div class="mb-3 d-none" id="fileListContainer">
                                <label class="form-label fw-semibold text-secondary style-small">Berkas Terpilih:</label>
                                <ul class="list-group list-group-flush small" id="fileList"></ul>
                            </div>

                            <div class="mb-3 d-none" id="editPreviewContainer">
                                <label class="form-label fw-semibold text-secondary d-block">Foto Saat Ini:</label>
                                <img id="editPreviewImg" src="" class="img-thumbnail rounded-3 shadow-sm"
                                    style="max-height: 140px;">
                            </div>

                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-primary rounded-pill py-2 fw-semibold"
                                    id="btnSubmit">
                                    Unggah Sekarang
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            let selectedPhotoIds = new Set();
            let photosData = [];
            let currentViewMode = 'grid';
            let currentTab = 'main'; // 'main' | 'trash'
            let uploadModalBS = null;
            let searchDebounceTimer = null;

            document.addEventListener("DOMContentLoaded", () => {
                uploadModalBS = new bootstrap.Modal(document.getElementById('uploadModal'));
                loadAlbumPhotos();
                setupDragAndDrop();
            });

            function switchTab(tab) {
                currentTab = tab;
                document.getElementById('tabMain').classList.toggle('active', tab === 'main');
                document.getElementById('tabTrash').classList.toggle('active', tab === 'trash');

                // Toggle visibilitas tombol Upload
                document.getElementById('btnOpenUpload').classList.toggle('d-none', tab === 'trash');

                // Toggle visibilitas Action Toolbar
                if (tab === 'trash') {
                    document.getElementById('btnBatchDelete').classList.add('d-none');
                    document.getElementById('trashBatchActions').classList.remove('d-none');
                    document.getElementById('trashBatchActions').classList.add('d-flex');
                } else {
                    document.getElementById('btnBatchDelete').classList.remove('d-none');
                    document.getElementById('trashBatchActions').classList.add('d-none');
                    document.getElementById('trashBatchActions').classList.remove('d-flex');
                }

                loadAlbumPhotos();
            }

            function openUploadModal() {
                resetForm();
                uploadModalBS.show();
            }

            function switchViewMode(mode) {
                currentViewMode = mode;
                document.getElementById('btnModeGrid').classList.toggle('active', mode === 'grid');
                document.getElementById('btnModeList').classList.toggle('active', mode === 'list');
                renderPhotos();
            }

            function debounceFilter() {
                clearTimeout(searchDebounceTimer);
                searchDebounceTimer = setTimeout(() => {
                    loadAlbumPhotos();
                }, 300);
            }

            function resetFilters() {
                const searchInput = document.getElementById('filterSearch');
                const sizeInput = document.getElementById('filterSize');
                const dateFromInput = document.getElementById('filterDateFrom');
                const dateToInput = document.getElementById('filterDateTo');

                if (searchInput) searchInput.value = '';
                if (sizeInput) sizeInput.value = '';
                if (dateFromInput) dateFromInput.value = '';
                if (dateToInput) dateToInput.value = '';

                loadAlbumPhotos();
            }

            async function loadAlbumPhotos() {
                const container = document.getElementById('photo_display_container');
                container.innerHTML = '<div class="text-center py-5 text-muted">Memuat galeri foto...</div>';
                selectedPhotoIds.clear();
                updateBatchUI();

                const params = new URLSearchParams();
                const search = document.getElementById('filterSearch')?.value;
                const size = document.getElementById('filterSize')?.value;
                const dateFrom = document.getElementById('filterDateFrom')?.value;
                const dateTo = document.getElementById('filterDateTo')?.value;

                if (search) params.append('search', search);
                if (size) params.append('size', size);
                if (dateFrom) params.append('date_from', dateFrom);
                if (dateTo) params.append('date_to', dateTo);

                // Param soft delete
                if (currentTab === 'trash') {
                    params.append('trashed_only', '1');
                }

                try {
                    const res = await fetch("{{ route('album.index') }}?" + params.toString(), {
                        headers: {
                            'Accept': 'application/json'
                        }
                    });
                    photosData = await res.json();
                    renderPhotos();
                } catch (e) {
                    container.innerHTML = '<div class="text-center text-danger py-5">Gagal memuat galeri foto.</div>';
                }
            }

            function renderPhotos() {
                const container = document.getElementById('photo_display_container');

                if (photosData.length === 0) {
                    container.innerHTML = `
            <div class="text-center text-muted py-5">
                <p class="mb-0 fs-5">${currentTab === 'trash' ? 'Tempat sampah kosong.' : 'Tidak ada foto yang ditemukan.'}</p>
                <small class="text-muted">Coba ubah kata kunci atau reset filter pencarian Anda.</small>
            </div>`;
                    return;
                }

                if (currentViewMode === 'grid') {
                    let gridHtml = '<div class="pin-grid">';
                    gridHtml += photosData.map(photo => {
                        const isChecked = selectedPhotoIds.has(photo.id);
                        return `
            <div class="pin-item ${isChecked ? 'selected' : ''}" id="photo-card-${photo.id}">
                <img src="${photo.url}" class="pin-img" alt="${photo.title}" loading="lazy">
                
                <div class="pin-overlay">
                    <div class="d-flex justify-content-between align-items-center">
                        <input type="checkbox" class="form-check-input photo-checkbox-custom photo-checkbox" value="${photo.id}" ${isChecked ? 'checked' : ''} onchange="toggleSelectPhoto(${photo.id})">
                        <span class="badge bg-dark bg-opacity-50 text-white rounded-pill px-2 py-1 small">${photo.formatted_size}</span>
                    </div>
                    <div>
                        <p class="text-white fw-semibold small mb-0 text-truncate" title="${photo.title}">${photo.title || 'Tanpa Judul'}</p>
                        <p class="text-white-50 small mb-2" style="font-size: 10px;">${photo.formatted_date}</p>
                        <div class="d-flex gap-2">
                            ${currentTab === 'trash' ? `
                                                                                                                                                                        <button type="button" class="btn btn-sm btn-success rounded-pill px-3 py-1 fw-medium" onclick="restoreSinglePhoto(${photo.id})">Pulihkan</button>
                                                                                                                                                                        <button type="button" class="btn btn-sm btn-danger rounded-pill px-3 py-1 fw-medium" onclick="forceDeleteSinglePhoto(${photo.id})">Permanen</button>
                                                                                                                                                                    ` : `
                                                                                                                                                                        <button type="button" class="btn btn-sm btn-light rounded-pill px-3 py-1 fw-medium" onclick="editPhoto(${photo.id})">Edit</button>
                                                                                                                                                                        <button type="button" class="btn btn-sm btn-warning rounded-pill px-3 py-1 fw-medium" onclick="deleteSinglePhoto(${photo.id})">Ke Sampah</button>
                                                                                                                                                                    `}
                        </div>
                    </div>
                </div>
            </div>`;
                    }).join('');
                    gridHtml += '</div>';
                    container.innerHTML = gridHtml;
                } else {
                    let listHtml = `
        <div class="table-responsive bg-white rounded-4 shadow-sm border p-3">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 40px;"></th>
                        <th style="width: 80px;">Preview</th>
                        <th>Nama Foto</th>
                        <th>Ukuran</th>
                        <th>Tanggal Upload</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>`;

                    listHtml += photosData.map(photo => {
                        const isChecked = selectedPhotoIds.has(photo.id) ? 'checked' : '';
                        return `
                <tr id="photo-row-${photo.id}">
                    <td>
                        <input type="checkbox" class="form-check-input photo-checkbox-custom photo-checkbox" value="${photo.id}" ${isChecked} onchange="toggleSelectPhoto(${photo.id})">
                    </td>
                    <td>
                        <img src="${photo.url}" class="rounded-3 object-fit-cover" width="56" height="56" alt="${photo.title}">
                    </td>
                    <td>
                        <span class="fw-semibold text-dark text-truncate d-inline-block" style="max-width: 250px;" title="${photo.title}">${photo.title || 'Tanpa Judul'}</span>
                    </td>
                    <td>
                        <span class="badge bg-secondary-subtle text-secondary rounded-pill px-2 py-1">${photo.formatted_size}</span>
                    </td>
                    <td>
                        <span class="text-muted small">${photo.formatted_date}</span>
                    </td>
                    <td class="text-end">
                        ${currentTab === 'trash' ? `
                                                                                                                                                                    <button type="button" class="btn btn-sm btn-outline-success rounded-pill px-3 me-1" onclick="restoreSinglePhoto(${photo.id})">Pulihkan</button>
                                                                                                                                                                    <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="forceDeleteSinglePhoto(${photo.id})">Hapus Permanen</button>
                                                                                                                                                                ` : `
                                                                                                                                                                    <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3 me-1" onclick="editPhoto(${photo.id})">Edit</button>
                                                                                                                                                                    <button type="button" class="btn btn-sm btn-outline-warning rounded-pill px-3" onclick="deleteSinglePhoto(${photo.id})">Ke Sampah</button>
                                                                                                                                                                `}
                    </td>
                </tr>`;
                    }).join('');

                    listHtml += `
                </tbody>
            </table>
        </div>`;
                    container.innerHTML = listHtml;
                }
            }

            function setupDragAndDrop() {
                const dropZone = document.getElementById('dropZone');
                if (!dropZone) return;

                ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                    dropZone.addEventListener(eventName, preventDefaults, false);
                });

                function preventDefaults(e) {
                    e.preventDefault();
                    e.stopPropagation();
                }

                ['dragenter', 'dragover'].forEach(eventName => {
                    dropZone.addEventListener(eventName, () => dropZone.classList.add('dragover'), false);
                });

                ['dragleave', 'drop'].forEach(eventName => {
                    dropZone.addEventListener(eventName, () => dropZone.classList.remove('dragover'), false);
                });

                dropZone.addEventListener('drop', (e) => {
                    const dt = e.dataTransfer;
                    const files = dt.files;
                    const input = document.getElementById('photo_image');
                    input.files = files;
                    handleFileSelect(input);
                });
            }

            function handleFileSelect(input) {
                const fileListContainer = document.getElementById('fileListContainer');
                const fileList = document.getElementById('fileList');
                fileList.innerHTML = '';

                if (input.files.length > 0) {
                    fileListContainer.classList.remove('d-none');
                    Array.from(input.files).forEach(file => {
                        const li = document.createElement('li');
                        li.className =
                            'list-group-item d-flex justify-content-between align-items-center px-0 py-1 border-0 bg-transparent';
                        li.innerHTML =
                            `<span class="text-truncate" style="max-width: 200px;">${file.name}</span> <span class="badge bg-light text-dark">${(file.size / 1024 / 1024).toFixed(2)} MB</span>`;
                        fileList.appendChild(li);
                    });
                } else {
                    fileListContainer.classList.add('d-none');
                }
            }

            function toggleSelectPhoto(id) {
                selectedPhotoIds.has(id) ? selectedPhotoIds.delete(id) : selectedPhotoIds.add(id);
                updateBatchUI();
            }

            function toggleSelectAll(masterCheckbox) {
                const checkboxes = document.querySelectorAll('.photo-checkbox');
                selectedPhotoIds.clear();

                checkboxes.forEach(cb => {
                    cb.checked = masterCheckbox.checked;
                    if (masterCheckbox.checked) selectedPhotoIds.add(parseInt(cb.value));
                });
                updateBatchUI();
            }

            function updateBatchUI() {
                const count = selectedPhotoIds.size;
                document.getElementById('selectedCount').textContent = `${count} terpilih`;

                document.getElementById('btnBatchDelete').disabled = count === 0;
                document.getElementById('btnBatchRestore').disabled = count === 0;
                document.getElementById('btnBatchForceDelete').disabled = count === 0;

                const allCheckboxes = document.querySelectorAll('.photo-checkbox');
                const selectAllCb = document.getElementById('selectAll');
                if (allCheckboxes.length > 0) {
                    selectAllCb.checked = count === allCheckboxes.length;
                } else {
                    selectAllCb.checked = false;
                }
            }

            function editPhoto(id) {
                const photo = photosData.find(p => p.id === id);
                if (!photo) return;

                document.getElementById('formTitle').textContent = 'Edit Foto';
                document.getElementById('titleGroup').classList.remove('d-none');
                document.getElementById('photo_id').value = photo.id;
                document.getElementById('photo_title').value = photo.title;

                const fileInput = document.getElementById('photo_image');
                fileInput.removeAttribute('multiple');
                fileInput.name = 'image';

                document.getElementById('dropZoneText').textContent = 'Klik / ganti foto (opsional)';
                document.getElementById('editPreviewImg').src = photo.url;
                document.getElementById('editPreviewContainer').classList.remove('d-none');
                document.getElementById('btnSubmit').textContent = 'Perbarui Foto';

                const form = document.getElementById('albumForm');
                form.action = `/album/${id}`;
                document.getElementById('formMethod').value = 'PUT';

                uploadModalBS.show();
            }

            function resetForm() {
                document.getElementById('formTitle').textContent = 'Upload Foto Album';
                document.getElementById('titleGroup').classList.add('d-none');
                document.getElementById('albumForm').reset();
                document.getElementById('photo_id').value = '';

                const fileInput = document.getElementById('photo_image');
                fileInput.setAttribute('multiple', 'multiple');
                fileInput.name = 'images[]';

                document.getElementById('dropZoneText').textContent = 'Klik atau seret foto ke sini';
                document.getElementById('fileListContainer').classList.add('d-none');
                document.getElementById('editPreviewContainer').classList.add('d-none');
                document.getElementById('btnSubmit').textContent = 'Unggah Sekarang';

                const form = document.getElementById('albumForm');
                form.action = "{{ route('album.store') }}";
                document.getElementById('formMethod').value = 'POST';
            }

            // --- Action Handlers ---

            // 1. Soft Delete
            async function deleteSinglePhoto(id) {
                if (!confirm('Pindahkan foto ini ke tempat sampah?')) return;
                await sendBatchRequest("{{ route('album.destroy-batch') }}", [id]);
            }

            async function deleteSelectedPhotos() {
                if (selectedPhotoIds.size === 0) return;
                if (!confirm(`Pindahkan ${selectedPhotoIds.size} foto terpilih ke tempat sampah?`)) return;
                await sendBatchRequest("{{ route('album.destroy-batch') }}", Array.from(selectedPhotoIds));
            }

            // 2. Restore
            async function restoreSinglePhoto(id) {
                if (!confirm('Pulihkan foto ini?')) return;
                await sendBatchRequest("{{ route('album.restore-batch') }}", [id]);
            }

            async function restoreSelectedPhotos() {
                if (selectedPhotoIds.size === 0) return;
                if (!confirm(`Pulihkan ${selectedPhotoIds.size} foto terpilih?`)) return;
                await sendBatchRequest("{{ route('album.restore-batch') }}", Array.from(selectedPhotoIds));
            }

            // 3. Force Delete
            async function forceDeleteSinglePhoto(id) {
                if (!confirm('HAPUS PERMANEN foto ini? Berkas tidak akan dapat dikembalikan!')) return;
                await sendBatchRequest("{{ route('album.force-delete-batch') }}", [id]);
            }

            async function forceDeleteSelectedPhotos() {
                if (selectedPhotoIds.size === 0) return;
                if (!confirm(
                        `HAPUS PERMANEN ${selectedPhotoIds.size} foto terpilih? Berkas tidak akan dapat dikembalikan!`))
                    return;
                await sendBatchRequest("{{ route('album.force-delete-batch') }}", Array.from(selectedPhotoIds));
            }

            // Helper Send Request Batch
            async function sendBatchRequest(url, ids) {
                try {
                    const res = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            ids: ids
                        })
                    });

                    if (res.ok) {
                        loadAlbumPhotos();
                    } else {
                        const data = await res.json();
                        alert(data.message || 'Gagal memproses tindakan.');
                    }
                } catch (err) {
                    alert('Terjadi kesalahan koneksi.');
                }
            }
        </script>
    @endsection
