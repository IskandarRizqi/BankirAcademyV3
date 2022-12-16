@include('front.layout.head')
@include('front.layout.topbar')
@include(env('CUSTOM_HEADER', 'front.layout.header'))

<section id="content">
    <div class="content-wrap">
        <div class="container clearfix">
            <h3>Promo</h3>
            @if ($data['data'])
            <div class="row gutter-40 col-mb-80">
                @foreach ($data['data'] as $v)
                <div class="col-lg-4 col-sm-6">
                    <div class="card shadow mb-5 bg-white" style="border-radius: 8px; min-height: 550px">
                        <div class="card-body">
                            <img src="{{ '/Image/' . $v['image'] }}" width="100%" style="border-radius: 8px">
                            <h3 class="text-capitalize m-0">{{$v['nama']}}</h3>
                            {{$v['description']}}
                            @if ($v['kode'])
                            @endif
                            <span class="btn mt-4"
                                style="background-color: #efefef;border-radius: 8px;position: absolute; bottom: 10px; left: 10px; right: 10px;">
                                <div class="row align-items-center">
                                    <div class="col text-left ml-2">
                                        <small class="fs-2">Kode Promo</small>
                                        <h4 class="" style="margin-bottom: 0px !important; font-weight: bold">
                                            {{ $v['kode']?$v['kode']:'-' }}</h4>
                                    </div>
                                    <div class="col">
                                        <span class="btn btn-outline-primary btn-sm float-right"
                                            style="border-radius: 8px"
                                            onclick="handleCopyTextFromParagraph('{{ $v['kode'] }}')">Copy</span>
                                    </div>
                                </div>
                            </span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <hr>
            <div class="row">
                <div class="col-lg-12 text-center">
                    <nav aria-label="Page navigation blog">
                        <ul class="pagination justify-content-center">
                            @foreach ($data['links'] as $k => $p)
                            <li class="page-item {{ $p['active'] ? 'active' : '' }}"><a class="page-link"
                                    href="{{ $p['url'] }}">
                                    <?= $p['label'] ?>
                                </a></li>
                            @endforeach
                        </ul>
                    </nav>
                </div>
            </div>
            @endif
            <img src="{{asset('a_Cara_pakai_promo.jpg')}}" alt="">
        </div>
    </div>
</section><!-- #content end -->
<script>
    $('#judul').click(function() {})

    function copy() {
        let copyText = document.querySelector("#judul");
        copyText.select();
        document.execCommand("copy");
    }

    function handleCopyTextFromParagraph(promo) {
        const cb = navigator.clipboard;
        const paragraph = promo;
        //   const paragraph = document.querySelector('#promo');
        cb.writeText(paragraph).then(() => iziToast.success({
                        title: 'Success',
                        message: 'copy to clipboard',
                        position: 'topRight',
                    }));
    }
</script>
@include(env('CUSTOM_FOOTER', 'front.layout.footer'))