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
                        <div class="col-lg-4">
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
                        <div class="col-lg-4">
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
                        <div class="col-lg-4" hidden>
                            <label for="form-control">Company</label>
                            <input type="text" class="form-control" name="company" value="perorangan">
                            <small class="text-danger">Jika mempunyai wajib
                                di
                                isi</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-12">
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
                                    <label for="">No.
                                        Rekening</label>
                                    <input type="text" name="rekening" id="rekening" class="form-control" value="1">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label for="form-control">Jenis
                                        Kelamin</label>
                                    <select name="jenis_kelamin" class="form-control" id="jkl">
                                        <option value="">Pilih salah
                                            satu
                                        </option>
                                        <option value="0" {{ isset($pfl['gender'])&&$pfl['gender']==0 ? 'selected' :
                                            null }}>
                                            Perempuan</option>
                                        <option value="1" {{ isset($pfl['gender'])&&$pfl['gender']==1 ? 'selected' :
                                            null }}>
                                            Laki-laki</option>
                                    </select>
                                    @if ($errors->has('jenis_kelamin'))
                                    <div class="error" style="color: red; display:block;">
                                        {{ $errors->first('jenis_kelamin') }}
                                    </div>
                                    @endif
                                </div>
                                <div class="col-lg-6">
                                    <label for="form-control">Referral
                                        (optional)</label>
                                    <input type="text" id="referral" name="referral" class="form-control"
                                        onchange="referralKode('{{ isset($pfl['user_id'])?$pfl['user_id']:'' }}',$(this).val())"
                                        value="@if (isset($pfl['user_id'])){{ $pfl['referral'] ? $pfl['referral']['code'] : '' }}@endif"
                                        @if (isset($pfl['user_id'])){{ $pfl['referral'] ? 'readonly' : '' }}@endif>
                                    @if (Session::has('referral'))
                                    <div class="error" style="color: red; display:block;">
                                        {{ Session::get('referral') }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-9">
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
                            <label for="form-control">Foto</label>
                            <input type="file" class="form-control" name="picture" id="picture">
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
<div class="divider divider-border divider-center"><i class="icon-email2"></i>
</div>