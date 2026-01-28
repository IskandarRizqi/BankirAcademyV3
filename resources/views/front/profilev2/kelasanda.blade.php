<div class="row">
    <div class="col-lg-3">
        <div class="list-group" id="list-tab" role="tablist">
            <a class="list-group-item list-group-item-action text-capitalize br-10 active" id="list-semua-ka-list"
                data-toggle="list" href="#list-semua-ka" role="tab" aria-controls="semua-ka"
                onclick="getkelasanda('semua-ka-billing')">semua</a>
            <a class="list-group-item list-group-item-action text-capitalize br-10" id="list-dalam-progres-list"
                data-toggle="list" href="#list-dalam-progres" role="tab" aria-controls="dalam-progres"
                onclick="getkelasanda('dalam-progres-billing')">dalam progres</a>
            {{-- <a class="list-group-item list-group-item-action text-capitalize br-10" id="list-konfirmasi-ka-list"
                data-toggle="list" href="#list-konfirmasi-ka" role="tab" aria-controls="konfirmasi-ka"
                onclick="getkelasanda('konfirmasi-ka-billing')">menunggu
                konfirmasi</a> --}}
            <a class="list-group-item list-group-item-action text-capitalize br-10" id="list-selesai-ka-list"
                data-toggle="list" href="#list-selesai-ka" role="tab" aria-controls="selesai-ka"
                onclick="getkelasanda('selesai-ka-billing')">selesai</a>
        </div>
    </div>
    <div class="col-lg-9">
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="list-semua-ka" role="tabpanel"
                aria-labelledby="list-semua-ka-list">
                <div id="semua-ka-billing">
                    {{-- <div class="card br-10 mb-4" style="background-color: #f7f7f7">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-9">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <img src="/GambarV2/rectangle31.png" alt="" width="150px" class="br-10">
                                        </div>
                                        <div class="col-lg-8">
                                            <h5 class="m-0">Menerapkan Teknik Service Orientation dalam Pelayanan
                                                Pelanggan
                                                untuk Manajer
                                                Penjualan</h5>
                                            <label for="">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g filter="url(#filter0_d_65_636)">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M18.6667 3.11111C18.313 3.11111 17.9739 3.25159 17.7239 3.50164C17.4738 3.75168 17.3333 4.09082 17.3333 4.44444V5.33333H20V4.44444C20 4.09082 19.8595 3.75168 19.6095 3.50164C19.3594 3.25159 19.0203 3.11111 18.6667 3.11111ZM20 6.22222H17.3333V13.5556L18.6667 15.5556L20 13.5556V6.22222ZM4 1.33333V14.6667C4 15.0203 4.14048 15.3594 4.39052 15.6095C4.64057 15.8595 4.97971 16 5.33333 16H15.1111C15.4647 16 15.8039 15.8595 16.0539 15.6095C16.304 15.3594 16.4444 15.0203 16.4444 14.6667V1.33333C16.4444 0.979711 16.304 0.640573 16.0539 0.390524C15.8039 0.140476 15.4647 0 15.1111 0H5.33333C4.97971 0 4.64057 0.140476 4.39052 0.390524C4.14048 0.640573 4 0.979711 4 1.33333ZM10.2222 4C10.2222 3.88213 10.269 3.76908 10.3524 3.68573C10.4357 3.60238 10.5488 3.55556 10.6667 3.55556H14.2222C14.3401 3.55556 14.4531 3.60238 14.5365 3.68573C14.6198 3.76908 14.6667 3.88213 14.6667 4C14.6667 4.11787 14.6198 4.23092 14.5365 4.31427C14.4531 4.39762 14.3401 4.44444 14.2222 4.44444H10.6667C10.5488 4.44444 10.4357 4.39762 10.3524 4.31427C10.269 4.23092 10.2222 4.11787 10.2222 4ZM10.6667 5.33333C10.5488 5.33333 10.4357 5.38016 10.3524 5.46351C10.269 5.54686 10.2222 5.6599 10.2222 5.77778C10.2222 5.89565 10.269 6.0087 10.3524 6.09205C10.4357 6.1754 10.5488 6.22222 10.6667 6.22222H14.2222C14.3401 6.22222 14.4531 6.1754 14.5365 6.09205C14.6198 6.0087 14.6667 5.89565 14.6667 5.77778C14.6667 5.6599 14.6198 5.54686 14.5365 5.46351C14.4531 5.38016 14.3401 5.33333 14.2222 5.33333H10.6667ZM10.2222 9.77778C10.2222 9.6599 10.269 9.54686 10.3524 9.46351C10.4357 9.38016 10.5488 9.33333 10.6667 9.33333H14.2222C14.3401 9.33333 14.4531 9.38016 14.5365 9.46351C14.6198 9.54686 14.6667 9.6599 14.6667 9.77778C14.6667 9.89565 14.6198 10.0087 14.5365 10.092C14.4531 10.1754 14.3401 10.2222 14.2222 10.2222H10.6667C10.5488 10.2222 10.4357 10.1754 10.3524 10.092C10.269 10.0087 10.2222 9.89565 10.2222 9.77778ZM10.6667 11.1111C10.5488 11.1111 10.4357 11.1579 10.3524 11.2413C10.269 11.3246 10.2222 11.4377 10.2222 11.5556C10.2222 11.6734 10.269 11.7865 10.3524 11.8698C10.4357 11.9532 10.5488 12 10.6667 12H14.2222C14.3401 12 14.4531 11.9532 14.5365 11.8698C14.6198 11.7865 14.6667 11.6734 14.6667 11.5556C14.6667 11.4377 14.6198 11.3246 14.5365 11.2413C14.4531 11.1579 14.3401 11.1111 14.2222 11.1111H10.6667ZM6.66667 9.77778V11.1111H8V9.77778H6.66667ZM6.22222 8.88889H8.44444C8.56232 8.88889 8.67536 8.93571 8.75871 9.01906C8.84206 9.10241 8.88889 9.21546 8.88889 9.33333V11.5556C8.88889 11.6734 8.84206 11.7865 8.75871 11.8698C8.67536 11.9532 8.56232 12 8.44444 12H6.22222C6.10435 12 5.9913 11.9532 5.90795 11.8698C5.8246 11.7865 5.77778 11.6734 5.77778 11.5556V9.33333C5.77778 9.21546 5.8246 9.10241 5.90795 9.01906C5.9913 8.93571 6.10435 8.88889 6.22222 8.88889ZM9.20311 4.31422C9.28407 4.2304 9.32887 4.11813 9.32786 4.0016C9.32684 3.88507 9.2801 3.7736 9.1977 3.69119C9.11529 3.60879 9.00382 3.56205 8.88729 3.56103C8.77076 3.56002 8.65849 3.60482 8.57467 3.68578L7.11111 5.14933L6.53644 4.57467C6.45262 4.49371 6.34035 4.44891 6.22382 4.44992C6.10729 4.45093 5.99582 4.49768 5.91341 4.58008C5.83101 4.66248 5.78427 4.77396 5.78326 4.89049C5.78224 5.00702 5.82704 5.11929 5.908 5.20311L7.11111 6.40622L9.20311 4.31422Z"
                                                            fill="#0059F6" />
                                                    </g>
                                                    <defs>
                                                        <filter id="filter0_d_65_636" x="0" y="0" width="24" height="24"
                                                            filterUnits="userSpaceOnUse"
                                                            color-interpolation-filters="sRGB">
                                                            <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                                            <feColorMatrix in="SourceAlpha" type="matrix"
                                                                values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"
                                                                result="hardAlpha" />
                                                            <feOffset dy="4" />
                                                            <feGaussianBlur stdDeviation="2" />
                                                            <feComposite in2="hardAlpha" operator="out" />
                                                            <feColorMatrix type="matrix"
                                                                values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0" />
                                                            <feBlend mode="normal" in2="BackgroundImageFix"
                                                                result="effect1_dropShadow_65_636" />
                                                            <feBlend mode="normal" in="SourceGraphic"
                                                                in2="effect1_dropShadow_65_636" result="shape" />
                                                        </filter>
                                                    </defs>
                                                </svg>
                                                Nilai Exam : 0
                                            </label>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" style="width: 75%"
                                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 text-center">
                                    <div class="btn btn-success" style="cursor: auto">Selesai</div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
            <div class="tab-pane fade" id="list-dalam-progres" role="tabpanel"
                aria-labelledby="list-dalam-progres-list">
                <div id="dalam-progres-billing">
                    {{-- <div class="card br-10 mb-4" style="background-color: #f7f7f7">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-9">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <img src="/GambarV2/rectangle31.png" alt="" width="150px" class="br-10">
                                        </div>
                                        <div class="col-lg-8">
                                            <h5 class="m-0">Menerapkan Teknik Service Orientation dalam Pelayanan
                                                Pelanggan
                                                untuk Manajer
                                                Penjualan</h5>
                                            <label for="">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g filter="url(#filter0_d_65_636)">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M18.6667 3.11111C18.313 3.11111 17.9739 3.25159 17.7239 3.50164C17.4738 3.75168 17.3333 4.09082 17.3333 4.44444V5.33333H20V4.44444C20 4.09082 19.8595 3.75168 19.6095 3.50164C19.3594 3.25159 19.0203 3.11111 18.6667 3.11111ZM20 6.22222H17.3333V13.5556L18.6667 15.5556L20 13.5556V6.22222ZM4 1.33333V14.6667C4 15.0203 4.14048 15.3594 4.39052 15.6095C4.64057 15.8595 4.97971 16 5.33333 16H15.1111C15.4647 16 15.8039 15.8595 16.0539 15.6095C16.304 15.3594 16.4444 15.0203 16.4444 14.6667V1.33333C16.4444 0.979711 16.304 0.640573 16.0539 0.390524C15.8039 0.140476 15.4647 0 15.1111 0H5.33333C4.97971 0 4.64057 0.140476 4.39052 0.390524C4.14048 0.640573 4 0.979711 4 1.33333ZM10.2222 4C10.2222 3.88213 10.269 3.76908 10.3524 3.68573C10.4357 3.60238 10.5488 3.55556 10.6667 3.55556H14.2222C14.3401 3.55556 14.4531 3.60238 14.5365 3.68573C14.6198 3.76908 14.6667 3.88213 14.6667 4C14.6667 4.11787 14.6198 4.23092 14.5365 4.31427C14.4531 4.39762 14.3401 4.44444 14.2222 4.44444H10.6667C10.5488 4.44444 10.4357 4.39762 10.3524 4.31427C10.269 4.23092 10.2222 4.11787 10.2222 4ZM10.6667 5.33333C10.5488 5.33333 10.4357 5.38016 10.3524 5.46351C10.269 5.54686 10.2222 5.6599 10.2222 5.77778C10.2222 5.89565 10.269 6.0087 10.3524 6.09205C10.4357 6.1754 10.5488 6.22222 10.6667 6.22222H14.2222C14.3401 6.22222 14.4531 6.1754 14.5365 6.09205C14.6198 6.0087 14.6667 5.89565 14.6667 5.77778C14.6667 5.6599 14.6198 5.54686 14.5365 5.46351C14.4531 5.38016 14.3401 5.33333 14.2222 5.33333H10.6667ZM10.2222 9.77778C10.2222 9.6599 10.269 9.54686 10.3524 9.46351C10.4357 9.38016 10.5488 9.33333 10.6667 9.33333H14.2222C14.3401 9.33333 14.4531 9.38016 14.5365 9.46351C14.6198 9.54686 14.6667 9.6599 14.6667 9.77778C14.6667 9.89565 14.6198 10.0087 14.5365 10.092C14.4531 10.1754 14.3401 10.2222 14.2222 10.2222H10.6667C10.5488 10.2222 10.4357 10.1754 10.3524 10.092C10.269 10.0087 10.2222 9.89565 10.2222 9.77778ZM10.6667 11.1111C10.5488 11.1111 10.4357 11.1579 10.3524 11.2413C10.269 11.3246 10.2222 11.4377 10.2222 11.5556C10.2222 11.6734 10.269 11.7865 10.3524 11.8698C10.4357 11.9532 10.5488 12 10.6667 12H14.2222C14.3401 12 14.4531 11.9532 14.5365 11.8698C14.6198 11.7865 14.6667 11.6734 14.6667 11.5556C14.6667 11.4377 14.6198 11.3246 14.5365 11.2413C14.4531 11.1579 14.3401 11.1111 14.2222 11.1111H10.6667ZM6.66667 9.77778V11.1111H8V9.77778H6.66667ZM6.22222 8.88889H8.44444C8.56232 8.88889 8.67536 8.93571 8.75871 9.01906C8.84206 9.10241 8.88889 9.21546 8.88889 9.33333V11.5556C8.88889 11.6734 8.84206 11.7865 8.75871 11.8698C8.67536 11.9532 8.56232 12 8.44444 12H6.22222C6.10435 12 5.9913 11.9532 5.90795 11.8698C5.8246 11.7865 5.77778 11.6734 5.77778 11.5556V9.33333C5.77778 9.21546 5.8246 9.10241 5.90795 9.01906C5.9913 8.93571 6.10435 8.88889 6.22222 8.88889ZM9.20311 4.31422C9.28407 4.2304 9.32887 4.11813 9.32786 4.0016C9.32684 3.88507 9.2801 3.7736 9.1977 3.69119C9.11529 3.60879 9.00382 3.56205 8.88729 3.56103C8.77076 3.56002 8.65849 3.60482 8.57467 3.68578L7.11111 5.14933L6.53644 4.57467C6.45262 4.49371 6.34035 4.44891 6.22382 4.44992C6.10729 4.45093 5.99582 4.49768 5.91341 4.58008C5.83101 4.66248 5.78427 4.77396 5.78326 4.89049C5.78224 5.00702 5.82704 5.11929 5.908 5.20311L7.11111 6.40622L9.20311 4.31422Z"
                                                            fill="#0059F6" />
                                                    </g>
                                                    <defs>
                                                        <filter id="filter0_d_65_636" x="0" y="0" width="24" height="24"
                                                            filterUnits="userSpaceOnUse"
                                                            color-interpolation-filters="sRGB">
                                                            <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                                            <feColorMatrix in="SourceAlpha" type="matrix"
                                                                values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"
                                                                result="hardAlpha" />
                                                            <feOffset dy="4" />
                                                            <feGaussianBlur stdDeviation="2" />
                                                            <feComposite in2="hardAlpha" operator="out" />
                                                            <feColorMatrix type="matrix"
                                                                values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0" />
                                                            <feBlend mode="normal" in2="BackgroundImageFix"
                                                                result="effect1_dropShadow_65_636" />
                                                            <feBlend mode="normal" in="SourceGraphic"
                                                                in2="effect1_dropShadow_65_636" result="shape" />
                                                        </filter>
                                                    </defs>
                                                </svg>
                                                Nilai Exam : 0
                                            </label>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" style="width: 75%"
                                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 text-center">
                                    <div class="btn btn-primary" style="cursor: auto">Dalam Progress</div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
            <div class="tab-pane fade" id="list-konfirmasi-ka" role="tabpanel"
                aria-labelledby="list-konfirmasi-ka-list">
                <div id="konfirmasi-ka-billing">
                    {{-- <div class="card br-10 mb-4" style="background-color: #f7f7f7">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-9">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <img src="/GambarV2/rectangle31.png" alt="" width="150px" class="br-10">
                                        </div>
                                        <div class="col-lg-8">
                                            <h5 class="m-0">Menerapkan Teknik Service Orientation dalam Pelayanan
                                                Pelanggan
                                                untuk Manajer
                                                Penjualan</h5>
                                            <label for="">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g filter="url(#filter0_d_65_636)">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M18.6667 3.11111C18.313 3.11111 17.9739 3.25159 17.7239 3.50164C17.4738 3.75168 17.3333 4.09082 17.3333 4.44444V5.33333H20V4.44444C20 4.09082 19.8595 3.75168 19.6095 3.50164C19.3594 3.25159 19.0203 3.11111 18.6667 3.11111ZM20 6.22222H17.3333V13.5556L18.6667 15.5556L20 13.5556V6.22222ZM4 1.33333V14.6667C4 15.0203 4.14048 15.3594 4.39052 15.6095C4.64057 15.8595 4.97971 16 5.33333 16H15.1111C15.4647 16 15.8039 15.8595 16.0539 15.6095C16.304 15.3594 16.4444 15.0203 16.4444 14.6667V1.33333C16.4444 0.979711 16.304 0.640573 16.0539 0.390524C15.8039 0.140476 15.4647 0 15.1111 0H5.33333C4.97971 0 4.64057 0.140476 4.39052 0.390524C4.14048 0.640573 4 0.979711 4 1.33333ZM10.2222 4C10.2222 3.88213 10.269 3.76908 10.3524 3.68573C10.4357 3.60238 10.5488 3.55556 10.6667 3.55556H14.2222C14.3401 3.55556 14.4531 3.60238 14.5365 3.68573C14.6198 3.76908 14.6667 3.88213 14.6667 4C14.6667 4.11787 14.6198 4.23092 14.5365 4.31427C14.4531 4.39762 14.3401 4.44444 14.2222 4.44444H10.6667C10.5488 4.44444 10.4357 4.39762 10.3524 4.31427C10.269 4.23092 10.2222 4.11787 10.2222 4ZM10.6667 5.33333C10.5488 5.33333 10.4357 5.38016 10.3524 5.46351C10.269 5.54686 10.2222 5.6599 10.2222 5.77778C10.2222 5.89565 10.269 6.0087 10.3524 6.09205C10.4357 6.1754 10.5488 6.22222 10.6667 6.22222H14.2222C14.3401 6.22222 14.4531 6.1754 14.5365 6.09205C14.6198 6.0087 14.6667 5.89565 14.6667 5.77778C14.6667 5.6599 14.6198 5.54686 14.5365 5.46351C14.4531 5.38016 14.3401 5.33333 14.2222 5.33333H10.6667ZM10.2222 9.77778C10.2222 9.6599 10.269 9.54686 10.3524 9.46351C10.4357 9.38016 10.5488 9.33333 10.6667 9.33333H14.2222C14.3401 9.33333 14.4531 9.38016 14.5365 9.46351C14.6198 9.54686 14.6667 9.6599 14.6667 9.77778C14.6667 9.89565 14.6198 10.0087 14.5365 10.092C14.4531 10.1754 14.3401 10.2222 14.2222 10.2222H10.6667C10.5488 10.2222 10.4357 10.1754 10.3524 10.092C10.269 10.0087 10.2222 9.89565 10.2222 9.77778ZM10.6667 11.1111C10.5488 11.1111 10.4357 11.1579 10.3524 11.2413C10.269 11.3246 10.2222 11.4377 10.2222 11.5556C10.2222 11.6734 10.269 11.7865 10.3524 11.8698C10.4357 11.9532 10.5488 12 10.6667 12H14.2222C14.3401 12 14.4531 11.9532 14.5365 11.8698C14.6198 11.7865 14.6667 11.6734 14.6667 11.5556C14.6667 11.4377 14.6198 11.3246 14.5365 11.2413C14.4531 11.1579 14.3401 11.1111 14.2222 11.1111H10.6667ZM6.66667 9.77778V11.1111H8V9.77778H6.66667ZM6.22222 8.88889H8.44444C8.56232 8.88889 8.67536 8.93571 8.75871 9.01906C8.84206 9.10241 8.88889 9.21546 8.88889 9.33333V11.5556C8.88889 11.6734 8.84206 11.7865 8.75871 11.8698C8.67536 11.9532 8.56232 12 8.44444 12H6.22222C6.10435 12 5.9913 11.9532 5.90795 11.8698C5.8246 11.7865 5.77778 11.6734 5.77778 11.5556V9.33333C5.77778 9.21546 5.8246 9.10241 5.90795 9.01906C5.9913 8.93571 6.10435 8.88889 6.22222 8.88889ZM9.20311 4.31422C9.28407 4.2304 9.32887 4.11813 9.32786 4.0016C9.32684 3.88507 9.2801 3.7736 9.1977 3.69119C9.11529 3.60879 9.00382 3.56205 8.88729 3.56103C8.77076 3.56002 8.65849 3.60482 8.57467 3.68578L7.11111 5.14933L6.53644 4.57467C6.45262 4.49371 6.34035 4.44891 6.22382 4.44992C6.10729 4.45093 5.99582 4.49768 5.91341 4.58008C5.83101 4.66248 5.78427 4.77396 5.78326 4.89049C5.78224 5.00702 5.82704 5.11929 5.908 5.20311L7.11111 6.40622L9.20311 4.31422Z"
                                                            fill="#0059F6" />
                                                    </g>
                                                    <defs>
                                                        <filter id="filter0_d_65_636" x="0" y="0" width="24" height="24"
                                                            filterUnits="userSpaceOnUse"
                                                            color-interpolation-filters="sRGB">
                                                            <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                                            <feColorMatrix in="SourceAlpha" type="matrix"
                                                                values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"
                                                                result="hardAlpha" />
                                                            <feOffset dy="4" />
                                                            <feGaussianBlur stdDeviation="2" />
                                                            <feComposite in2="hardAlpha" operator="out" />
                                                            <feColorMatrix type="matrix"
                                                                values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0" />
                                                            <feBlend mode="normal" in2="BackgroundImageFix"
                                                                result="effect1_dropShadow_65_636" />
                                                            <feBlend mode="normal" in="SourceGraphic"
                                                                in2="effect1_dropShadow_65_636" result="shape" />
                                                        </filter>
                                                    </defs>
                                                </svg>
                                                Nilai Exam : 0
                                            </label>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" style="width: 75%"
                                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 text-center">
                                    <div class="btn btn-warning" style="cursor: auto">Menunggu Konfirmasi</div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
            <div class="tab-pane fade" id="list-selesai-ka" role="tabpanel" aria-labelledby="list-selesai-ka-list">
                <div id="selesai-ka-billing">
                    {{-- <div class="card br-10 mb-4" style="background-color: #f7f7f7">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-9">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <img src="/GambarV2/rectangle31.png" alt="" width="150px" class="br-10">
                                        </div>
                                        <div class="col-lg-8">
                                            <h5 class="m-0">Menerapkan Teknik Service Orientation dalam Pelayanan
                                                Pelanggan
                                                untuk Manajer
                                                Penjualan</h5>
                                            <label for="">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g filter="url(#filter0_d_65_636)">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M18.6667 3.11111C18.313 3.11111 17.9739 3.25159 17.7239 3.50164C17.4738 3.75168 17.3333 4.09082 17.3333 4.44444V5.33333H20V4.44444C20 4.09082 19.8595 3.75168 19.6095 3.50164C19.3594 3.25159 19.0203 3.11111 18.6667 3.11111ZM20 6.22222H17.3333V13.5556L18.6667 15.5556L20 13.5556V6.22222ZM4 1.33333V14.6667C4 15.0203 4.14048 15.3594 4.39052 15.6095C4.64057 15.8595 4.97971 16 5.33333 16H15.1111C15.4647 16 15.8039 15.8595 16.0539 15.6095C16.304 15.3594 16.4444 15.0203 16.4444 14.6667V1.33333C16.4444 0.979711 16.304 0.640573 16.0539 0.390524C15.8039 0.140476 15.4647 0 15.1111 0H5.33333C4.97971 0 4.64057 0.140476 4.39052 0.390524C4.14048 0.640573 4 0.979711 4 1.33333ZM10.2222 4C10.2222 3.88213 10.269 3.76908 10.3524 3.68573C10.4357 3.60238 10.5488 3.55556 10.6667 3.55556H14.2222C14.3401 3.55556 14.4531 3.60238 14.5365 3.68573C14.6198 3.76908 14.6667 3.88213 14.6667 4C14.6667 4.11787 14.6198 4.23092 14.5365 4.31427C14.4531 4.39762 14.3401 4.44444 14.2222 4.44444H10.6667C10.5488 4.44444 10.4357 4.39762 10.3524 4.31427C10.269 4.23092 10.2222 4.11787 10.2222 4ZM10.6667 5.33333C10.5488 5.33333 10.4357 5.38016 10.3524 5.46351C10.269 5.54686 10.2222 5.6599 10.2222 5.77778C10.2222 5.89565 10.269 6.0087 10.3524 6.09205C10.4357 6.1754 10.5488 6.22222 10.6667 6.22222H14.2222C14.3401 6.22222 14.4531 6.1754 14.5365 6.09205C14.6198 6.0087 14.6667 5.89565 14.6667 5.77778C14.6667 5.6599 14.6198 5.54686 14.5365 5.46351C14.4531 5.38016 14.3401 5.33333 14.2222 5.33333H10.6667ZM10.2222 9.77778C10.2222 9.6599 10.269 9.54686 10.3524 9.46351C10.4357 9.38016 10.5488 9.33333 10.6667 9.33333H14.2222C14.3401 9.33333 14.4531 9.38016 14.5365 9.46351C14.6198 9.54686 14.6667 9.6599 14.6667 9.77778C14.6667 9.89565 14.6198 10.0087 14.5365 10.092C14.4531 10.1754 14.3401 10.2222 14.2222 10.2222H10.6667C10.5488 10.2222 10.4357 10.1754 10.3524 10.092C10.269 10.0087 10.2222 9.89565 10.2222 9.77778ZM10.6667 11.1111C10.5488 11.1111 10.4357 11.1579 10.3524 11.2413C10.269 11.3246 10.2222 11.4377 10.2222 11.5556C10.2222 11.6734 10.269 11.7865 10.3524 11.8698C10.4357 11.9532 10.5488 12 10.6667 12H14.2222C14.3401 12 14.4531 11.9532 14.5365 11.8698C14.6198 11.7865 14.6667 11.6734 14.6667 11.5556C14.6667 11.4377 14.6198 11.3246 14.5365 11.2413C14.4531 11.1579 14.3401 11.1111 14.2222 11.1111H10.6667ZM6.66667 9.77778V11.1111H8V9.77778H6.66667ZM6.22222 8.88889H8.44444C8.56232 8.88889 8.67536 8.93571 8.75871 9.01906C8.84206 9.10241 8.88889 9.21546 8.88889 9.33333V11.5556C8.88889 11.6734 8.84206 11.7865 8.75871 11.8698C8.67536 11.9532 8.56232 12 8.44444 12H6.22222C6.10435 12 5.9913 11.9532 5.90795 11.8698C5.8246 11.7865 5.77778 11.6734 5.77778 11.5556V9.33333C5.77778 9.21546 5.8246 9.10241 5.90795 9.01906C5.9913 8.93571 6.10435 8.88889 6.22222 8.88889ZM9.20311 4.31422C9.28407 4.2304 9.32887 4.11813 9.32786 4.0016C9.32684 3.88507 9.2801 3.7736 9.1977 3.69119C9.11529 3.60879 9.00382 3.56205 8.88729 3.56103C8.77076 3.56002 8.65849 3.60482 8.57467 3.68578L7.11111 5.14933L6.53644 4.57467C6.45262 4.49371 6.34035 4.44891 6.22382 4.44992C6.10729 4.45093 5.99582 4.49768 5.91341 4.58008C5.83101 4.66248 5.78427 4.77396 5.78326 4.89049C5.78224 5.00702 5.82704 5.11929 5.908 5.20311L7.11111 6.40622L9.20311 4.31422Z"
                                                            fill="#0059F6" />
                                                    </g>
                                                    <defs>
                                                        <filter id="filter0_d_65_636" x="0" y="0" width="24" height="24"
                                                            filterUnits="userSpaceOnUse"
                                                            color-interpolation-filters="sRGB">
                                                            <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                                            <feColorMatrix in="SourceAlpha" type="matrix"
                                                                values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"
                                                                result="hardAlpha" />
                                                            <feOffset dy="4" />
                                                            <feGaussianBlur stdDeviation="2" />
                                                            <feComposite in2="hardAlpha" operator="out" />
                                                            <feColorMatrix type="matrix"
                                                                values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0" />
                                                            <feBlend mode="normal" in2="BackgroundImageFix"
                                                                result="effect1_dropShadow_65_636" />
                                                            <feBlend mode="normal" in="SourceGraphic"
                                                                in2="effect1_dropShadow_65_636" result="shape" />
                                                        </filter>
                                                    </defs>
                                                </svg>
                                                Nilai Exam : 0
                                            </label>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" style="width: 75%"
                                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 text-center">
                                    <div class="btn btn-success" style="cursor: auto">Selesai</div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
    {{-- Event Modal --}}
    <div class="modal fade" id="eventmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 id="eventtitle">Event Files</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="1%">No</th>
                                    <th>Keterangan</th>
                                    <th>File/link zoom</th>
                                </tr>
                            </thead>
                            <tbody id="bodyevent">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    let dataevent = [];

    function getkelasanda(status) {
        let s = 'Materi';
        let t = 3;
        let p = 0;
        if (status == 'dalam-progres-billing') {
            t = 0;
            s = 'Dalam Proses';
            p = 75;
        }
        if (status == 'konfirmasi-ka-billing') {
            t = 1;
            s = 'Menunggu Konfirmasi';
            p = 25;
        }
        if (status == 'selesai-ka-billing') {
            t = 2;
            s = 'Materi';
            p = 100;
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // loader transparant
        Swal.fire({
            background: '#0069d900',
            didOpen: () => {
                Swal.showLoading();
            }
        })
            $.ajax({
                url: '/getkelasanda/' + t,
                method: 'GET',
                success: function(response) {
                    let h = '';
                    if (response.status == 1) {
                        const dataevent = response.data.getkelasanda;

                        dataevent.forEach(v => {
                            // Format tanggal dan jam
                            let tglOrder = new Date(v.created_at).toLocaleDateString('id-ID');
                            let tglBayar = v.tgl_bayar ? new Date(v.tgl_bayar).toLocaleDateString('id-ID') : '-';
                            let tglSeminar = v.date_start ? new Date(v.date_start).toLocaleDateString('id-ID') : '-';
                            let jam = '-';
                            if (v.jam_acara) {
                                try {
                                    const d = new Date('1970-01-01T' + v.jam_acara);
                                    jam = d.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', hour12: false });
                                } catch (e) {
                                    jam = v.jam_acara;
                                }
                            }

                            // Tentukan lokasi dan kategori
                            let onlineOfflineLabel = '-';
                            let onlineOfflineContent = '-';

                            if (v.kategori == 0) {
                                onlineOfflineLabel = 'ONLINE';
                                onlineOfflineContent = '<i class="fa fa-video" aria-hidden="true"></i> <span style="font-size:17px;">Zoom Meet</span>';
                            } else if (v.kategori == 1) {
                                onlineOfflineLabel = 'OFFLINE';
                                if (v.lokasi) {
                                    onlineOfflineContent = `<a href="https://www.google.com/maps/place/${v.lokasi}" target="_blank" style="color: inherit; text-decoration: none; font-size: 17px;">
                                        <i class="fa fa-map-marker-alt" aria-hidden="true"></i> ${v.lokasi}
                                    </a>`;
                                } else {
                                    onlineOfflineContent = '<span class="badge badge-danger">Lokasi belum di tentukan</span>';
                                }
                            }

                            h += '<div class="card br-10 mb-4" style="background-color:#f7f7f7;">';
                            h += '  <div class="card-body">';
                            h += '    <div class="row align-items-start">';

                            // Gambar kiri
                            h += '      <div class="col-lg-4 text-center">';
                            h += '        <img src="' + v.image + '" alt="" width="150px" height="200px" class="br-10">';
                            h += '      </div>';

                            // Konten kanan
                            h += '      <div class="col-lg-8 d-flex flex-column justify-content-between" style="position:relative;">';
                            h += '        <div style="display:flex; flex-wrap:wrap;">';

                            h += '          <div class="col-md-4 mb-2">';
                            h += '              <p><strong>Event</strong><br><span style="font-size:16px;">' + v.title + '</span></p>';
                            h += '          </div>';

                            h += '          <div class="col-md-4 mb-2">';
                            if (v.narasumber) {
                                h += '              <p><strong>Narasumber</strong><br><span style="font-size:16px;">' + v.narasumber + '</span></p>';
                            } else {
                                h += '              <p><strong>Narasumber</strong><br><span class="badge badge-danger">Instructor belum tersedia</span></p>';
                            }
                            h += '          </div>';



                            h += '          <div class="col-md-4 mb-2">';
                            h += '              <p><strong>Tanggal</strong><br><span style="font-size:16px;">' + tglSeminar + '</span></p>';
                            h += '          </div>';

                            h += '          <div class="col-md-4 mb-2">';
                            h += '              <p><strong>Jam</strong><br><span style="font-size:16px;">' + jam + '</span></p>';
                            h += '          </div>';

                            h += '          <div class="col-md-4 mb-2">';
                            h += '              <p><strong>' + onlineOfflineLabel + '</strong><br><span style="font-size:16px;">' + onlineOfflineContent + '</span></p>';
                            h += '          </div>';

                            h += '        </div>'; 


                            h += '        <div style="display:flex; justify-content:flex-end;">';
                            if (t == 0) {
                                h += '          <div class="btn btn-success">' + s + '</div>';
                            } else {
                                h += '          <div class="btn btn-success" data-toggle="modal" data-target="#eventmodal" style="cursor:auto" onclick="setevent(`' + v.title + '`,' + v.id + ')">' + s + '</div>';
                            }
                            h += '        </div>';

                            h += '      </div>'; 
                            h += '    </div>'; 
                            h += '  </div>'; 
                            h += '</div>'; 
                        });

                        $('#' + status).html(h);
                    }
                    Swal.close();
                },
                error: function(response) {
                    console.log(response);
                    iziToast.warning({
                        title: 'Gagal',
                        message: 'Harap reload atau kontak admin',
                        position: 'topRight',
                    });
                    Swal.close()
                }
            });
        }

    function setevent(title, id_event) {
        console.log(dataevent);
        $('#eventtitle').html(title);
        let d = '';
        dataevent.forEach(e => {
            if (e.id == id_event) {
                if (e.events) {
                    let no = 1;
                    e.events.forEach(eev => {
                        d += '<tr>';
                        d += '    <td>' + no + '</td>';
                        d += '    <td>' + eev.title + '</td>';
                        if (eev.type == 3) {
                            d += '    <td><a href="' + eev.url + '" target="_blank">Link</a></td>';
                        } else {
                            d += '    <td><a href="/getBerkas?rf=' + eev.url + '" target="_blank">Download</a></td>';
                        }
                        d += '</tr>';
                        no++;
                    });
                }
            }
        });
        $('#bodyevent').html(d);
    }
</script>