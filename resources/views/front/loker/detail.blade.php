@include('front.layout.head')
@include('front.layout.topbar')
@include(env('CUSTOM_HEADER', 'front.layout.header'))
<section id="content">
    <div class="content-wrap">
        <div class="container clearfix">
            <div class="row gutter-40 col-mb-80">
                <div class="postcontent col-lg-9">
                    <div class="single-event">
                        <div class="row col-mb-50">
                            <div class="col-md-7 col-lg-7 text-center">
                                @if ($data->perusahaan)
                                    @php $js = json_decode($data->perusahaan->image) @endphp
                                    <img src="{{ $js ? '/image/loker/' . $js->url : '' }}" alt=""
                                        style="max-width:100%; max-height:100px; object-fit:fill;">
                                @else
                                    <img src="{{ $data->image ? '/image/loker/' . json_decode($data->image)->url : '' }}"
                                        alt="" style="max-width:100%; max-height:100px; object-fit:fill;">
                                @endif
                            </div>
                           <div class="col-md-5 col-lg-5">
                                <h2 style="margin: 0 0 4px 0; font-weight: 700; font-size: 24px;">{{ $data->title }}</h2>

                                @if($data->perusahaan)
                                    <p style="margin:0 0 8px 0; color:#000000; font-size:18px;">{{ $data->perusahaan->nama }}</p>
                                @elseif($data->nama)
                                    <p style="margin:0 0 8px 0; color:#000000; font-size:15px;">{{ $data->nama }}</p>
                                @else
                                    <p style="margin:0 0 8px 0; color:#000000; font-size:15px;">{{ json_decode($data->corporate)?json_decode($data->corporate)->name:'Anugrah Karya' }}</p>
                                @endif

                                <div style="display:flex; flex-direction:column; gap:4px;">
                                    <div style="display:flex; align-items:center; gap:6px; font-size:15px; color:#333;">
                                        <i class="icon-wallet" style="color:#1976d2;"></i>
                                        {{ $data->gaji_min ? 'Rp. '.number_format($data->gaji_min) : 'Gaji Competitive' }}
                                    </div>
                                    <div style="display:flex; align-items:center; gap:6px; font-size:15px; color:#333;">
                                        <i class="icon-calendar-plus" style="color:#1976d2;"></i>
                                        {{ \Carbon\Carbon::parse($data->tanggal_akhir)->format('d-m-Y') }}
                                    </div>
                                </div>
                            </div>
                            <div class="w-100"></div>
                            <div class="card col" style="border-radius: 15px">
                                <div class="card-body">
                                    <div class="col-md-12" style="padding-bottom: 10px;">
                                        {{-- <h4>Skill</h4>
                                        <div class="row mb-4">
                                            @if ($data->skill)
                                            @foreach (json_decode($data->skill) as $key => $value)
                                            <span class="badge badge-info">{{$value}}</span>
                                            @endforeach
                                            @endif
                                        </div> --}}
                                        <div class="mb-4">
                                            <h4>Syarat</h4>
                                            {!! $data->deskripsi !!}
                                        </div>
                                        <hr>
                                        <div class="mb-4">
                                            <h4>Jobdesk</h4>
                                            {!! $data->jobdesk !!}
                                        </div>
                                        <div class="mb-4">
                                            <h4>Alamat</h4>
                                            @if ($data->perusahaan)
                                                {{ $data->perusahaan->alamat }}
                                            @else
                                                {{ $data->alamat }}
                                            @endif
                                        </div>
                                    </div>
                                   <div class="col-md-12" style="padding-bottom: 0px;">
                                        <form id="orderForm" action="{{ '/loker/apply' }}" method="POST">
                                            @csrf
                                            <input type="text" id="class_id" name="class_id" value="{{ $data->id }}" hidden>
                                            <button class="btn-block text-center" style="
                                                display:block;
                                                width:100%;
                                                padding:10px;
                                                border-radius:20px;
                                                background:#1976d2;
                                                border:none;
                                                color:#fff;
                                                font-size:15px;
                                                font-weight:600;
                                                cursor:pointer;
                                                transition:background 0.3s, transform 0.2s;
                                            "
                                            onmouseover="this.style.background='#f59e0b';this.style.transform='translateY(-2px)'"
                                            onmouseout="this.style.background='#1976d2';this.style.transform='translateY(0)'">
                                                Kirim Lamaran
                                            </button>
                                        </form>
                                    </div>
                                    {{-- <a href="mailto:{{$data->email}}">
                                        <button class="button button-circle btn-block text-center">Kirim
                                            Lamaran</button>
                                    </a> --}}
                                </div>
                            </div>
                            <script>
                                // $('#orderForm').submit()
                            </script>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    @foreach ($lain as $key => $value)
                        <a href="/loker/{{ $value->id }}/detail" style="text-decoration:none;">
                            <div style="
                                    border-radius: 15px;
                                    margin-bottom: 16px;
                                    background: linear-gradient(145deg, #0d47a1 0%, #1565c0 40%, #1976d2 70%, #1e88e5 100%);
                                    box-shadow: 0 6px 20px rgba(13,71,161,0.35);
                                    transition: transform 0.3s ease, box-shadow 0.3s ease;
                                    overflow: hidden;
                                    position: relative;
                                "
                                onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 12px 30px rgba(13,71,161,0.5)'"
                                onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 6px 20px rgba(13,71,161,0.35)'">

                                {{-- Glow accent --}}
                                <div
                                    style="position:absolute;top:0;right:0;width:80px;height:80px;background:radial-gradient(circle,rgba(255,255,255,0.12) 0%,transparent 70%);pointer-events:none;">
                                </div>

                                <div style="padding: 16px;">
                                    {{-- Header: gambar + judul --}}
                                    <div style="display:flex; align-items:center; gap:12px;">
                                        @if ($value->perusahaan && $value->perusahaan->image)
                                            @php $jsLain = json_decode($value->perusahaan->image) @endphp
                                            <img src="{{ $jsLain ? '/image/loker/' . $jsLain->url : '' }}" alt=""
                                                style="width:52px;height:52px;object-fit:cover;border-radius:12px;flex-shrink:0;border:2px solid rgba(255,255,255,0.3);">
                                        @elseif($value->image)
                                            <img src="{{ '/image/loker/' . json_decode($value->image)->url }}"
                                                alt=""
                                                style="width:52px;height:52px;object-fit:cover;border-radius:12px;flex-shrink:0;border:2px solid rgba(255,255,255,0.3);">
                                        @else
                                            <div
                                                style="width:52px;height:52px;border-radius:12px;background:rgba(255,255,255,0.15);flex-shrink:0;display:flex;align-items:center;justify-content:center;border:2px solid rgba(255,255,255,0.2);">
                                                <i class="icon-briefcase"
                                                    style="color:rgba(255,255,255,0.7);font-size:20px;"></i>
                                            </div>
                                        @endif
                                       <div>
                                            <div style="font-size:15px;font-weight:700;color:#fff;line-height:1.3;">
                                                {{ substr($value->title, 0, 18) }}
                                            </div>
                                            <div style="font-size:12px;color:rgba(255,255,255,0.75);margin-top:2px;">
                                                @if($value->perusahaan && $value->perusahaan->nama)
                                                    {{ $value->perusahaan->nama }}
                                                @elseif($value->nama)
                                                    {{ $value->nama }}
                                                @else
                                                    {{ json_decode($value->corporate)?json_decode($value->corporate)->name:'Anugrah Karya' }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Divider --}}
                                    <div style="border-top:1px solid rgba(255,255,255,0.2);margin:12px 0;"></div>

                                    {{-- Info --}}
                                    <div style="display:flex;flex-direction:column;gap:5px;">
                                        {{-- Skill --}}
                                        @if ($value->skill)
                                            <div style="display:flex;flex-wrap:wrap;gap:4px;">
                                                @foreach (json_decode($value->skill) as $v)
                                                    <span
                                                        style="background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.25);border-radius:50px;padding:2px 10px;font-size:11px;color:#fff;">{{ $v }}</span>
                                                @endforeach
                                            </div>
                                        @endif

                                        {{-- Gaji --}}
                                        <div style="font-size:12px;color:rgba(255,255,255,0.85);">
                                            <i class="icon-wallet mr-1"></i>
                                            @if ($value->gaji_min > 0)
                                                Rp. {{ number_format($value->gaji_min) }}
                                            @else
                                                Gaji Tidak Ditampilkan
                                            @endif
                                        </div>

                                        {{-- Tanggal --}}
                                        <div style="font-size:11px;color:rgba(255,255,255,0.65);">
                                            <i class="icon-calendar mr-1"></i>
                                            {{ \Carbon\Carbon::parse($value->tanggal_awal)->format('d-m-Y') }} -
                                            {{ \Carbon\Carbon::parse($value->tanggal_akhir)->format('d-m-Y') }}
                                        </div>
                                    </div>

                                    {{-- Tombol Detail --}}
                                    <div style="margin-top:12px;">
                                        <span
                                            style="
                                                display:block;
                                                text-align:center;
                                                padding:8px;
                                                border-radius:50px;
                                                background:rgba(255,255,255,0.15);
                                                border:1px solid rgba(255,255,255,0.3);
                                                color:#fff;
                                                font-size:13px;
                                                font-weight:600;
                                                transition:background 0.3s, color 0.3s;
                                            "
                                            onmouseover="this.style.background='#f59e0b';this.style.borderColor='#f59e0b';this.style.color='#fff'"
                                            onmouseout="this.style.background='rgba(255,255,255,0.15)';this.style.borderColor='rgba(255,255,255,0.3)';this.style.color='#fff'">
                                            Lihat Detail →
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@include('front.layout.footer')
