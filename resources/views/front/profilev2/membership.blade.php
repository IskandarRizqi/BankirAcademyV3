<style>
    ::marker {
        /* color: red; */
    }

    .top-50 {
        top: 50%;
    }

    .m-500 {
        margin: 500px;
    }

    /* Extra small devices (phones, 600px and down) */
    @media only screen and (max-width: 600px) {
        .top-50 {
            top: 10%;
        }

        .m-500 {
            margin: 1670px;
        }
    }

    /* Small devices (portrait tablets and large phones, 600px and up) */
    @media only screen and (min-width: 600px) {}

    /* Medium devices (landscape tablets, 768px and up) */
    @media only screen and (min-width: 768px) {}

    /* Large devices (laptops/desktops, 992px and up) */
    /* @media only screen and (min-width: 992px) {} */

    /* Extra large devices (large laptops and desktops, 1200px and up) */
    /* @media only screen and (min-width: 1200px) {} */
</style>
<section id="content">
    <img src="/GambarV2/frame.png" alt="" width="100%">
    <div class="bungkusframe">
        <div class="row text-center top-50" style="
    position: absolute;
    left: 0;
    right: 0;
    padding: 60px;
    ">
            @foreach($member as $key => $value)
            @if($key == 0)
            <div class="col-lg-4 mb-2">
                <div class="card" style="border-radius:10px;">
                    <div class="card-body m-0 p-0">
                        <div class="header text-center text-white p-4"
                            style="border-radius:10px; background-image: linear-gradient(#FF5252,#FFAF52)">
                            Basic
                        </div>
                        <h3 class="" style="margin-top: 30px">Masa Aktif 3 Tahun</h3>
                        <div class="bodynya">
                            <div class="p-2 text-left" style="margin-left: 20px">
                                {!!html_entity_decode($value->keterangan)!!}
                            </div>
                            {{-- <div class="d-flex ml-1 mb-2">
                                <svg class="mr-2" width="80" height="34" viewBox="0 0 34 34" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M25.2112 8.31299L27.4892 9.91099L17.6122 24.157H15.3342L9.82617 16.439L12.1042 14.314L16.4732 18.394L25.2112 8.31299Z"
                                        fill="#0FA958" />
                                </svg>
                                <p class="m-0 text-left">
                                    Limit loker 780 dawd awudwd uahw duahwidhawiudauh dua hduiahdiuawhd iuawdahidha
                                    wdhuaiwdi
                                </p>
                            </div> --}}
                            <button class="btn mt-2 btn-block" onclick="openmember({{$value}})"
                                style="background-image: linear-gradient(#FF5252,#FFAF52)">Daftar</button>
                        </div>
                    </div>
                </div>
            </div>

            @endif
            @if($key == 1)
            <div class="col-lg-4 mb-2">
                <div class="card" style="border-radius:10px;">
                    <div class="card-body m-0 p-0">
                        <div class="header text-center text-white p-4"
                            style="border-radius:10px; background-image: linear-gradient(#FF5F5F,#FF1F98)">
                            Standard
                        </div>
                        <h3 class="" style="margin-top: 30px">Masa Aktif 3 Tahun</h3>
                        <div class="bodynya">
                            <div class="p-2 text-left" style="margin-left: 20px">
                                {!!html_entity_decode($value->keterangan)!!}
                            </div>
                            {{-- <div class="d-flex ml-1 mb-2">
                                <svg class="mr-2" width="80" height="34" viewBox="0 0 34 34" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M25.2112 8.31299L27.4892 9.91099L17.6122 24.157H15.3342L9.82617 16.439L12.1042 14.314L16.4732 18.394L25.2112 8.31299Z"
                                        fill="#0FA958" />
                                </svg>
                                <p class="m-0 text-left">
                                    Limit loker 780 dawd awudwd uahw duahwidhawiudauh dua hduiahdiuawhd iuawdahidha
                                    wdhuaiwdi
                                </p>
                            </div> --}}
                            <button class="btn mt-2 btn-block" onclick="openmember({{$value}})"
                                style="background-image: linear-gradient(#FF5F5F,#FF1F98)">Daftar</button>
                        </div>
                    </div>
                </div>
            </div>

            @endif
            @if($key == 2)
            <div class="col-lg-4 mb-2">
                <div class="card" style="border-radius:10px;">
                    <div class="card-body m-0 p-0">
                        <div class="header text-center text-white p-4"
                            style="border-radius:10px; background-image: linear-gradient(#7F00FF,#FF00C7)">
                            Premium
                        </div>
                        <h3 class="" style="margin-top: 30px">Masa Aktif 3 Tahun</h3>
                        <div class="bodynya">
                            <div class="p-2 text-left" style="margin-left: 20px">
                                {!!$value->keterangan!!}
                            </div>
                            {{-- <div class="d-flex">
                                <svg class="mr-2" width="80" height="34" viewBox="0 0 34 34" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M25.2112 8.31299L27.4892 9.91099L17.6122 24.157H15.3342L9.82617 16.439L12.1042 14.314L16.4732 18.394L25.2112 8.31299Z"
                                        fill="#0FA958" />
                                </svg>
                                <p class="m-0 text-left">
                                    Limit loker 780 dawd awudwd uahw duahwidhawiudauh dua hduiahdiuawhd iuawdahidha
                                    wdhuaiwdi
                                </p>
                            </div> --}}
                            <button class="btn mt-2 btn-block" onclick="openmember({{$value}})"
                                style="background-image: linear-gradient(#7F00FF,#FF00C7)">Daftar</button>
                        </div>
                    </div>
                </div>
            </div>

            @endif
            @endforeach
        </div>
    </div>
    <div class="dividers m-500">
    </div>

    <div class="modal" tabindex="-1" id="modalmember">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Membership</h5>
                    <button type="button" class="" data-dismiss="modal" aria-label="Close">x</button>
                </div>
                <div class="modal-body">
                    <form action="/updatemember" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="text" name="user_id" id="user_id" value="{{ Auth::user()->id }}" hidden>
                        <input type="text" name="status_membership" id="status_membership" value="2" hidden>
                        <input type="text" name="id_member" id="id_member" hidden>
                        <div id="detailmember"></div>
                        <div class="col-lg-12">
                            <label for="form-control">Bukti Pembayaran</label>
                            <input type="file" class="form-control" name="image_bukti_pembayaran"
                                id="image_bukti_pembayaran" accept="image/png, image/jpeg">
                            <img id="pctrbuktipembayaran" src="" alt="" width="500px">
                            @error('image_bukti_pembayaran')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                            <button class="btn btn-primary mt-2">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    function openmember(val) {
        $('#id_member').val(val['id']);
        let p = '<h3>Harga Member : <strong>'+val.harga.toLocaleString()+'</strong></h3>';
        p+='<span>No. Rekening : 8035559091</span><br>';
        p+='<span>Atas Nama : PT. Bankir Academy Indonesia</span>';
        $('#detailmember').html(p);
        $('#modalmember').modal('show');
    }
</script>