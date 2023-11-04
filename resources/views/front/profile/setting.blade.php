<style>
    .caption {
        position: absolute;
        top: 10%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        color: white;
        font-weight: bold;
    }
</style>
<div class="tabs tabs-alt clearfix ui-tabs ui-corner-all ui-widget ui-widget-content" id="tab-7">
    <ul class="tab-nav clearfix ui-tabs-nav ui-corner-all ui-helper-reset ui-helper-clearfix ui-widget-header"
        role="tablist">
        <li role="tab" tabindex="0"
            class="ui-tabs-tab ui-corner-top ui-state-default ui-tab ui-tabs-active ui-state-active"
            aria-controls="tabs-25" aria-labelledby="ui-id-9" aria-selected="true" aria-expanded="true"><a
                href="#tabs-25" tabindex="-1" class="ui-tabs-anchor" id="ui-id-9">Profile</a>
        </li>
        <li role="tab" tabindex="-1" class="ui-tabs-tab ui-corner-top ui-state-default ui-tab" aria-controls="tabs-26"
            aria-labelledby="ui-id-10" aria-selected="false" aria-expanded="false"><a href="#tabs-26" tabindex="-1"
                class="ui-tabs-anchor" id="ui-id-10">Rekening</a>
        </li>
        {{-- <li role="tab" tabindex="-1" class="ui-tabs-tab ui-corner-top ui-state-default ui-tab"
            aria-controls="tabs-27" aria-labelledby="ui-id-11" aria-selected="false" aria-expanded="false"><a
                href="#tabs-27" tabindex="-1" class="ui-tabs-anchor" id="ui-id-11">Proin
                dolor</a></li>
        <li class="hidden-phone ui-tabs-tab ui-corner-top ui-state-default ui-tab" role="tab" tabindex="-1"
            aria-controls="tabs-28" aria-labelledby="ui-id-12" aria-selected="false" aria-expanded="false"><a
                href="#tabs-28" tabindex="-1" class="ui-tabs-anchor" id="ui-id-12">Aenean lacinia</a></li>
        --}}
    </ul>
    <div class="tab-container">
        <div class="tab-content clearfix ui-tabs-panel ui-corner-bottom ui-widget-content" id="tabs-25"
            aria-labelledby="ui-id-9" role="tabpanel" aria-hidden="false">
            <div class="title-block">
                {{-- <h4>Update Profile</h4> --}}
                <form action="{{ route('profile.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        @if ($user->corporates)
                        <?php $corporate = true; ?>
                        <input type="text" name="idcorporate" value="{{$user->corporates->id_corporate}}" hidden>
                        @else
                        <?php $corporate = false; ?>
                        @endif
                        <input type="text" name="iscorporate" value="<?= $corporate ?>" hidden>
                        <div class="col-md-3" {{$corporate?'':'hidden'}}>
                            <label for="form-control">Jenis Corporate</label>
                            <select name="jenis_corporate" class="form-control" id="jenis_corporate"
                                data-show-subtext="true" data-live-search="true">
                                <option value="">Pilih</option>
                                @if ($corporate)
                                <option value="bankumum" {{$user->
                                    corporates->jenis_corporate=='bankumum'?'selected':''}}>Bank
                                    Umum</option>
                                <option value="bpr" {{$user->corporates->jenis_corporate=='bpr'?'selected':''}}>BPR
                                </option>
                                <option value="koperasi" {{$user->
                                    corporates->jenis_corporate=='koperasi'?'selected':''}}>Koperasi</option>
                                <option value="lkm" {{$user->corporates->jenis_corporate=='lkm'?'selected':''}}>Lembaga
                                    Keuangan Mikro</option>
                                @else
                                <option value="bankumum">Bank Umum</option>
                                <option value="bpr">BPR</option>
                                <option value="koperasi">Koperasi</option>
                                <option value="lkm">Lembaga Keuangan Mikro</option>
                                @endif
                            </select>
                        </div>
                        <div class="col-md-6" {{$corporate?'':'hidden'}}>
                            <label for="form-control">Nama Corporate</label>
                            <select name="nama_lengkap" class="form-control" id="nama_lengkap" data-show-subtext="true"
                                data-live-search="true">
                                <option value="">Pilih</option>
                            </select>
                        </div>
                        <div class="col-lg-9" {{$corporate?'hidden':''}}>
                            <label for="form-control">Nama lengkap</label>
                            <input type="text" class="form-control" name="nama_lengkap"
                                value="{{ isset($pfl['name'])?$pfl['name']:'' }}">
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                            @if ($errors->has('nama_lengkap'))
                            <div class="error" style="color: red; display:block;">
                                {{ $errors->first('nama_lengkap') }}
                            </div>
                            @endif
                        </div>
                        <div class="col-lg-3">
                            <label for="form-control">Nomor
                                handphone</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">+62</span>
                                </div>
                                <input type="text" class="form-control" name="nomor_handphone"
                                    value="{{ isset($pfl['phone'])?$pfl['phone']:'' }}">
                            </div>
                            @if ($errors->has('nomor_handphone'))
                            <div class="error" style="color: red; display:block;">
                                {{ $errors->first('nomor_handphone') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-12" {{$corporate?'hidden':''}}>
                                    <label for="form-control">Tanggal
                                        lahir</label>
                                    <input type="date" name="tanggal_lahir" class="form-control"
                                        value="{{ isset($pfl['tanggal_lahir'])?$pfl['tanggal_lahir']:'' }}">
                                    @if ($errors->has('tanggal_lahir'))
                                    <div class="error" style="color: red; display:block;">
                                        {{ $errors->first('tanggal_lahir') }}
                                    </div>
                                    @endif
                                </div>
                                <div class="col-lg-6" hidden>
                                    <label for="">No. Rekening</label>
                                    <input type="text" name="rekening" id="rekening" class="form-control" value="1">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6" {{$corporate?'hidden':''}}>
                            <label for="form-control">Jenis
                                Kelamin</label>
                            <select name="jenis_kelamin" class="form-control" id="jkl">
                                <option value="">Pilih salah
                                    satu
                                </option>
                                <option value="0" {{ isset($pfl['gender'])&&$pfl['gender']==0 ? 'selected' : null }}>
                                    Perempuan</option>
                                <option value="1" {{ isset($pfl['gender'])&&$pfl['gender']==1 ? 'selected' : null }}>
                                    Laki-laki</option>
                            </select>
                            @if ($errors->has('jenis_kelamin'))
                            <div class="error" style="color: red; display:block;">
                                {{ $errors->first('jenis_kelamin') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="form-control">Alamat</label>
                            <textarea class="form-control"
                                name="alamat">{{ isset($pfl['description'])?$pfl['description']:'' }}</textarea>
                            @if ($errors->has('alamat'))
                            <div class="error" style="color: red; display:block;">
                                {{ $errors->first('alamat') }}
                            </div>
                            @endif
                        </div>
                        <div class="col-lg-3">
                            <label for="form-control">Referral
                                (optional)</label>
                            <input type="text" id="referral" name="referral" class="form-control"
                                onchange="referralKode('{{ isset($pfl['user_id'])?$pfl['user_id']:'' }}',$(this).val())"
                                value="@if (isset($pfl['code'])){{ $pfl['code'] ? $pfl['code'] : '' }}@endif"
                                @if(isset($pfl['code'])){{ $pfl['code'] ? 'readonly' : '' }}@endif>
                            @if (Session::has('referral'))
                            <div class="error" style="color: red; display:block;">
                                {{ Session::get('referral') }}
                            </div>
                            @endif
                        </div>
                        <div class="col-lg-3">
                            <label for="form-control">{{$corporate?'Logo':'Foto'}}</label>
                            <input type="file" class="form-control" name="picture" id="picture"
                                accept="image/png, image/gif, image/jpeg">
                            <img id="pictureprv" src="{{ isset($pfl['picture'])?$pfl['picture']:'' }}" alt=""
                                width="80px">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <button class="button button-small" type="submit">Update
                                Profile</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="tab-content clearfix ui-tabs-panel ui-corner-bottom ui-widget-content" id="tabs-26"
            aria-labelledby="ui-id-10" role="tabpanel" aria-hidden="true" style="display: none;">
            <div class="title-block">
                {{-- <h4>Update Rekening</h4> --}}
                <form action="/updaterekening" method="post">
                    @csrf
                    <input type="text" name="user_id" id="user_id" value="{{ Auth::user()->id }}" hidden>
                    <div class="row">
                        <div class="form-group col">
                            <label for="">Nama Bank</label>
                            <input type="text" name="nama_bank" id="nama_bank" class="form-control"
                                value="{{ $user->rekening ? $user->rekening->nama_bank : '' }}" required>
                        </div>
                        <div class="form-group col">
                            <label for="">No Rekening</label>
                            <input type="text" name="no_rekening" id="no_rekening" class="form-control"
                                value="{{ $user->rekening ? $user->rekening->no_rekening : '' }}" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <button class="button button-small" type="submit">Update
                                Rekening</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="divider divider-border divider-center"><i class="icon-email2"></i></div>
<h3 class="text-center text-uppercase">Upgrade Akun</h3>
<div class="title-block">
    <form action="/updatemember" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="text" name="user_id" id="user_id" value="{{ Auth::user()->id }}" hidden>
        <input type="text" name="status_membership" id="status_membership" value="2" hidden>
        <div class="row">
            <div class="col-lg-3">
                <label for="form-control">Bukti Pembayaran</label>
                <input type="file" class="form-control" name="image_bukti_pembayaran" id="image_bukti_pembayaran"
                    accept="image/png, image/gif, image/jpeg">
                <img id="pctrbuktipembayaran" src="" alt="" width="500px">
                @error('image_bukti_pembayaran')
                <div class="text-danger">{{$message}}</div>
                @enderror
                <button class="btn btn-primary mt-2">Simpan</button>
            </div>
            @if($user->profile)
            @if($user->profile->status_membership == 1)
            <div class="col-lg-9">
                <img src="{{asset('front/images/A_MEMBER.jpg')}}" alt="">
                <div class="caption text-center" style="font-size: 2vw"><b>Masa Aktif :
                        {{$user->profile->masa_aktif_membership}}</b></div>
            </div>
            @else
            <div class="col-lg-9">
                <img src="{{asset('front/images/A_BLM_MEMBER.jpg')}}" alt="">
                <div class="caption text-center" style="font-size: 2vw">
                    {{-- <b>Masa Aktif : 20/10/2030</b> --}}
                </div>
            </div>
            @endif
            @else
            <div class="col-lg-9">
                <img src="{{asset('front/images/A_BLM_MEMBER.jpg')}}" alt="">
                <div class="caption text-center" style="font-size: 2vw">
                    {{-- <b>Masa Aktif : 20/10/2030</b> --}}
                </div>
            </div>
            @endif
        </div>
    </form>
</div>

<script>
    $(document).ready(function () {
        $('#jenis_corporate').change();
    })
    $('#jenis_corporate').on('change', function () {
        let val = $('#jenis_corporate').val();
        let idc = $('#idcorporate').val();
        let corp = '';
        if (idc) {
            corp = idc;
        }
        console.log(idc);
        $('#corporate').val(null);
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        jQuery.ajax({
            url: "/admin/corporates/"+val,
            method: 'get',
            success: function(result) {
                // console.log(result);
                let h = '';
                result.forEach(element => {
                    if (element.id == corp) {
                        h+='<option value="'+element.id+'" selected>'+element.nama+'</option>';
                    }else{
                        h+='<option value="'+element.id+'">'+element.nama+'</option>';
                    }
                });
                $('#nama_lengkap').html(h);
            },
            error: function(jqXhr, json, errorThrown) { // this are default for ajax errors 
                var errors = jqXhr.responseJSON;
                console.log(errors);
    
            }
        })
    })
</script>