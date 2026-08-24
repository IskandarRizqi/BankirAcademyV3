@extends('layouts.compact')

@section('content')
    <style>
        [x-cloak] {
            display: none !important;
        }

        .loker-detail-modal {
            z-index: 1100;
            padding: calc(var(--topbar-h) + 1rem) 1rem 1rem;
        }

        .loker-detail-modal__panel {
            max-height: calc(100vh - var(--topbar-h) - 2rem);
        }
    </style>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{
        activeTab: 'social_media',
        showImportModal: false,
        showDetailModal: false,
        selectedDraft: null,
        selectedIds: [],
        searchTerm: '',
    
        openDetail(item) {
            this.selectedDraft = item;
            this.showDetailModal = true;
        },
    
        toggleAll(event, type, items) {
            if (event.target.checked) {
                let filtered = items.filter(i => i.source_type === type).map(i => i.id);
                this.selectedIds = [...new Set([...this.selectedIds, ...filtered])];
            } else {
                let filteredIds = items.filter(i => i.source_type === type).map(i => i.id);
                this.selectedIds = this.selectedIds.filter(id => !filteredIds.includes(id));
            }
        },
    
        isAllSelected(type, items) {
            let filtered = items.filter(i => i.source_type === type);
            if (filtered.length === 0) return false;
            return filtered.every(i => this.selectedIds.includes(i.id));
        },
    
        // Logic Live Search Client-Side
        matchSearch(item) {
            if (!this.searchTerm.trim()) return true;
            let term = this.searchTerm.toLowerCase();
            let posisi = (item.posisi || '').toLowerCase();
            let perusahaan = (item.nama_perusahaan || '').toLowerCase();
            let lokasi = (item.provinsi_raw || item.alamat_raw || '').toLowerCase();
    
            return posisi.includes(term) || perusahaan.includes(term) || lokasi.includes(term);
        }
    }">

        <!-- Header Page -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Review Draft Lowongan Kerja</h1>
                <p class="text-sm text-gray-500">Kelola dan verifikasi data hasil scraping dari sosial media & job platform.
                </p>
            </div>
            <div class="flex items-center gap-3">
                <form action="{{ route('lokerdraft.bulk-destroy') }}" method="POST" x-show="selectedIds.length > 0" x-cloak
                    x-transition onsubmit="return confirm('Apakah Anda yakin ingin menghapus data yang dipilih?')">
                    @csrf
                    <template x-for="id in selectedIds" :key="id">
                        <input type="hidden" name="ids[]" :value="id">
                    </template>
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-medium transition shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Hapus Terpilih (<span x-text="selectedIds.length"></span>)
                    </button>
                </form>

                <button @click="showImportModal = true"
                    class="inline-flex items-center px-4 py-2 border border-emerald-600 text-emerald-700 bg-white hover:bg-emerald-50 rounded-lg text-sm font-medium transition shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 0115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                    Import Excel
                </button>
            </div>
        </div>

        <!-- Alert Notification -->
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r text-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Section Live Search & Filter -->
        <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm mb-6">
            <form method="GET" action="{{ route('lokerdraft.index') }}"
                class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Live Search Field -->
                <div class="relative">
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Live Search Instant</label>
                    <div class="relative">
                        <input type="text" x-model="searchTerm" placeholder="Cari langsung posisi/PT..."
                            class="w-full text-sm border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 pl-9 pr-8 py-2 border">
                        <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <button type="button" x-show="searchTerm.length > 0" @click="searchTerm = ''"
                            class="absolute right-2.5 top-2.5 text-gray-400 hover:text-gray-600 text-xs font-bold">
                            &times;
                        </button>
                    </div>
                </div>

                <!-- Server Filter Platform -->
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Filter Platform</label>
                    <select name="platform"
                        class="w-full text-sm border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 px-3 py-2 border">
                        <option value="">Semua Platform</option>
                        @foreach ($platforms as $plat)
                            <option value="{{ $plat }}" {{ request('platform') == $plat ? 'selected' : '' }}>
                                {{ $plat }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Server Filter Gaji -->
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Minimal Gaji (Rp)</label>
                    <input type="number" name="gaji_min" value="{{ request('gaji_min') }}" placeholder="Contoh: 3000000"
                        class="w-full text-sm border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 px-3 py-2 border">
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white text-sm px-4 py-2 rounded-lg font-medium transition">
                        Terapkan Filter
                    </button>
                    @if (request()->anyFilled(['platform', 'gaji_min']))
                        <a href="{{ route('lokerdraft.index') }}"
                            class="bg-gray-100 hover:bg-gray-200 text-gray-600 text-sm px-3 py-2 rounded-lg transition text-center">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Navigation Tabs -->
        <div class="border-b border-gray-200 mb-6">
            <nav class="-mb-px flex space-x-8">
                <button @click="activeTab = 'social_media'"
                    :class="activeTab === 'social_media' ? 'border-indigo-500 text-indigo-600' :
                        'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center gap-2">
                    <svg class="w-5 h-5 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                    </svg>
                    Social Media
                    <span class="ml-2 bg-indigo-100 text-indigo-600 py-0.5 px-2.5 rounded-full text-xs font-semibold">
                        {{ $drafts->where('source_type', 'social_media')->count() }}
                    </span>
                </button>

                <button @click="activeTab = 'job_platform'"
                    :class="activeTab === 'job_platform' ? 'border-indigo-500 text-indigo-600' :
                        'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Job Platform
                    <span class="ml-2 bg-blue-100 text-blue-600 py-0.5 px-2.5 rounded-full text-xs font-semibold">
                        {{ $drafts->where('source_type', 'job_platform')->count() }}
                    </span>
                </button>
            </nav>
        </div>

        <!-- TAB 1: SOCIAL MEDIA VIEW (Grid Card Layout) -->
        <div x-show="activeTab === 'social_media'" class="space-y-4">
            @if ($drafts->where('source_type', 'social_media')->count() > 0)
                <div class="flex items-center gap-2 bg-white p-3 rounded-lg border border-gray-200">
                    <input type="checkbox" :checked="isAllSelected('social_media', {{ json_encode($drafts) }})"
                        @change="toggleAll($event, 'social_media', {{ json_encode($drafts) }})"
                        class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 h-4 w-4">
                    <span class="text-sm font-medium text-gray-700">Pilih Semua Social Media</span>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($drafts->where('source_type', 'social_media') as $item)
                    <div x-show="matchSearch({{ json_encode($item) }})"
                        class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition relative flex flex-col justify-between">
                        <div class="p-5">
                            <div class="flex items-start justify-between gap-3 mb-4">
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" value="{{ $item->id }}" x-model="selectedIds"
                                        class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 h-4 w-4">

                                    <img src="{{ $item->logo_url }}" alt="Logo"
                                        onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($item->nama_perusahaan ?? 'Loker') }}&background=0D8ABC&color=fff';"
                                        class="w-10 h-10 rounded-full object-cover border">

                                    <div>
                                        <h3 class="font-bold text-gray-900 line-clamp-1">{{ $item->posisi }}</h3>
                                        <p class="text-xs text-gray-500 line-clamp-1">
                                            {{ $item->nama_perusahaan ?? 'Perusahaan Tidak Diketahui' }}</p>
                                    </div>
                                </div>
                                <span
                                    class="px-2.5 py-1 text-xs font-semibold rounded-full bg-pink-50 text-pink-700 border border-pink-200">
                                    {{ $item->platform }}
                                </span>
                            </div>

                            @if ($item->ringkasan_ai)
                                <div
                                    class="bg-indigo-50/60 p-3 rounded-lg border border-indigo-100 text-xs text-indigo-900 mb-4">
                                    <span class="font-bold text-indigo-600 block mb-1">✨ Ringkasan AI:</span>
                                    <p class="line-clamp-2">{{ $item->ringkasan_ai }}</p>
                                </div>
                            @endif

                            <div class="space-y-2 text-xs text-gray-600 mb-4">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span>{{ $item->provinsi_raw ?? ($item->alamat_raw ?? 'Lokasi tidak terdaftar') }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span
                                        class="font-semibold text-emerald-600">{{ $item->gaji_raw ?? 'Tidak Ditampilkan' }}</span>
                                </div>
                            </div>

                            <div class="pt-3 border-t flex justify-between items-center text-xs">
                                <a href="{{ $item->sumber_url }}" target="_blank"
                                    class="text-indigo-600 hover:underline inline-flex items-center">
                                    Sumber Post
                                    <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                </a>
                                <span
                                    class="text-gray-400">{{ $item->tanggal_posting ? $item->tanggal_posting->diffForHumans() : '-' }}</span>
                            </div>
                        </div>

                        <div class="bg-gray-50 px-5 py-3 border-t border-gray-100 flex gap-2 items-center">
                            <button @click="openDetail({{ json_encode($item) }})"
                                class="flex-1 px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-xs rounded transition text-center">
                                Detail Loker
                            </button>
                            <form action="{{ route('lokerdraft.destroy', $item->id) }}" method="POST"
                                onsubmit="return confirm('Yakin hapus draft ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-3 py-1.5 bg-white border border-red-200 hover:bg-red-50 text-red-600 font-medium text-xs rounded transition">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-12 text-center text-gray-500 bg-white rounded-xl border border-dashed">
                        Tidak ada data draft dari Social Media.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- TAB 2: JOB PLATFORM VIEW (Table Layout) -->
        <div x-show="activeTab === 'job_platform'"
            class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-gray-50 text-xs text-gray-700 uppercase border-b">
                        <tr>
                            <th class="px-4 py-3 w-10">
                                <input type="checkbox"
                                    :checked="isAllSelected('job_platform', {{ json_encode($drafts) }})"
                                    @change="toggleAll($event, 'job_platform', {{ json_encode($drafts) }})"
                                    class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 h-4 w-4">
                            </th>
                            <th class="px-6 py-3">Posisi & Perusahaan</th>
                            <th class="px-6 py-3">Platform</th>
                            <th class="px-6 py-3">Lokasi</th>
                            <th class="px-6 py-3">Gaji Estimasi</th>
                            <th class="px-6 py-3">Tipe</th>
                            <th class="px-6 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($drafts->where('source_type', 'job_platform') as $item)
                            <tr x-show="matchSearch({{ json_encode($item) }})" class="hover:bg-gray-50/50">
                                <td class="px-4 py-4">
                                    <input type="checkbox" value="{{ $item->id }}" x-model="selectedIds"
                                        class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 h-4 w-4">
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-900">{{ $item->posisi }}</div>
                                    <div class="text-xs text-gray-500">{{ $item->nama_perusahaan ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $item->platform }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-xs">{{ $item->provinsi_raw ?? '-' }}</td>
                                <td class="px-6 py-4 text-xs font-semibold text-emerald-600">
                                    {{ $item->gaji_raw ?? 'Kompetitif' }}</td>
                                <td class="px-6 py-4 text-xs">
                                    <span
                                        class="bg-gray-100 text-gray-800 px-2 py-0.5 rounded border">{{ $item->tipe_pekerjaan ?? 'Fulltime' }}</span>
                                </td>
                                <td class="px-6 py-4 text-xs">
                                    <div class="flex items-center space-x-3">
                                        <a href="{{ $item->sumber_url }}" target="_blank"
                                            class="text-blue-600 hover:underline">Link</a>
                                        <button @click="openDetail({{ json_encode($item) }})"
                                            class="text-indigo-600 font-semibold hover:underline">Detail</button>
                                        <form action="{{ route('lokerdraft.destroy', $item->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin hapus draft ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-600 hover:underline font-semibold">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                    Tidak ada data draft dari Job Platform.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- MODAL IMPORT EXCEL -->
        <div x-show="showImportModal" x-cloak
            class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4" aria-labelledby="modal-title"
            role="dialog" aria-modal="true">
            <div x-show="showImportModal" x-transition.opacity @click="showImportModal = false"
                class="fixed inset-0 bg-gray-500/75 transition-opacity"></div>

            <div
                class="relative bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all w-full max-w-lg z-10">
                <form action="{{ route('loker-draft.import') }}" method="POST" enctype="multipart/form-data"
                    x-data="{ importType: 'social_media' }">
                    @csrf
                    <div class="bg-white px-6 pt-5 pb-4 sm:p-6">
                        <div class="sm:flex sm:items-start">
                            <div
                                class="mx-auto flex-shrink-0 flex items-center justify-center h-10 w-10 rounded-full bg-emerald-100 sm:mx-0">
                                <svg class="h-6 w-6 text-emerald-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg font-bold text-gray-900" id="modal-title">Import Data Draft Loker</h3>
                                <p class="text-xs text-gray-500 mt-1">Pilih jenis skema sumber data sebelum mengunggah
                                    file.</p>

                                <div class="mt-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Sumber Data</label>
                                    <div class="grid grid-cols-2 gap-3">
                                        <label
                                            class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50"
                                            :class="importType === 'social_media' ? 'border-indigo-500 bg-indigo-50/30' :
                                                'border-gray-200'">
                                            <input type="radio" name="source_type" value="social_media"
                                                x-model="importType" class="text-indigo-600 focus:ring-indigo-500">
                                            <span class="ml-2 text-xs font-semibold text-gray-700">Social Media</span>
                                        </label>
                                        <label
                                            class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50"
                                            :class="importType === 'job_platform' ? 'border-blue-500 bg-blue-50/30' :
                                                'border-gray-200'">
                                            <input type="radio" name="source_type" value="job_platform"
                                                x-model="importType" class="text-blue-600 focus:ring-blue-500">
                                            <span class="ml-2 text-xs font-semibold text-gray-700">Job Platform</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="mt-4" x-show="importType === 'job_platform'" x-cloak>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Platform</label>
                                    <select name="platform"
                                        class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:ring-blue-500 focus:border-blue-500">
                                        <option value="JobStreet">JobStreet</option>
                                        <option value="Glints">Glints</option>
                                    </select>
                                </div>

                                <div class="mt-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Pilih File (.xlsx,
                                        .csv)</label>
                                    <input type="file" name="file_excel" required accept=".xlsx, .xls, .csv"
                                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 border border-gray-300 rounded-lg p-1">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t">
                        <button type="submit"
                            class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-emerald-600 text-base font-medium text-white hover:bg-emerald-700 sm:ml-3 sm:w-auto sm:text-sm">
                            Upload & Import
                        </button>
                        <button type="button" @click="showImportModal = false"
                            class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- MODAL DETAIL LOKER DRAFT -->
        <div x-show="showDetailModal" x-cloak
            class="loker-detail-modal fixed inset-0 flex items-center justify-center overflow-y-auto"
            aria-labelledby="modal-title" role="dialog" aria-modal="true">

            <!-- Backdrop Dark Overlay -->
            <div x-show="showDetailModal" x-transition.opacity @click="showDetailModal = false"
                class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity"></div>

            <!-- Modal Container Body (Diubah ke max-w-5xl & my-auto agar center sempurna) -->
            <div x-show="showDetailModal" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="loker-detail-modal__panel relative bg-white rounded-2xl text-left shadow-2xl transform transition-all w-full max-w-5xl flex flex-col z-10 overflow-hidden">

                <template x-if="selectedDraft">
                    <div class="flex flex-col h-full overflow-hidden">

                        <!-- Header Modal Detail (Sticky Top) -->
                        <div
                            class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center shrink-0">
                            <div class="flex items-center gap-3">
                                <img :src="selectedDraft.logo_url"
                                    onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=Loker&background=0D8ABC&color=fff';"
                                    class="w-11 h-11 rounded-full border border-gray-200 object-cover shadow-sm">
                                <div>
                                    <h3 class="text-base sm:text-lg font-bold text-gray-900 leading-tight"
                                        x-text="selectedDraft.posisi"></h3>
                                    <p class="text-xs text-gray-500 mt-0.5"
                                        x-text="selectedDraft.nama_perusahaan ?? 'Perusahaan Tidak Diketahui'"></p>
                                </div>
                            </div>
                            <button @click="showDetailModal = false"
                                class="p-1.5 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-200 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <!-- Body Content Detail (Scrollable Internal) -->
                        <div class="p-6 overflow-y-auto space-y-6 text-sm text-gray-700 flex-1">

                            <!-- Grid Info Utama (Diubah ke 3-4 kolom untuk memanfaatkan area lebar) -->
                            <div
                                class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 bg-gray-50 p-4 rounded-xl border border-gray-100">
                                <div>
                                    <span
                                        class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider">Platform</span>
                                    <span class="font-medium text-gray-900" x-text="selectedDraft.platform"></span>
                                </div>
                                <div>
                                    <span class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider">Tipe
                                        Pekerjaan</span>
                                    <span class="font-medium text-gray-900"
                                        x-text="selectedDraft.tipe_pekerjaan ?? 'Fulltime'"></span>
                                </div>
                                <div>
                                    <span
                                        class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider">Estimasi
                                        Gaji</span>
                                    <span class="font-semibold text-emerald-600"
                                        x-text="selectedDraft.gaji_raw ?? 'Kompetitif'"></span>
                                </div>
                                <div>
                                    <span
                                        class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider">Provinsi/Lokasi</span>
                                    <span class="font-medium text-gray-900"
                                        x-text="selectedDraft.provinsi_raw ?? selectedDraft.alamat_raw ?? '-'"></span>
                                </div>
                                <div>
                                    <span
                                        class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider">Kategori</span>
                                    <span class="font-medium text-gray-900"
                                        x-text="selectedDraft.kategori_bidang ?? '-'"></span>
                                </div>
                                <div>
                                    <span class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider">Batas
                                        Pendaftaran</span>
                                    <span class="font-medium text-red-600"
                                        x-text="selectedDraft.batas_pendaftaran ?? '-'"></span>
                                </div>
                            </div>

                            <!-- Ringkasan AI -->
                            <template x-if="selectedDraft.ringkasan_ai">
                                <div>
                                    <h4
                                        class="font-bold text-indigo-700 mb-1.5 flex items-center gap-1.5 text-xs uppercase tracking-wider">
                                        <span>✨</span> Ringkasan AI
                                    </h4>
                                    <p class="bg-indigo-50/60 border border-indigo-100 p-3.5 rounded-xl text-xs text-indigo-950 leading-relaxed"
                                        x-text="selectedDraft.ringkasan_ai"></p>
                                </div>
                            </template>

                            <!-- Informasi Kontak & Pendaftaran (Diubah ke 3 kolom) -->
                            <div>
                                <h4 class="font-bold text-gray-900 mb-2 text-xs uppercase tracking-wider">Informasi Kontak
                                    & Aplikasi</h4>
                                <div
                                    class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 bg-white p-3.5 rounded-xl border border-gray-200 text-xs">
                                    <div class="flex items-center gap-2" x-show="selectedDraft.email_perusahaan">
                                        <span class="font-semibold text-gray-400">Email:</span>
                                        <span class="text-gray-800 font-medium truncate"
                                            x-text="selectedDraft.email_perusahaan"></span>
                                    </div>
                                    <div class="flex items-center gap-2" x-show="selectedDraft.no_hp">
                                        <span class="font-semibold text-gray-400">No HP/WA:</span>
                                        <span class="text-gray-800 font-medium" x-text="selectedDraft.no_hp"></span>
                                    </div>
                                    <div class="flex items-center gap-2" x-show="selectedDraft.instagram_dm">
                                        <span class="font-semibold text-gray-400">Instagram:</span>
                                        <span class="text-gray-800 font-medium"
                                            x-text="selectedDraft.instagram_dm"></span>
                                    </div>
                                    <div class="flex items-center gap-2 col-span-1 sm:col-span-2 md:col-span-3"
                                        x-show="selectedDraft.website_form_url">
                                        <span class="font-semibold text-gray-400">Form URL:</span>
                                        <a :href="selectedDraft.website_form_url" target="_blank"
                                            class="text-indigo-600 hover:underline truncate"
                                            x-text="selectedDraft.website_form_url"></a>
                                    </div>
                                </div>
                            </div>

                            <!-- Jobdesk & Kualifikasi Berdampingan jika di Layar Lebar -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Jobdesk -->
                                <div x-show="selectedDraft.jobdesk || selectedDraft.deskripsi_pekerjaan">
                                    <h4 class="font-bold text-gray-900 mb-1.5 text-xs uppercase tracking-wider">Tugas &
                                        Tanggung Jawab</h4>
                                    <div class="whitespace-pre-line text-xs bg-gray-50 border border-gray-100 p-3.5 rounded-xl text-gray-600 leading-relaxed h-full"
                                        x-text="selectedDraft.jobdesk ?? selectedDraft.deskripsi_pekerjaan"></div>
                                </div>

                                <!-- Kualifikasi & Skill -->
                                <div x-show="selectedDraft.kualifikasi_jobspek || selectedDraft.keahlian_skill">
                                    <h4 class="font-bold text-gray-900 mb-1.5 text-xs uppercase tracking-wider">Kualifikasi
                                        & Keahlian</h4>
                                    <div
                                        class="whitespace-pre-line text-xs bg-gray-50 border border-gray-100 p-3.5 rounded-xl text-gray-600 leading-relaxed space-y-2 h-full">
                                        <p x-show="selectedDraft.kualifikasi_jobspek"><strong
                                                class="text-gray-800">Kualifikasi:</strong> <span
                                                x-text="selectedDraft.kualifikasi_jobspek"></span></p>
                                        <p x-show="selectedDraft.keahlian_skill"><strong class="text-gray-800">Skill
                                                Dibutuhkan:</strong> <span x-text="selectedDraft.keahlian_skill"></span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Cara Melamar & Fasilitas -->
                            <div x-show="selectedDraft.cara_melamar || selectedDraft.fasilitas">
                                <h4 class="font-bold text-gray-900 mb-1.5 text-xs uppercase tracking-wider">Cara Melamar &
                                    Fasilitas</h4>
                                <div
                                    class="whitespace-pre-line text-xs bg-gray-50 border border-gray-100 p-3.5 rounded-xl text-gray-600 leading-relaxed space-y-2">
                                    <p x-show="selectedDraft.cara_melamar"><strong class="text-gray-800">Cara
                                            Melamar:</strong> <span x-text="selectedDraft.cara_melamar"></span></p>
                                    <p x-show="selectedDraft.fasilitas"><strong
                                            class="text-gray-800">Fasilitas/Benefit:</strong> <span
                                            x-text="selectedDraft.fasilitas"></span></p>
                                </div>
                            </div>

                        </div>

                        <!-- Footer Modal Detail (Sticky Bottom) -->
                        <div
                            class="bg-gray-50 px-6 py-3.5 border-t border-gray-200 flex justify-between items-center shrink-0">
                            <a :href="selectedDraft.sumber_url" target="_blank"
                                class="text-xs text-indigo-600 font-bold hover:underline inline-flex items-center gap-1">
                                Buka Tautan Asli Post
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                            </a>
                            <button type="button" @click="showDetailModal = false"
                                class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 text-xs font-semibold rounded-lg transition">
                                Tutup
                            </button>
                        </div>

                    </div>
                </template>
            </div>
        </div>

    </div>
@endsection
