@include('front.layout.head')
@include('front.layout.topbar')
@include(env('CUSTOM_HEADER', 'front.layout.header'))

<section id="content">
    <div class="content-wrap">
        <div class="container clearfix">
            <h3>Promo</h3>
            @if ($data['data'])
            <div class="row gutter-40 col-mb-80">
                <div class="postcontent col-lg-12">
                    <div class="single-event">
                        <div class="row">
                            @foreach ($data['data'] as $v)
                            <div class="col-lg-3 col-sm-6 mb-4">
                                <div class="card" style="border-radius: 25px">
                                    <div class="card-body">
                                        <img src="{{ '/Image/' . $v['image'] }}" width="100%">
                                        {{-- <a href="/pages/blog">
                                        </a> --}}
                                        <h5 class="text-uppercase text-center mt-2"
                                            style="margin-bottom: 0px !important" @if ($v['kode'])
                                            onclick="handleCopyTextFromParagraph('{{ $v['kode'] }}')" @endif>
                                            {{ $v['kode'] }}</h5>
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
                    </div>
                </div>
            </div>
            @endif

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