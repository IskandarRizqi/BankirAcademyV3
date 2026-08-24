@extends('layouts.compact')
@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{ activeTab: 'social_media', showImportModal: false, selectedLoker: null }">

        <!-- Header Page -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Review Draft Lowongan Kerja</h1>
                <p class="text-sm text-gray-500">Kelola dan verifikasi data hasil scraping dari sosial media & job
                    platform.</p>
            </div>
            <div class="flex gap-3">
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

        <!-- Alert / Notification Placeholders -->
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r text-sm">
                {{ session('success') }}
            </div>
        @endif

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
        <div x-show="activeTab === 'social_media'" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($drafts->where('source_type', 'social_media') as $item)
                <div
                    class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition">
                    <div class="p-5">
                        <div class="flex items-center justify-between gap-3 mb-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ $item->logo_url ?? 'https://via.placeholder.com/40' }}" alt="Logo"
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

                        <!-- AI Summary Callout -->
                        @if ($item->ringkasan_ai)
                            <div
                                class="bg-indigo-50/60 p-3 rounded-lg border border-indigo-100 text-xs text-indigo-900 mb-4">
                                <span class="font-bold text-indigo-600 block mb-1">✨ Ringkasan AI:</span>
                                <p class="line-clamp-2">{{ $item->ringkasan_ai }}</p>
                            </div>
                        @endif

                        <div class="space-y-2 text-xs text-gray-600 mb-4">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>{{ $item->provinsi_raw ?? ($item->alamat_raw ?? 'Lokasi tidak terdaftar') }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span
                                    class="font-semibold text-emerald-600">{{ $item->gaji_raw ?? 'Tidak Ditampilkan' }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <span class="truncate">{{ $item->email_perusahaan ?? ($item->instagram_dm ?? '-') }}</span>
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

                    <!-- Footer Action -->
                    <div class="bg-gray-50 px-5 py-3 border-t border-gray-100 flex gap-2">
                        <button
                            class="flex-1 px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-xs rounded transition text-center">Approve</button>
                        <button
                            class="px-3 py-1.5 bg-white border hover:bg-gray-100 text-gray-700 font-medium text-xs rounded transition">Tolak</button>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center text-gray-500 bg-white rounded-xl border border-dashed">
                    Tidak ada data draft dari Social Media.
                </div>
            @endforelse
        </div>

        <!-- TAB 2: JOB PLATFORM VIEW (Table Layout) -->
        <div x-show="activeTab === 'job_platform'"
            class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-gray-50 text-xs text-gray-700 uppercase border-b">
                        <tr>
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
                            <tr class="hover:bg-gray-50/50">
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
                                <td class="px-6 py-4 text-xs space-x-2">
                                    <a href="{{ $item->sumber_url }}" target="_blank"
                                        class="text-blue-600 hover:underline">Link</a>
                                    <button class="text-indigo-600 font-semibold hover:underline">Review</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                    Tidak ada data draft dari Job Platform.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- MODAL IMPORT EXCEL -->
        <div x-show="showImportModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title"
            role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="showImportModal" x-transition.opacity @click="showImportModal = false"
                    class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

                <div
                    class="inline-block align-bottom bg-white  rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form action="{{ route('loker-draft.import') }}" method="POST" enctype="multipart/form-data"
                        x-data="{ importType: 'social_media' }">
                        @csrf
                        <div class="bg-white px-6 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div
                                    class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-emerald-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <svg class="h-6 w-6 text-emerald-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                    <h3 class="text-lg font-bold text-gray-900" id="modal-title">Import Data Draft Loker
                                    </h3>
                                    <p class="text-xs text-gray-500 mt-1">Pilih jenis skema sumber data sebelum mengunggah
                                        file.</p>

                                    <!-- Pilihan Skema Import -->
                                    <div class="mt-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Sumber
                                            Data</label>
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

                                    <!-- Input File -->
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
                                class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-emerald-600 text-base font-medium text-white hover:bg-emerald-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                                Upload & Import
                            </button>
                            <button type="button" @click="showImportModal = false"
                                class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
