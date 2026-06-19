@extends('layouts.compact')

@section('content')
                
                <div class="row" id="cancel-row">
                
                    <div class="col-xl-12 col-lg-12 col-sm-12 layout-top-spacing layout-spacing">
                        
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="widget-content widget-content-area br-6">
                            <div class="d-flex justify-content-between align-items-center px-4 pt-3">
                                <h5 style="font-weight: bold;">Daftar Membership</h5>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#membershipModal" onclick="resetForm()">
                                    Tambah Membership
                                </button>
                            </div>
                            <hr>

                            <table id="invoice-list" class="table table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="checkbox-column"> No. </th>
                                        <th>Gambar</th>
                                        <th>Nama Paket</th>
                                        <th>Harga (Final)</th>
                                        <th>Diskon</th>
                                        <th>Limit Siswa / Beasiswa</th>
                                        <th>Masa Berlaku</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($memberships as $key => $ms)
                                    <tr>
                                        <td class="checkbox-column"> {{ $memberships->firstItem() + $key }} </td>
                                        <td>
                                            <div class="d-flex">
                                                <div class="usr-img-frame mr-2 rounded">
                                                    <img alt="gambar membership" class="img-fluid rounded" src="{{ asset('storage/' . $ms->gambar) }}" style="width: 50px; height: 50px; object-fit: cover;">
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="align-self-center mb-0" style="font-weight: 600;"> {{ $ms->nama }} </p>
                                        </td>
                                        <td>
                                            Rp {{ number_format($ms->harga_final, 0, ',', '.') }} 
                                            <br><small class="text-muted" style="text-decoration: line-through;">Rp {{ number_format($ms->harga, 0, ',', '.') }}</small>
                                        </td>
                                        <td>
                                            <span class="badge badge-danger">{{ $ms->diskon }}%</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-info">Siswa: {{ $ms->limit_siswa }}</span>
                                            <span class="badge badge-warning">Beasiswa: {{ $ms->limit_beasiswa }}</span>
                                        </td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($ms->masa_hingga)->translatedFormat('d F Y') }}
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink{{ $ms->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                                </a>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink{{ $ms->id }}">
                                                    <a class="dropdown-item action-edit" href="javascript:void(0);" 
                                                       onclick="editMembership({{ json_encode($ms) }})">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg> Edit
                                                    </a>
                                                    
                                                    <form action="{{ route('memberships.destroy', $ms->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data paket ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item action-delete text-danger" style="border: none; background: none; width: 100%;">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg> Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Tidak ada data membership.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            
                            <div class="p-3">
                                {{ $memberships->links() }}
                            </div>
                        </div>
                    </div>

                </div>

            {{-- Modal Create & Update --}}
            <div class="modal fade" id="membershipModal" tabindex="-1" role="dialog" aria-labelledby="membershipModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content" style="background: #fff; border-radius: 8px;">
                        <div class="modal-header">
                            <h5 class="modal-title" id="membershipModalLabel" style="font-weight: bold;">Tambah Membership</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                            </button>
                        </div>
                        <form id="membershipForm" action="{{ route('memberships.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div id="method-container"></div>

                            <div class="modal-body">
                                <div class="form-group mb-3">
                                    <label for="nama" style="font-weight: 600;">Nama Membership</label>
                                    <input type="text" id="nama" name="nama" class="form-control" required placeholder="Contoh: Premium School Pack">
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="harga" style="font-weight: 600;">Harga (Rp)</label>
                                        <input type="number" step="any" id="harga" name="harga" class="form-control" required placeholder="0">
                                    </div>
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="diskon" style="font-weight: 600;">Diskon (%)</label>
                                        <input type="number" step="any" id="diskon" name="diskon" class="form-control" required value="0" placeholder="0">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="limit_siswa" style="font-weight: 600;">Limit Siswa</label>
                                        <input type="number" id="limit_siswa" name="limit_siswa" class="form-control" required placeholder="0">
                                    </div>
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="limit_beasiswa" style="font-weight: 600;">Limit Beasiswa</label>
                                        <input type="number" id="limit_beasiswa" name="limit_beasiswa" class="form-control" required placeholder="0">
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="masa_hingga" style="font-weight: 600;">Masa Berlaku Hingga</label>
                                    <input type="date" id="masa_hingga" name="masa_hingga" class="form-control" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="gambar" style="font-weight: 600;">Gambar Banner Paket</label>
                                    <input type="file" id="gambar" name="gambar" class="form-control-file">
                                    <small id="gambar-help" class="form-text text-muted d-none">Kosongkan jika tidak ingin mengganti banner.</small>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        <script>
            function resetForm() {
                document.getElementById('membershipModalLabel').innerText = 'Tambah Membership';
                document.getElementById('membershipForm').action = "{{ route('memberships.store') }}";
                document.getElementById('method-container').innerHTML = ''; 
                
                document.getElementById('nama').value = '';
                document.getElementById('harga').value = '';
                document.getElementById('diskon').value = '0';
                document.getElementById('limit_siswa').value = '';
                document.getElementById('limit_beasiswa').value = '';
                document.getElementById('masa_hingga').value = '';
                document.getElementById('gambar').required = true;
                document.getElementById('gambar-help').classList.add('d-none');
            }

            function editMembership(membership) {
                document.getElementById('membershipModalLabel').innerText = 'Edit Membership';
                
                let url = "{{ route('memberships.update', ':id') }}";
                url = url.replace(':id', membership.id);
                document.getElementById('membershipForm').action = url;

                document.getElementById('method-container').innerHTML = `@method('PUT')`;

                // Populate fields
                document.getElementById('nama').value = membership.nama;
                document.getElementById('harga').value = membership.harga;
                document.getElementById('diskon').value = membership.diskon;
                document.getElementById('limit_siswa').value = membership.limit_siswa;
                document.getElementById('limit_beasiswa').value = membership.limit_beasiswa;
                document.getElementById('masa_hingga').value = membership.masa_hingga;
                
                // Gambar bersifat opsional pada proses update
                document.getElementById('gambar').required = false;
                document.getElementById('gambar-help').classList.remove('d-none');

                $('#membershipModal').modal('show');
            }
        </script>
@endsection