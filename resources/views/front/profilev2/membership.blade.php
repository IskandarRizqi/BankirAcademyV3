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
    @media only screen and (min-width: 600px) {
        .m-500 {
            /* margin: 1670px; */
            margin: 2300px;
        }
    }

    /* Medium devices (landscape tablets, 768px and up) */
    @media only screen and (min-width: 768px) {
        .m-500 {
            /* margin: 1670px; */
            margin: 3350px;
        }
    }

    /* Large devices (laptops/desktops, 992px and up) */
    @media only screen and (min-width: 992px) {
        .m-500 {
            margin: 371px;
        }
    }

    /* Extra large devices (large laptops and desktops, 1200px and up) */
    @media only screen and (min-width: 1200px) {
        .m-500 {
            margin: 550px;
        }
    }
</style>
<section id="content">
    @if($ismember)
    <div class="col-lg-12">
        <img src="{{asset('front/images/A_MEMBER.jpg')}}" alt="">
        <div class="caption text-center" style="font-size: 2vw"><b>Masa Aktif :
                {{\Carbon\Carbon::parse($user->profile->masa_aktif_membership)->format('d-m-Y')}}</b></div>
    </div>
    @else
    <img src="/GambarV2/frame.png" alt="" width="100%">
    <div class="bungkusframe">
        <div class="row text-center top-50" style="
    position: absolute;
    left: 0;
    right: 0;
    padding: 60px;
    ">
            @foreach($member as $key => $value)
            <div class="col-lg-4 mb-2">
                <div class="card" style="border-radius:10px;">
                    <div class="card-body m-0 p-0">
                        <div>
                            <div class="img-fluid">
                                <img src="{{$value->gambar}}" alt="" width="100%" onclick="openmember({{$value}})"
                                    style="cursor: pointer">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="dividers m-500">
    </div>
    @endif
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
    <div id="element-container" hidden>
        <p>This is page 1 content</p>
        <div class="html2pdf__page-break"></div>
        <p>This is page 2 content</p>
    </div>
</section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
    integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    function openmember(val) {
        $('#id_member').val(val['id']);
        let p = '<h3>Harga Member : <strong>'+val.harga.toLocaleString()+'</strong></h3>';
        p+='<span>No. Rekening : 8035559091</span><br>';
        p+='<span>Atas Nama : PT. Bankir Academy Indonesia</span>';
        p+='<a href="/classes/cetakinvoicepending/'+val.id+'" target="_blank"> <span id="btncetakinvoice" class="btn btn-info btn-block">Invoice</span></a>';
        $('#detailmember').html(p);
        $('#modalmember').modal('show');
    }
    function cetakinvoice() {
        var element = document.getElementsByTagName('body')[0]
  html2pdf().from(element).toPdf().save('my_document.pdf')

        // const page = document.getElementById('element-container').innerHTML;
        // $('#btncetakinvoice').attr('disabled',true);
        // var opt = {
        //     margin:       1,
        //     filename:     'Demopdf.pdf',
        //     image:        { type: 'jpeg', quality: 0.98 },
        //     html2canvas:  { letterRendering: true, useCORS: true,     logging: true },
        //     jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait' }
        // };
        // setTimeout(() => {
        //     html2pdf().set(opt).from(page).toPdf().save();
        //     $('#btncetakinvoice').removeAttr('disabled');
        // }, 2000);
        // Choose the element that our invoice is rendered in.
    }
</script>