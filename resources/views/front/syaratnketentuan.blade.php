@include("front.layout.head")
@include("front.layout.topbar")
@include(env("CUSTOM_HEADER","front.layout.header"))
@error('error')
{{$message}}
@enderror
<section id="content">
    Syarat dan Ketentuan
    <a href="/registerinstructor" class="btn btn-success btn-rounded" style="border-radius:10px !important">Setuju</a>
    <a href="/" class="btn btn-secondary btn-rounded" style="border-radius:10px !important">Batal</a>
</section>
@include(env("CUSTOM_FOOTER","front.layout.footer"))